<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::orderBy('created_at', 'desc')->paginate(10);
        return view('landingPage.Dashboard.guru', compact('gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'jabatan_guru' => 'required|string|max:255',
            'guru_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $filename = null;
        if ($request->hasFile('guru_img')) {
            $file = $request->file('guru_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/guru'), $filename);
        }

        Guru::create([
            'nama_guru' => $validated['nama_guru'],
            'jabatan_guru' => $validated['jabatan_guru'],
            'guru_img' => $filename
        ]);

        return redirect()->back()->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'jabatan_guru' => 'required|string|max:255',
            'guru_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $filename = $guru->guru_img;
        if ($request->hasFile('guru_img')) {
            if ($guru->guru_img && File::exists(public_path('img/guru/' . $guru->guru_img))) {
                File::delete(public_path('img/guru/' . $guru->guru_img));
            }
            $file = $request->file('guru_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/guru'), $filename);
        }

        $guru->update([
            'nama_guru' => $validated['nama_guru'],
            'jabatan_guru' => $validated['jabatan_guru'],
            'guru_img' => $filename
        ]);

        return redirect()->back()->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        if ($guru->guru_img && File::exists(public_path('img/guru/' . $guru->guru_img))) {
            File::delete(public_path('img/guru/' . $guru->guru_img));
        }
        $guru->delete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus.');
    }
}
