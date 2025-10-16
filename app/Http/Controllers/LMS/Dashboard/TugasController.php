<?php

namespace App\Http\Controllers\LMS\Dashboard;

use App\Models\Soal;
use App\Models\Tugas;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Tugas::with('kursus')->orderBy('created_at', 'desc');

        if ($request->filter_kursus) {
            $query->where('kursus_id', $request->filter_kursus);
        }

        $tugas = $query->paginate(10);
        $kursuses = Kursus::all();

        return view('LMS.dashboard.tugas', compact('tugas', 'kursuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kursus_id' => 'required|exists:kursuses,id',
            'nama_tugas' => 'required|string|max:255',
            'batas_pengumpulan' => 'required|date',
            'soals' => 'required|array|min:1',
            'soals.*.pertanyaan' => 'required|string',
            'soals.*.opsi_a' => 'required|string',
            'soals.*.opsi_b' => 'required|string',
            'soals.*.opsi_c' => 'required|string',
            'soals.*.opsi_d' => 'required|string',
            'soals.*.jawaban_benar' => 'required|in:A,B,C,D',
            'soals.*.skor' => 'required|numeric|min:1'
        ]);

        DB::beginTransaction();
        try {
            $tugas = Tugas::create([
                'kursus_id' => $validated['kursus_id'],
                'nama_tugas' => $validated['nama_tugas'],
                'batas_pengumpulan' => $validated['batas_pengumpulan']
            ]);

            foreach ($validated['soals'] as $soal) {
                Soal::create(array_merge($soal, ['tugas_id' => $tugas->id]));
            }

            DB::commit();
            return redirect()->back()->with('success', 'Tugas dan soal berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan tugas.');
        }
    }

    public function edit($id)
    {
        $soals = Soal::where('tugas_id', $id)
            ->select('id', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban_benar', 'skor')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'pertanyaan' => $s->pertanyaan,
                    'opsi_a' => $s->opsi_a,
                    'opsi_b' => $s->opsi_b,
                    'opsi_c' => $s->opsi_c,
                    'opsi_d' => $s->opsi_d,
                    'jawaban_benar' => $s->jawaban_benar,
                    'skor' => $s->skor
                ];
            });

        return response()->json($soals);
    }


    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $validated = $request->validate([
            'kursus_id' => 'required|exists:kursuses,id',
            'nama_tugas' => 'required|string|max:255',
            'batas_pengumpulan' => 'required|date',
            'soals' => 'nullable|array|min:1',
            'soals.*.pertanyaan' => 'required_with:soals|string',
            'soals.*.opsi_a' => 'required_with:soals|string',
            'soals.*.opsi_b' => 'required_with:soals|string',
            'soals.*.opsi_c' => 'required_with:soals|string',
            'soals.*.opsi_d' => 'required_with:soals|string',
            'soals.*.jawaban_benar' => 'required_with:soals|in:A,B,C,D',
            'soals.*.skor' => 'required_with:soals|numeric|min:1'
        ]);

        DB::beginTransaction();
        try {
            $tugas->update([
                'kursus_id' => $validated['kursus_id'],
                'nama_tugas' => $validated['nama_tugas'],
                'batas_pengumpulan' => $validated['batas_pengumpulan']
            ]);

            if (!empty($validated['soals'])) {
                Soal::where('tugas_id', $id)->delete();

                foreach ($validated['soals'] as $soal) {
                    Soal::create(array_merge($soal, ['tugas_id' => $id]));
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Tugas dan soal berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui tugas.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Soal::where('tugas_id', $id)->delete();
            Tugas::where('id', $id)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Tugas dan soal terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}
