<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // -------- 1) Profil & Kelas aktif (untuk filter 3 kunci: tingkat, jurusan_id, urutan_kelas)
        $profilAktif = DB::table('profiles')
            ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
            ->where('profiles.user_id', $user->id)
            ->select([
                'profiles.user_id',
                'profiles.kelas_id',
                'profiles.nama_lengkap',
                'kelas.tingkat',
                'kelas.jurusan_id',
                'kelas.urutan_kelas',
            ])
            ->first();

        // Guard: jika belum punya profil/kelas, tampilkan nilai default kosong
        if (!$profilAktif) {
            return view('LMS.nilai', [
                'avgNilai'       => 0,
                'avgSemester'    => 0,
                'improvement'    => 0,
                'rankNumber'     => null,
                'classTotal'     => 0,
                'nilaiPerMapel'  => collect(),
                'trenNilai'      => collect(),
                'badges'         => collect(),
                'topRanking'     => collect(),
                'totalSkorSiswa' => 0,
            ]);
        }

        // -------- 2) Cari seluruh siswa yang KELAS-nya punya 3 kunci yang sama
        $siswaIdsSatuKelas = DB::table('profiles')
            ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
            ->where('kelas.tingkat', $profilAktif->tingkat)
            ->where('kelas.jurusan_id', $profilAktif->jurusan_id)
            ->where('kelas.urutan_kelas', $profilAktif->urutan_kelas)
            ->pluck('profiles.user_id'); // daftar siswa_id pembanding

        $classTotal = $siswaIdsSatuKelas->count();

        // -------- 3) TOTAL NILAI PER SISWA (SUM dari rapot_siswas semua mapel)
        //    Perintah ini menghasilkan total_rapot untuk SETIAP siswa di kelas pembanding
        $totalRapotPerSiswa = DB::table('rapot_siswas')
            ->whereIn('siswa_id', $siswaIdsSatuKelas)
            ->select('siswa_id', DB::raw('SUM(nilai) AS total_rapot'))
            ->groupBy('siswa_id')
            ->orderByDesc('total_rapot')
            ->get();

        // Ranking (dense by collection index saja sudah cukup, karena sorting sudah desc)
        $rankingKelas = $totalRapotPerSiswa->values()->map(function ($row, $idx) {
            $row->rank = $idx + 1;
            return $row;
        });

        $current = $rankingKelas->firstWhere('siswa_id', $user->id);
        $rankNumber     = $current->rank ?? null;
        $totalSkorSiswa = $current->total_rapot ?? 0;
        // -------- 4) Widget: Rata-rata Nilai Harian (dari jawaban_siswas)
        $avgJawaban = (float) DB::table('jawaban_siswas')
            ->where('siswa_id', $user->id)
            ->avg('nilai');

        // Normalisasi: kalau 0/1 maka ubah ke 0–100 skala persen
        if ($avgJawaban <= 1) {
            $avgJawaban = round($avgJawaban * 100, 1);
        }

        // Batasi agar tidak lebih dari 100
        $avgJawaban = min(max($avgJawaban, 0), 100);


        // -------- 5) Widget: Rata-rata Semester (dari rapot_siswas)
        $avgRapot = (float) DB::table('rapot_siswas')
            ->where('siswa_id', $user->id)
            ->avg('nilai');

        // Pastikan dalam skala 0–100
        $avgRapot = min(max(round($avgRapot, 1), 0), 100);


        // -------- 6) Widget: Perkembangan Nilai (dari 2 entri terakhir di rapot_siswas)
        $historyRapot = DB::table('rapot_siswas')
            ->where('siswa_id', $user->id)
            ->orderByDesc('updated_at')
            ->limit(2)
            ->pluck('nilai');

        $improvement = 0.0;
        if ($historyRapot->count() === 2) {
            $prev = (float) $historyRapot[1];
            $curr = (float) $historyRapot[0];

            // selisih antar nilai
            $diff = $curr - $prev;

            // persentase perubahan (kalau prev tidak nol)
            if ($prev > 0) {
                $improvement = round(($diff / $prev) * 100, 1);
            } else {
                $improvement = $diff;
            }
        }
        // -------- 7) Nilai per Mapel (rapot_siswas + mapels)
        $nilaiPerMapel = DB::table('rapot_siswas')
            ->join('mapels', 'rapot_siswas.mapel_id', '=', 'mapels.id')
            ->where('rapot_siswas.siswa_id', $user->id)
            ->select('mapels.nama_mapel', 'rapot_siswas.nilai')
            ->get()
            ->map(function ($row) {
                $n = (float) $row->nilai;
                if ($n >= 90) {
                    $row->grade = 'A';
                    $row->kategori = 'Sangat Baik';
                } elseif ($n >= 85) {
                    $row->grade = 'A-';
                    $row->kategori = 'Sangat Baik';
                } elseif ($n >= 80) {
                    $row->grade = 'B+';
                    $row->kategori = 'Baik';
                } elseif ($n >= 75) {
                    $row->grade = 'B';
                    $row->kategori = 'Baik';
                } elseif ($n >= 70) {
                    $row->grade = 'C+';
                    $row->kategori = 'Cukup';
                } else {
                    $row->grade = 'C';
                    $row->kategori = 'Perlu Perbaikan';
                }
                return $row;
            });

        // -------- 8) Tren Nilai (3 periode terakhir dari jawaban_siswas)
        $trenNilai = DB::table('jawaban_siswas')
            ->where('siswa_id', $user->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as periode, ROUND(AVG(nilai), 2) as rata_rata')
            ->groupBy('periode')
            ->orderByDesc('periode')
            ->limit(3)
            ->get()
            ->reverse()
            ->values();

        // -------- 9) Pencapaian (badge & sertifikat)
        $badges = DB::table('badge_pencapaian_siswas')
            ->join('badge_pencapaians', 'badge_pencapaian_siswas.badge_pencapaian_id', '=', 'badge_pencapaians.id')
            ->join('kategori_pencapaians', 'badge_pencapaians.kategori_pencapaian_id', '=', 'kategori_pencapaians.id')
            ->where('badge_pencapaian_siswas.siswa_id', $user->id)
            ->select([
                'badge_pencapaians.nama_pencapaian',
                'kategori_pencapaians.nama_pencapaian as kategori',
                'badge_pencapaians.gambar'
            ])
            ->get();



        // -------- 10) Top 3 Ranking (dengan nama siswa dari profiles)
        $topRanking = $rankingKelas->take(3)->map(function ($row) {
            $p = DB::table('profiles')->where('user_id', $row->siswa_id)->select('nama_lengkap')->first();
            $row->nama_lengkap = $p->nama_lengkap ?? 'Siswa';
            return $row;
        });


        // -------- RETURN
        return view('LMS.nilai', [
            // Banner & cards
            'avgNilai'       => $avgJawaban,
            'avgSemester'    => $avgRapot,
            'improvement'    => $improvement,
            'rankNumber'     => $rankNumber,
            'classTotal'     => $classTotal,
            'totalSkorSiswa' => $totalSkorSiswa,

            // Section: nilai mapel + tren + pencapaian + ranking
            'nilaiPerMapel'  => $nilaiPerMapel,
            'trenNilai'      => $trenNilai,
            'badges'         => $badges,
            'topRanking'     => $topRanking,

            // Info kelas untuk judul
            'kelasInfo'      => (object)[
                'tingkat'      => $profilAktif->tingkat,
                'jurusan_id'   => $profilAktif->jurusan_id,
                'urutan_kelas' => $profilAktif->urutan_kelas,
            ],
        ]);
    }
}
