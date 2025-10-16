<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Kursus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class KursusDashboardController extends Controller
{
    public function index()
    {
        $kursuses = Kursus::with(['mapel', 'guru', 'kelas'])->orderBy('created_at', 'desc')->paginate(10);
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        $gurus = User::where('role', 'guru')->get();
        return view('LMS.dashboard.kursus', compact('kursuses', 'mapels', 'kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'isi_kursus' => 'required|string'
        ]);

        try {
            Kursus::create($validated);
            return redirect()->back()->with('success', 'Kursus berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $kursus = Kursus::findOrFail($id);
        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'isi_kursus' => 'required|string'
        ]);

        try {
            $kursus->update($validated);
            return redirect()->back()->with('success', 'Kursus berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $kursus = Kursus::findOrFail($id);
            $kursus->delete();
            return redirect()->back()->with('success', 'Kursus berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
