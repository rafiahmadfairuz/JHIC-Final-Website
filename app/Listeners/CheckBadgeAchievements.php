<?php

namespace App\Listeners;

use App\Events\ProgressUpdated;
use App\Models\BadgePencapaian;
use App\Models\BadgePencapaianSiswa;
use App\Models\JawabanSiswa;
use App\Models\RapotSiswa;
use App\Models\TrackPerilaku;
use Illuminate\Support\Facades\Session;

class CheckBadgeAchievements
{
    public function handle(ProgressUpdated $event)
    {
        $user = $event->user;
        $badges = BadgePencapaian::all();

        foreach ($badges as $badge) {
            $rule = is_array($badge->syarat) ? $badge->syarat : json_decode($badge->syarat, true);
            if (!is_array($rule)) continue;

            switch ($rule['tipe']) {

                // ✅ 1️⃣ Badge: Rajin Nugas (berdasarkan jumlah soal yang dijawab)
                case 'tugas_selesai':
                    $done = JawabanSiswa::where('siswa_id', $user->id)
                        ->distinct('soal_id')
                        ->count('soal_id');

                    if ($done >= ($rule['jumlah'] ?? 0)) {
                        $this->grantBadge($user, $badge);
                    }
                    break;

                // ✅ 2️⃣ Badge: Rapot Bagus (berdasarkan nilai rata-rata rapot)
                case 'rapot_bagus':
                    $avg = RapotSiswa::where('siswa_id', $user->id)->avg('nilai');
                    if ($avg >= ($rule['min_rata'] ?? 0)) {
                        $this->grantBadge($user, $badge);
                    }
                    break;

                // ✅ 3️⃣ Badge: Perilaku Baik (berdasarkan jumlah catatan perilaku positif)
                case 'perilaku_baik':
                    $count = TrackPerilaku::where('siswa_id', $user->id)->count();
                    if ($count >= ($rule['minimal_poin'] ?? 0)) {
                        $this->grantBadge($user, $badge);
                    }
                    break;
            }
        }
    }

    protected function grantBadge($user, $badge)
    {
        $new = BadgePencapaianSiswa::firstOrCreate([
            'siswa_id' => $user->id,
            'badge_pencapaian_id' => $badge->id,
        ]);

        if ($new->wasRecentlyCreated) {
            Session::flash('badge_unlocked', [
                'nama' => $badge->nama_pencapaian,
                'gambar' => $badge->gambar,
            ]);
        }
    }
}
