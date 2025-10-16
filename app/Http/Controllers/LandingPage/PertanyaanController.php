<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PertanyaanController extends Controller
{
    public function index()
    {
        $pertanyaans = Pertanyaan::orderBy('created_at', 'desc')->paginate(10);
        return view('landingPage.Dashboard.pertanyaan', compact('pertanyaans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        Pertanyaan::create($validated);

        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        $pertanyaan->update($validated);

        return redirect()->back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pertanyaan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
