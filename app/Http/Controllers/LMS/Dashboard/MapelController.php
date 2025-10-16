<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::orderBy('created_at', 'desc')->paginate(10);
        return view('LMS.dashboard.mapel', compact('mapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255'
        ]);

        try {
            Mapel::create($validated);
            return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255'
        ]);

        try {
            $mapel->update($validated);
            return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $mapel = Mapel::findOrFail($id);
            $mapel->delete();
            return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
