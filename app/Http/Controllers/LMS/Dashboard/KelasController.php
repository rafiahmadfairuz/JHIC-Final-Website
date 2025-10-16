<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->orderBy('created_at', 'desc')->paginate(10);
        $jurusans = Jurusan::all();
        return view('LMS.dashboard.kelas', compact('kelas', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:10,11,12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'urutan_kelas' => 'required|string|max:50'
        ]);

        try {
            Kelas::create($validated);
            return redirect()->back()->with('success', 'Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $validated = $request->validate([
            'tingkat' => 'required|in:10,11,12',
            'jurusan_id' => 'required|exists:jurusans,id',
            'urutan_kelas' => 'required|string|max:50'
        ]);

        try {
            $kelas->update($validated);
            return redirect()->back()->with('success', 'Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $kelas->delete();
            return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
