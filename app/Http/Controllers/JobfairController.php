<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kursus;
use App\Models\Profile;
use App\Models\OrderItem;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use App\Models\RapotSiswa;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use App\Models\MelamarPekerjaan;
use Illuminate\Support\Facades\DB;
use App\Models\BadgePencapaianSiswa;

class JobfairController extends Controller
{
    public function index()
    {
        return view("jobfair.landing.index");
    }


    public function showDashboard()
    {
        $totalPerusahaan = Perusahaan::count();
        $totalPekerjaan = Pekerjaan::count();
        $totalLamaran = MelamarPekerjaan::count();

        $latestPekerjaans = Pekerjaan::with('perusahaan')
            ->latest()
            ->take(5)
            ->get();

        $latestLamaran = MelamarPekerjaan::with('pekerjaan', 'pelamar')
            ->latest()
            ->take(5)
            ->get();

        return view('jobfair.dashboard.index', compact(
            'totalPerusahaan',
            'totalPekerjaan',
            'totalLamaran',
            'latestPekerjaans',
            'latestLamaran'
        ));
    }

    public function showPerusahaan()
    {
        return view("jobfair.dashboard.perusahaan");
    }

    public function showPekerjaan()
    {
        return view("jobfair.dashboard.pekerjaan");
    }

    public function showLamaran()
    {
        return view("jobfair.dashboard.lamaran");
    }

    public function showJobfair($id)
    {
        $pekerjaan = Pekerjaan::with('perusahaan')->findOrFail($id);
        return view("jobfair.landing.detail-job", ['pekerjaan' => $pekerjaan]);
    }

    public function showProfil()
    {
        $user = auth()->user();

        $lamarans = MelamarPekerjaan::with('pekerjaan', 'pelamar')
            ->where('pelamar_id', $user->id)
            ->get();

        return view("jobfair.landing.detail-profil", ['lamarans' => $lamarans]);
    }

    public function showMelamar($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        return view('jobfair.landing.melamar', compact('pekerjaan'));
    }

    public function storeMelamar(Request $request, $id)
    {
        $request->validate([
            'berkas.*' => 'required|max:10048',
        ]);

        $files = [];
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('berkas_lamaran', $filename, 'public');
                $files[] = $filename;
            }
        }

        try {
            MelamarPekerjaan::create([
                'pekerjaan_id' => $id,
                'pelamar_id' => auth()->id(),
                'berkas_yang_dibutuhkan' => json_encode($files),
                'status' => 'pending',
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('jobfair.lamaran.berhasil');
    }

    public function lamaranBerhasil()
    {
        return view('jobfair.landing.berhasil-lamaran');
    }

    public function showdetailjobfair($pekerjaanId, $id)
    {
        // ambil user + profile + kelas agar minimal query
        $user = User::with('profile.kelas')->findOrFail($id);
        $profile = $user->profile;

        // guard kalau profile/kelas tidak ada
        if (!$profile) {
            abort(404, 'Profile siswa tidak ditemukan.');
        }
        if (!$profile->kelas) {
            // fallback: set kelas null atau abort tergantung kebutuhan
            $kelas = null;
        } else {
            $kelas = $profile->kelas;
        }

        // RAPOT (detail per mapel untuk chart)
        $rapotCollection = RapotSiswa::with('mapel')
            ->where('siswa_id', $user->id)
            ->get();

        $chartLabels = $rapotCollection->pluck('mapel.nama_mapel');
        $chartData = $rapotCollection->pluck('nilai');

        // KURSUS -> eager load tugas & soal supaya tidak N+1
        $kursuses = Kursus::with(['mapel', 'guru', 'tugas.soals'])
            ->when($profile->kelas_id, fn($q) => $q->where('kelas_id', $profile->kelas_id))
            ->get()
            ->map(function ($kursus) use ($user) {
                // hitung total soal via collection yang sudah di-eager load
                $totalSoal = $kursus->tugas->flatMap(fn($t) => $t->soals)->count();

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

        // Siswa seangkatan (pastikan relasi kelas ada)
        $siswaSeangkatan = collect();
        if ($kelas) {
            $siswaSeangkatan = Profile::with('user')
                ->whereHas(
                    'kelas',
                    fn($q) =>
                    $q->where('tingkat', $kelas->tingkat)
                        ->where('jurusan_id', $kelas->jurusan_id)
                        ->where('urutan_kelas', $kelas->urutan_kelas)
                )->get();
        }

        // Ranking (aggregate total nilai)
        $rankingData = $siswaSeangkatan->map(fn($s) => [
            'user_id' => $s->user_id,
            'total_nilai' => RapotSiswa::where('siswa_id', $s->user_id)->sum('nilai'),
        ])->sortByDesc('total_nilai')->values();

        $peringkatUser = $rankingData->search(fn($i) => $i['user_id'] == $user->id);
        $peringkatUser = $peringkatUser === false ? null : $peringkatUser + 1;
        $totalSiswa = $rankingData->count();

        // Profil aktif (DB query tetap ok)
        $profilAktif = DB::table('profiles')
            ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
            ->where('profiles.user_id', $user->id)
            ->select('profiles.kelas_id', 'kelas.tingkat', 'kelas.jurusan_id', 'kelas.urutan_kelas')
            ->first();

        // Ambil siswa satu kelas (cek profilAktif)
        $siswaIdsSatuKelas = collect();
        $classTotal = 0;
        if ($profilAktif) {
            $siswaIdsSatuKelas = DB::table('profiles')
                ->join('kelas', 'profiles.kelas_id', '=', 'kelas.id')
                ->where('kelas.tingkat', $profilAktif->tingkat)
                ->where('kelas.jurusan_id', $profilAktif->jurusan_id)
                ->where('kelas.urutan_kelas', $profilAktif->urutan_kelas)
                ->pluck('profiles.user_id');

            $classTotal = $siswaIdsSatuKelas->count();
        }

        // Ranking kelas berdasarkan total rapot (DB aggregate)
        $totalRapotPerSiswa = collect();
        if ($siswaIdsSatuKelas->isNotEmpty()) {
            $totalRapotPerSiswa = DB::table('rapot_siswas')
                ->whereIn('siswa_id', $siswaIdsSatuKelas)
                ->select('siswa_id', DB::raw('SUM(nilai) AS total_rapot'))
                ->groupBy('siswa_id')
                ->orderByDesc('total_rapot')
                ->get();
        }

        $rankingKelas = $totalRapotPerSiswa->values()->map(function ($r, $i) {
            $r->rank = $i + 1;
            return $r;
        });

        $current = $rankingKelas->firstWhere('siswa_id', $user->id);
        $rankNumber = $current->rank ?? null;
        $totalSkorSiswa = $current->total_rapot ?? 0;

        // rata-rata jawaban & rapot (gunakan $user->id bukan auth)
        $avgJawaban = round(DB::table('jawaban_siswas')->where('siswa_id', $user->id)->avg('nilai') ?? 0, 2);
        $avgRapotSummary = RapotSiswa::where('siswa_id', $user->id)
            ->selectRaw('AVG(nilai) as rata_rata, COUNT(*) as jumlah_mapel')
            ->first();

        // history rapot -> improvement
        $historyRapot = DB::table('rapot_siswas')
            ->where('siswa_id', $user->id)
            ->orderByDesc('updated_at')
            ->limit(2)
            ->pluck('nilai');

        $improvement = 0.0;
        if ($historyRapot->count() === 2) {
            $improvement = round(((float) $historyRapot[0]) - ((float) $historyRapot[1]), 2);
        }

        // nilai per mapel -> grading
        $nilaiPerMapel = DB::table('rapot_siswas')
            ->join('mapels', 'rapot_siswas.mapel_id', '=', 'mapels.id')
            ->where('rapot_siswas.siswa_id', $user->id)
            ->select('mapels.nama_mapel', 'rapot_siswas.nilai')
            ->get()
            ->map(function ($n) {
                $v = (float) $n->nilai;
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

        // tren nilai
        $trenNilai = DB::table('jawaban_siswas')
            ->where('siswa_id', $user->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as periode, ROUND(AVG(nilai), 2) as rata_rata')
            ->groupBy('periode')
            ->orderByDesc('periode')
            ->limit(3)
            ->get()
            ->reverse()
            ->values();

        // badges
        $badges = BadgePencapaianSiswa::with('badgePencapaian.kategoriPencapaian')
            ->where('siswa_id', $user->id)
            ->get()
            ->map(fn($b) => [
                'nama' => $b->badgePencapaian->nama_pencapaian,
                'kategori' => $b->badgePencapaian->kategoriPencapaian->nama_pencapaian ?? '-',
                'ikon' => $b->badgePencapaian->gambar,
            ]);

        // top ranking display
        $topRanking = $rankingKelas->take(3)->map(function ($r) {
            $p = DB::table('profiles')->where('user_id', $r->siswa_id)->select('nama_lengkap')->first();
            $r->nama_lengkap = $p->nama_lengkap ?? 'Siswa';
            return $r;
        });

        $totalTerjual = OrderItem::whereHas('order', function ($q) {
            $q->where('status', 'selesai');
        })
            ->whereHas('produk.toko.users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->sum('qty');

        $raw = MelamarPekerjaan::where('id', $pekerjaanId)
            ->where('pelamar_id', $user->id)
            ->value('berkas_yang_dibutuhkan');   

        $listBerkas = json_decode($raw, true) ?? [];


        $iduser = $user->id;

        $topProducts = OrderItem::select(
            'produk_id',
            DB::raw('SUM(qty) as total_terjual')
        )
            ->whereHas('order', function ($q) {
                $q->where('status', 'selesai');
            })
            ->whereHas('produk.toko.users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->with('produk')
            ->limit(4)
            ->get();



        // render view
        return view('jobfair.dashboard.detail-userJobfair', compact(
            'rapotCollection',
            'avgRapotSummary',
            'totalTerjual',
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
            'improvement',
            'rankNumber',
            'classTotal',
            'totalSkorSiswa',
            'nilaiPerMapel',
            'trenNilai',
            'topRanking',
            'listBerkas',
            'topProducts'
        ));
    }



}
