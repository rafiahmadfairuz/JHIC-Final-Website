<?php

namespace App\Http\Controllers\LMS\Dashboard;

use Illuminate\Http\Request;
use App\Models\BadgePencapaian;
use App\Http\Controllers\Controller;
use App\Models\kategoriPencapaian;
use Illuminate\Support\Facades\File;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = BadgePencapaian::with('kategori')->orderBy('created_at', 'desc')->paginate(10);
        $kategori = kategoriPencapaian::all();
        return view('LMS.dashboard.badge', compact('badges', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pencapaian' => 'required|string|max:255',
            'kategori_pencapaian_id' => 'required|exists:kategori_pencapaians,id',
            'syarat' => 'required|json',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/badges'), $filename);
        }

        BadgePencapaian::create([
            'nama_pencapaian' => $validated['nama_pencapaian'],
            'kategori_pencapaian_id' => $validated['kategori_pencapaian_id'],
            'syarat' => $validated['syarat'],
            'gambar' => $filename
        ]);

        return redirect()->back()->with('success', 'Badge berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $badge = BadgePencapaian::findOrFail($id);

        $validated = $request->validate([
            'nama_pencapaian' => 'required|string|max:255',
            'kategori_pencapaian_id' => 'required|exists:kategori_pencapaians,id',
            'syarat' => 'required|json',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $filename = $badge->gambar;
        if ($request->hasFile('gambar')) {
            if ($badge->gambar && File::exists(public_path('img/badges/' . $badge->gambar))) {
                File::delete(public_path('img/badges/' . $badge->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/badges'), $filename);
        }

        $badge->update([
            'nama_pencapaian' => $validated['nama_pencapaian'],
            'kategori_pencapaian_id' => $validated['kategori_pencapaian_id'],
            'syarat' => $validated['syarat'],
            'gambar' => $filename
        ]);

        return redirect()->back()->with('success', 'Badge berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $badge = BadgePencapaian::findOrFail($id);
        if ($badge->gambar && File::exists(public_path('img/badges/' . $badge->gambar))) {
            File::delete(public_path('img/badges/' . $badge->gambar));
        }
        $badge->delete();
        return redirect()->back()->with('success', 'Badge berhasil dihapus.');
    }
}
