<?php

namespace App\Http\Controllers\LMS;

use App\Models\Tugas;
use App\Models\Kursus;
use App\Models\RapotSiswa;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KursusController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelas = $user->profile->kelas;
        $kelasId = $kelas->id;

        $kursuses = \App\Models\Kursus::with(['mapel', 'tugas.soals', 'kelas.jurusan'])
            ->where('kelas_id', $kelasId)
            ->paginate(6)
            ->through(function ($kursus) use ($user) {

                $totalSoal = $kursus->tugas->flatMap->soals->count();
                $soalSelesai = \App\Models\JawabanSiswa::where('siswa_id', $user->id)
                    ->whereHas('soal.tugas', fn($q) => $q->where('kursus_id', $kursus->id))
                    ->distinct('soal_id')
                    ->count();

                $progress = $totalSoal > 0 ? round(($soalSelesai / $totalSoal) * 100) : 0;

                $iconMap = [
                    'Bahasa Indonesia' => ['svg' => 'fa-book-open', 'color' => 'red', 'gradient' => 'from-red-400 to-red-600'],
                    'Matematika' => ['svg' => 'fa-chart-bar', 'color' => 'blue', 'gradient' => 'from-blue-400 to-blue-600'],
                    'Fisika' => ['svg' => 'fa-atom', 'color' => 'yellow', 'gradient' => 'from-yellow-400 to-yellow-600'],
                    'Kimia' => ['svg' => 'fa-flask', 'color' => 'green', 'gradient' => 'from-green-400 to-green-600'],
                    'Rekayasa Perangkat Lunak' => ['svg' => 'fa-code', 'color' => 'purple', 'gradient' => 'from-purple-400 to-purple-600'],
                    'default' => ['svg' => 'fa-graduation-cap', 'color' => 'gray', 'gradient' => 'from-gray-400 to-gray-600']
                ];

                $mapelName = $kursus->mapel->nama_mapel ?? 'default';
                $icon = $iconMap[$mapelName] ?? $iconMap['default'];

                return [
                    'id' => $kursus->id,
                    'nama' => $kursus->nama_kursus,
                    'mapel' => $mapelName,
                    'deskripsi' => str($kursus->isi_kursus)->limit(100),
                    'progress' => $progress,
                    'icon' => $icon['svg'],
                    'color' => $icon['color'],
                    'gradient' => $icon['gradient']
                ];
            });


        return view('LMS.kursus', compact('kursuses'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $kursus = Kursus::with(['mapel', 'tugas.soals'])->findOrFail($id);


        $tugasList = $kursus->tugas->map(function ($tugas) use ($user) {
            $totalSoal = $tugas->soals->count();

            $soalSelesai = JawabanSiswa::where('siswa_id', $user->id)
                ->whereHas('soal', fn($q) => $q->where('tugas_id', $tugas->id))
                ->distinct('soal_id')
                ->count();

            $selesai = $totalSoal > 0 && $soalSelesai >= $totalSoal;

            return [
                'id' => $tugas->id,
                'nama' => $tugas->nama_tugas,
                'deadline' => $tugas->batas_pengumpulan?->format('d-m-Y') ?? '-',
                'selesai' => $selesai,
            ];
        });

        return view('LMS.kursusDetail', compact('kursus', 'tugasList'));
    }

    public function showTugas($id)
    {
        $user = Auth::user();
        $tugas = Tugas::with('soals')->findOrFail($id);

        // Cek apakah sudah dikerjakan
        $jawabanSiswa = JawabanSiswa::where('siswa_id', $user->id)
            ->whereIn('soal_id', $tugas->soals->pluck('id'))
            ->get()
            ->keyBy('soal_id'); // biar cepat akses per soal

        $sudahDikerjakan = $jawabanSiswa->isNotEmpty();

        $totalSoal = $tugas->soals->count();
        $benar = $jawabanSiswa->where('nilai', 1)->count();
        $nilai = $totalSoal > 0 ? round(($benar / $totalSoal) * 100) : 0;

        // Buat array hasil agar blade langsung bisa pakai
        $hasilDetail = [];
        foreach ($tugas->soals as $soal) {
            $jawaban = $jawabanSiswa->get($soal->id);
            $hasilDetail[$soal->id] = [
                'jawaban_user'  => $jawaban->jawaban_dipilih ?? null,
                'jawaban_benar' => strtoupper(substr($soal->jawaban_benar, -1)), // ambil huruf C dari opsi_c
                'status'        => $jawaban && $jawaban->nilai == 1 ? 'benar' : 'salah',
            ];
        }

        return view('LMS.tugasDetail', compact(
            'tugas',
            'sudahDikerjakan',
            'user',
            'totalSoal',
            'benar',
            'nilai',
            'hasilDetail'
        ));
    }


    public function submit(Request $request, $tugas_id)
    {
        // Log::error($request->all());
        $user = Auth::user();
        $tugas = Tugas::with(['soals', 'kursus.mapel'])->findOrFail($tugas_id);

        $existing = JawabanSiswa::where('siswa_id', $user->id)
            ->whereIn('soal_id', $tugas->soals->pluck('id'))
            ->exists();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengerjakan tugas ini sebelumnya.'
            ]);
        }

        $jawabanUser = collect($request->jawaban);
        $benar = 0;
        $hasilDetail = [];

        foreach ($tugas->soals as $soal) {
            $jawab = $jawabanUser->firstWhere('soal_id', $soal->id);
            $opsiUser = $jawab['jawaban'] ?? null;
            $isBenar = strtolower($soal->jawaban_benar) === 'opsi_' . strtolower($opsiUser);

            $hasilDetail[] = [
                'soal_id'       => $soal->id,
                'jawaban_user'  => $opsiUser,
                'jawaban_benar' => strtoupper(substr($soal->jawaban_benar, -1)),
                'status'        => $isBenar ? 'benar' : 'salah',
            ];

            JawabanSiswa::updateOrCreate(
                [
                    'siswa_id' => $user->id,
                    'soal_id'  => $soal->id,
                ],
                [
                    'jawaban_dipilih' => $opsiUser,
                    'nilai'           => $isBenar ? 1 : 0,
                ]
            );

            if ($isBenar) $benar++;
        }

        $total = $tugas->soals->count();
        $nilaiTugas = $total > 0 ? round(($benar / $total) * 100) : 0;

        $mapelId = $tugas->kursus->mapel->id ?? null;
        if ($mapelId) {
            $nilaiTugasMapel = DB::table('tugas')
                ->join('soals', 'soals.tugas_id', '=', 'tugas.id')
                ->join('jawaban_siswas', 'jawaban_siswas.soal_id', '=', 'soals.id')
                ->join('kursuses', 'tugas.kursus_id', '=', 'kursuses.id')
                ->where('kursuses.mapel_id', $mapelId)
                ->where('jawaban_siswas.siswa_id', $user->id)
                ->select(
                    'tugas.id',
                    DB::raw('SUM(jawaban_siswas.nilai) AS total_benar'),
                    DB::raw('COUNT(soals.id) AS total_soal')
                )
                ->groupBy('tugas.id')
                ->get()
                ->map(fn($r) => $r->total_soal > 0 ? round(($r->total_benar / $r->total_soal) * 100) : 0);

            $rataRataMapel = $nilaiTugasMapel->count() > 0
                ? round($nilaiTugasMapel->avg())
                : $nilaiTugas;

            RapotSiswa::updateOrCreate(
                [
                    'siswa_id' => $user->id,
                    'mapel_id' => $mapelId,
                ],
                [
                    'nilai' => $rataRataMapel,
                ]
            );
        }
        event(new \App\Events\ProgressUpdated(Auth::user()));


        return response()->json([
            'success' => true,
            'benar'   => $benar,
            'total'   => $total,
            'nilai'   => $nilaiTugas,
            'hasil'   => $hasilDetail,
        ]);
    }
}
