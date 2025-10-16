<?php

namespace App\Http\Controllers\LMS;

use App\Models\Tugas;
use App\Models\Kursus;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use App\Models\TrackPerilaku;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\BadgePencapaianSiswa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasUser = $user->profile->kelas; // relasi ke model Kelas
        $tingkat = $kelasUser->tingkat;

        $totalKursus = Kursus::where('kelas_id', $kelasUser->id)->count();

        $tugasBelumSelesai = Tugas::whereHas('kursus', function ($q) use ($kelasUser) {
            $q->where('kelas_id', $kelasUser->id);
        })
            ->whereDoesntHave('soals.jawabanSiswas', function ($q) use ($user) {
                $q->where('siswa_id', $user->id);
            })
            ->count();

        $tugasMendatang = Tugas::with('kursus.mapel')
            ->whereHas('kursus', function ($q) use ($kelasUser) {
                $q->where('kelas_id', $kelasUser->id);
            })
            ->where('batas_pengumpulan', '>=', Carbon::now())
            ->orderBy('batas_pengumpulan', 'asc')
            ->take(3)
            ->get();

        $progressKursus = Kursus::where('kelas_id', $kelasUser->id)
            ->withCount('tugas')
            ->get()
            ->map(function ($kursus) use ($user) {
                $total = $kursus->tugas_count ?: 1;

                // Hitung jumlah tugas yang sudah ada jawaban siswanya
                $tugasSelesai = \App\Models\Tugas::where('kursus_id', $kursus->id)
                    ->whereHas('soals.jawabanSiswas', function ($q) use ($user) {
                        $q->where('siswa_id', $user->id);
                    })
                    ->distinct('id')
                    ->count('id');

                $persen = min(100, round(($tugasSelesai / $total) * 100));

                return [
                    'nama' => $kursus->nama_kursus,
                    'mapel' => $kursus->mapel->nama_mapel ?? '-',
                    'selesai' => $tugasSelesai,
                    'total' => $total,
                    'progress' => $persen
                ];
            });



        $tugasBaru = Tugas::whereHas('kursus', fn($q) => $q->where('kelas_id', $user->profile->kelas_id))
            ->with('kursus.mapel')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($t) => [
                'icon' => 'fa-file-alt',
                'warna' => 'blue',
                'judul' => 'Tugas Baru',
                'deskripsi' => $t->nama_tugas . ' (' . ($t->kursus->mapel->nama_mapel ?? '-') . ')',
                'waktu' => $t->created_at->diffForHumans(),
                'created_at' => $t->created_at,
            ]);

        $tugasSelesai = JawabanSiswa::where('siswa_id', $user->id)
            ->with('soal.tugas')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($j) => [
                'icon' => 'fa-check-circle',
                'warna' => 'green',
                'judul' => 'Tugas Selesai',
                'deskripsi' => $j->soal->tugas->nama_tugas ?? '-',
                'waktu' => $j->created_at->diffForHumans(),
                'created_at' => $j->created_at,
            ]);

        $badgeBaru = BadgePencapaianSiswa::where('siswa_id', $user->id)
            ->with('badgePencapaian')
            ->latest()
            ->take(2)
            ->get()
            ->map(fn($b) => [
                'icon' => 'fa-trophy',
                'warna' => 'yellow',
                'judul' => 'Badge Baru',
                'deskripsi' => $b->badgePencapaian->nama_pencapaian ?? '-',
                'waktu' => $b->created_at->diffForHumans(),
                'created_at' => $b->created_at,
            ]);

        $totalPerilaku = \App\Models\TrackPerilaku::where('siswa_id', $user->id)->count();


        $catatanPerilaku = TrackPerilaku::where('siswa_id', $user->id)
            ->with('guru')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($p) => [
                'icon' => 'fa-clipboard-list',
                'warna' => 'red',
                'judul' => 'Catatan Perilaku',
                'deskripsi' => 'Dari ' . $p->guru->nama_lengkap . ': ' . \Illuminate\Support\Str::limit($p->catatan, 60),
                'waktu' => $p->created_at->diffForHumans(),
                'created_at' => $p->created_at,
            ]);

        $aktivitasTerbaru = $tugasBaru
            ->merge($tugasSelesai)
            ->merge($badgeBaru)
            ->merge($catatanPerilaku)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();


        $siswaSeangkatan = Profile::whereHas('kelas', function ($q) use ($tingkat) {
            $q->where('tingkat', $tingkat);
        })
            ->with('user')
            ->get();

        $rankingData = collect();

        foreach ($siswaSeangkatan as $s) {
            $totalNilai = JawabanSiswa::where('siswa_id', $s->user_id)->sum('nilai');
            $rankingData->push([
                'user_id' => $s->user_id,
                'nama' => $s->nama_lengkap,
                'total_nilai' => $totalNilai
            ]);
        }

        $rankingData = $rankingData->sortByDesc('total_nilai')->values();
        $peringkatUser = $rankingData->search(fn($item) => $item['user_id'] === $user->id) + 1;
        $totalSiswa = $rankingData->count();

        return view('LMS.dashboard', compact(
            'user',
            'totalKursus',
            'tugasBelumSelesai',
            'tugasMendatang',
            'progressKursus',
            'aktivitasTerbaru',
            'peringkatUser',
            'totalSiswa',
            'totalPerilaku'
        ));
    }
}
