<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Profile;
use App\Models\RapotSiswa;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use App\Models\TrackPerilaku;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BadgePencapaianSiswa;

class TrackRecordController extends Controller
{
    public function cariUser(Request $request)
    {
        $query = Profile::with(['user', 'kelas.jurusan']);

        // === FILTER NAMA ===
        if ($request->filled('nama')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama . '%');
        }

        // === FILTER KELAS ===
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $profiles = $query->paginate(10);

        // === HITUNG PERINGKAT ===
        $profiles = $profiles->through(function ($p) {

            $totalNilai = RapotSiswa::where('siswa_id', $p->user_id)->sum('nilai');

            // ambil total nilai semua siswa di kelas yang sama
            $semua = Profile::where('kelas_id', $p->kelas_id)->pluck('user_id');
            $ranking = RapotSiswa::select('siswa_id', DB::raw('SUM(nilai) as total'))
                ->whereIn('siswa_id', $semua)
                ->groupBy('siswa_id')
                ->orderByDesc('total')
                ->get();

            $posisi = $ranking->search(fn($x) => $x->siswa_id == $p->user_id) + 1;
            $jumlah = $ranking->count();

            $p->peringkat = $posisi;
            $p->jumlah_siswa = $jumlah;
            $p->total_nilai = $totalNilai;
            return $p;
        });

        $kelasList = Kelas::with('jurusan')->get();

        return view('LMS.Dashboard.profileSiswaDashboard', compact('profiles', 'kelasList'));
    }

    public function detailUser($id)
    {
        $user = User::with('profile.kelas')->findOrFail($id);
        $profile = $user->profile;

        $rapot = RapotSiswa::with('mapel')->where('siswa_id', $user->id)->get();
        $chartLabels = $rapot->pluck('mapel.nama_mapel');
        $chartData = $rapot->pluck('nilai');

        $query = TrackPerilaku::with('guru')->where('siswa_id', $id)->orderBy('tanggal', 'desc');
        $trackRecords = $query->paginate(10);
        $gurus = User::where('role', 'guru')->get();

        $kursuses = Kursus::with(['mapel', 'guru', 'tugas.soals'])
            ->where('kelas_id', $profile->kelas_id)
            ->get()
            ->map(function ($kursus) use ($user) {
                $totalSoal = $kursus->tugas->flatMap->soals->count();
                $soalDijawab = JawabanSiswa::whereHas('soal.tugas', fn($q) =>
                $q->where('kursus_id', $kursus->id))
                    ->where('siswa_id', $user->id)
                    ->distinct('soal_id')
                    ->count();
                $progress = $totalSoal > 0 ? round(($soalDijawab / $totalSoal) * 100) : 0;
                $colors = [
                    'bg-purple-100 text-purple-600',
                    'bg-blue-100 text-blue-600',
                    'bg-green-100 text-green-600',
                    'bg-pink-100 text-pink-600',
                    'bg-yellow-100 text-yellow-600',
                ];
                return [
                    'id' => $kursus->id,
                    'nama' => $kursus->nama_kursus,
                    'mapel' => $kursus->mapel->nama_mapel ?? '-',
                    'guru' => $kursus->guru->nama_lengkap ?? '-',
                    'progress' => $progress,
                    'warna' => $colors[array_rand($colors)],
                ];
            });

        $totalKursus = $kursuses->count();
        $kursusSelesai = $kursuses->where('progress', 100)->count();

        $kelas = $profile->kelas;
        $siswaSeangkatan = Profile::with('user')
            ->whereHas(
                'kelas',
                fn($q) =>
                $q->where('tingkat', $kelas->tingkat)
                    ->where('jurusan_id', $kelas->jurusan_id)
                    ->where('urutan_kelas', $kelas->urutan_kelas)
            )->get();

        $rankingData = $siswaSeangkatan->map(fn($s) => [
            'user_id' => $s->user_id,
            'total_nilai' => RapotSiswa::where('siswa_id', $s->user_id)->sum('nilai'),
        ])->sortByDesc('total_nilai')->values();

        $peringkatUser = $rankingData->search(fn($i) => $i['user_id'] == $user->id) + 1;
        $totalSiswa = $rankingData->count();

        $profilAktif = DB::table('profiles')
            ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
            ->where('profiles.user_id', $user->id)
            ->select('profiles.kelas_id', 'kelas.tingkat', 'kelas.jurusan_id', 'kelas.urutan_kelas')
            ->first();

        $siswaIdsSatuKelas = DB::table('profiles')
            ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
            ->where('kelas.tingkat', $profilAktif->tingkat)
            ->where('kelas.jurusan_id', $profilAktif->jurusan_id)
            ->where('kelas.urutan_kelas', $profilAktif->urutan_kelas)
            ->pluck('profiles.user_id');

        $classTotal = $siswaIdsSatuKelas->count();

        $totalRapotPerSiswa = DB::table('rapot_siswas')
            ->whereIn('siswa_id', $siswaIdsSatuKelas)
            ->select('siswa_id', DB::raw('SUM(nilai) AS total_rapot'))
            ->groupBy('siswa_id')
            ->orderByDesc('total_rapot')
            ->get();

        $rankingKelas = $totalRapotPerSiswa->values()->map(function ($r, $i) {
            $r->rank = $i + 1;
            return $r;
        });

        $current = $rankingKelas->firstWhere('siswa_id', $user->id);
        $rankNumber = $current->rank ?? null;
        $totalSkorSiswa = $current->total_rapot ?? 0;

        $avgJawaban = round(DB::table('jawaban_siswas')->where('siswa_id', $user->id)->avg('nilai') ?? 0, 2);
        $avgRapot = round(DB::table('rapot_siswas')->where('siswa_id', $user->id)->avg('nilai') ?? 0, 2);

        $historyRapot = DB::table('rapot_siswas')
            ->where('siswa_id', $user->id)
            ->orderByDesc('updated_at')
            ->limit(2)
            ->pluck('nilai');

        $improvement = 0.0;
        if ($historyRapot->count() === 2) {
            $improvement = round(((float)$historyRapot[0]) - ((float)$historyRapot[1]), 2);
        }

        $nilaiPerMapel = DB::table('rapot_siswas')
            ->join('mapels', 'rapot_siswas.mapel_id', '=', 'mapels.id')
            ->where('rapot_siswas.siswa_id', $user->id)
            ->select('mapels.nama_mapel', 'rapot_siswas.nilai')
            ->get()
            ->map(function ($n) {
                $v = (float)$n->nilai;
                if ($v >= 90) {
                    $n->grade = 'A';
                    $n->kategori = 'Sangat Baik';
                } elseif ($v >= 85) {
                    $n->grade = 'A-';
                    $n->kategori = 'Sangat Baik';
                } elseif ($v >= 80) {
                    $n->grade = 'B+';
                    $n->kategori = 'Baik';
                } elseif ($v >= 75) {
                    $n->grade = 'B';
                    $n->kategori = 'Baik';
                } elseif ($v >= 70) {
                    $n->grade = 'C+';
                    $n->kategori = 'Cukup';
                } else {
                    $n->grade = 'C';
                    $n->kategori = 'Perlu Perbaikan';
                }
                return $n;
            });

        $trenNilai = DB::table('jawaban_siswas')
            ->where('siswa_id', $user->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as periode, ROUND(AVG(nilai), 2) as rata_rata')
            ->groupBy('periode')
            ->orderByDesc('periode')
            ->limit(3)
            ->get()
            ->reverse()
            ->values();

        $badges = BadgePencapaianSiswa::with('badgePencapaian.kategoriPencapaian')
            ->where('siswa_id', $user->id)
            ->get()
            ->map(fn($b) => [
                'nama' => $b->badgePencapaian->nama_pencapaian,
                'kategori' => $b->badgePencapaian->kategoriPencapaian->nama_pencapaian ?? '-',
                'ikon' => $b->badgePencapaian->gambar,
            ]);

        $topRanking = $rankingKelas->take(3)->map(function ($r) {
            $p = DB::table('profiles')->where('user_id', $r->siswa_id)->select('nama_lengkap')->first();
            $r->nama_lengkap = $p->nama_lengkap ?? 'Siswa';
            return $r;
        });

        return view('LMS.Dashboard.profileSiswaDashboardDetail', compact(
            'user',
            'profile',
            'chartLabels',
            'chartData',
            'kursuses',
            'kursusSelesai',
            'totalKursus',
            'peringkatUser',
            'totalSiswa',
            'badges',
            'avgJawaban',
            'avgRapot',
            'improvement',
            'rankNumber',
            'classTotal',
            'totalSkorSiswa',
            'nilaiPerMapel',
            'trenNilai',
            'topRanking',
            'trackRecords',
            'gurus'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'guru_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            TrackPerilaku::create($validated);
            DB::commit();
            return back()->with('success', 'Track record berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan data.');
        }
    }

    public function edit($id)
    {
        $record = TrackPerilaku::findOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = TrackPerilaku::findOrFail($id);

        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $record->update($validated);
            DB::commit();
            return back()->with('success', 'Track record berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            TrackPerilaku::where('id', $id)->delete();
            DB::commit();
            return back()->with('success', 'Track record berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
