<?php

namespace App\Http\Controllers\LandingPage;

use Illuminate\Http\Request;
use App\Models\ProfileSekolah;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProfileSekolahController extends Controller
{
    public function index()
    {
        $profile = ProfileSekolah::first();
        return view('landingPage.Dashboard.profile_sekolah', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banner_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stats_siswa' => 'required|integer|min:0',
            'stats_jurusan' => 'required|integer|min:0',
            'stats_alumni' => 'required|integer|min:0',
            'stats_prestasi' => 'required|integer|min:0',
            'link_video' => 'nullable|string|max:255'
        ]);

        $profile = ProfileSekolah::first();
        $filename = $profile->banner_img ?? null;

        if ($request->hasFile('banner_img')) {
            if ($profile && $profile->banner_img && File::exists(public_path('storage/' . $profile->banner_img))) {
                File::delete(public_path('storage/' . $profile->banner_img));
            }
            $file = $request->file('banner_img');
            $path = $file->store('profile', 'public');
            $filename = $path;
        }

        if ($profile) {
            $profile->update(array_merge($validated, ['banner_img' => $filename]));
        } else {
            ProfileSekolah::create(array_merge($validated, ['banner_img' => $filename]));
        }

        return redirect()->back()->with('success', 'Profil sekolah berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'banner_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stats_siswa' => 'required|integer|min:0',
            'stats_jurusan' => 'required|integer|min:0',
            'stats_alumni' => 'required|integer|min:0',
            'stats_prestasi' => 'required|integer|min:0',
            'link_video' => 'nullable|string|max:255'
        ]);

        $profile = ProfileSekolah::findOrFail($id);
        $filename = $profile->banner_img;

        if ($request->hasFile('banner_img')) {
            if ($profile->banner_img && File::exists(public_path('storage/' . $profile->banner_img))) {
                File::delete(public_path('storage/' . $profile->banner_img));
            }
            $file = $request->file('banner_img');
            $path = $file->store('profile', 'public');
            $filename = $path;
        }

        $profile->update(array_merge($validated, ['banner_img' => $filename]));

        return redirect()->back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $profile = ProfileSekolah::findOrFail($id);
        if ($profile->banner_img && File::exists(public_path('storage/' . $profile->banner_img))) {
            File::delete(public_path('storage/' . $profile->banner_img));
        }
        $profile->delete();
        return redirect()->back()->with('success', 'Profil sekolah berhasil dihapus.');
    }
}
