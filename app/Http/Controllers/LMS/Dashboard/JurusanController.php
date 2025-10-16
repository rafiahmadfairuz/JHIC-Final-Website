<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('created_at', 'desc')->get();
        return view('LMS.dashboard.jurusan', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'gambar_jurusan' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        try {
            $namaFile = null;
            if ($request->hasFile('gambar_jurusan')) {
                $file = $request->file('gambar_jurusan');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('img'), $namaFile);
            }

            Jurusan::create([
                'nama_jurusan' => $validated['nama_jurusan'],
                'gambar_jurusan' => $namaFile
            ]);

            return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'gambar_jurusan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        try {
            if ($request->hasFile('gambar_jurusan')) {
                if ($jurusan->gambar_jurusan && File::exists(public_path('img/' . $jurusan->gambar_jurusan))) {
                    File::delete(public_path('img/' . $jurusan->gambar_jurusan));
                }

                $file = $request->file('gambar_jurusan');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('img'), $namaFile);
                $jurusan->gambar_jurusan = $namaFile;
            }

            $jurusan->nama_jurusan = $validated['nama_jurusan'];
            $jurusan->save();

            return redirect()->back()->with('success', 'Jurusan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            if ($jurusan->gambar_jurusan && File::exists(public_path('img/' . $jurusan->gambar_jurusan))) {
                File::delete(public_path('img/' . $jurusan->gambar_jurusan));
            }
            $jurusan->delete();
            return redirect()->back()->with('success', 'Jurusan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
