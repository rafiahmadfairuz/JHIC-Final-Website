<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Maskot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class MaskotController extends Controller
{
    public function index()
    {
        $maskots = Maskot::orderBy('created_at', 'desc')->paginate(10);
        return view('landingPage.Dashboard.maskot', compact('maskots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_maskot' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gambar_maskot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('gambar_maskot')) {
            $file = $request->file('gambar_maskot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/maskot'), $filename);
        }

        Maskot::create([
            'nama_maskot' => $validated['nama_maskot'],
            'jabatan' => $validated['jabatan'],
            'gambar_maskot' => $filename,
        ]);

        return redirect()->back()->with('success', 'Maskot berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $maskot = Maskot::findOrFail($id);

        $validated = $request->validate([
            'nama_maskot' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gambar_maskot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $filename = $maskot->gambar_maskot;
        if ($request->hasFile('gambar_maskot')) {
            if ($maskot->gambar_maskot && File::exists(public_path('img/maskot/' . $maskot->gambar_maskot))) {
                File::delete(public_path('img/maskot/' . $maskot->gambar_maskot));
            }
            $file = $request->file('gambar_maskot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/maskot'), $filename);
        }

        $maskot->update([
            'nama_maskot' => $validated['nama_maskot'],
            'jabatan' => $validated['jabatan'],
            'gambar_maskot' => $filename,
        ]);

        return redirect()->back()->with('success', 'Maskot berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $maskot = Maskot::findOrFail($id);
        if ($maskot->gambar_maskot && File::exists(public_path('img/maskot/' . $maskot->gambar_maskot))) {
            File::delete(public_path('img/maskot/' . $maskot->gambar_maskot));
        }
        $maskot->delete();
        return redirect()->back()->with('success', 'Maskot berhasil dihapus.');
    }
}
