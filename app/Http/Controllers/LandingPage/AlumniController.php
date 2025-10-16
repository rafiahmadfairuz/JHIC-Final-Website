<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::orderBy('created_at', 'desc')->paginate(10);
        return view('landingPage.Dashboard.alumni', compact('alumnis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alumni_tahun' => 'required|string|max:10',
            'keterangan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Alumni::create($validated);
        return redirect()->back()->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alumni_tahun' => 'required|string|max:10',
            'keterangan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $alumni->update($validated);
        return redirect()->back()->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();
        return redirect()->back()->with('success', 'Data alumni berhasil dihapus.');
    }
}
