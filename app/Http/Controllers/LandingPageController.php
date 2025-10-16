<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Alumni;
use App\Models\Maskot;
use App\Models\Jurusan;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Models\ProfileSekolah;

class LandingPageController extends Controller
{
    public function index()
    {
        $profile = ProfileSekolah::latest()->first();
        $gurus = Guru::latest()->take(6)->get();
        $maskot = Maskot::latest()->first();
        $pertanyaans = Pertanyaan::orderBy('id')->get();
        $alumnis = Alumni::latest()->take(8)->get();
        $jurusans = Jurusan::take(5)->get();

        return view('landingPage.index', compact(
            'profile',
            'gurus',
            'maskot',
            'pertanyaans',
            'alumnis',
            'jurusans'
        ));
    }
}
