<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class, 'siswa_id');
    }

    public function rapotSiswas()
    {
        return $this->hasMany(RapotSiswa::class, 'siswa_id');
    }

    public function badgePencapaianSiswas()
    {
        return $this->hasMany(BadgePencapaianSiswa::class, 'siswa_id');
    }

    public function trackPerilakuGuru()
    {
        return $this->hasMany(TrackPerilaku::class, 'guru_id');
    }

    public function trackPerilakuSiswa()
    {
        return $this->hasMany(TrackPerilaku::class, 'siswa_id');
    }

    public function tokos()
    {
        return $this->belongsToMany(Toko::class, 'toko_users');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'pembeli_id');
    }

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, 'admin_bkk_id');
    }

    public function lamaranPekerjaans()
    {
        return $this->hasMany(MelamarPekerjaan::class, 'pelamar_id');
    }

    public function kursuses()
    {
        return $this->hasMany(Kursus::class, 'guru_id');
    }
}
