<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Models\MelamarPekerjaan;

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
            'berkas.*' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $files = [];
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('berkas_lamaran', $filename, 'public');
                $files[] = $filename;
            }
        }

        MelamarPekerjaan::create([
            'pekerjaan_id' => $id,
            'pelamar_id' => auth()->id(),
            'berkas_yang_dibutuhkan' => json_encode($files),
            'status' => 'pending',
        ]);

        return redirect()->route('jobfair.lamaran.berhasil');
    }

    public function lamaranBerhasil()
    {
        return view('jobfair.landing.berhasil-lamaran');
    }

}
