<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Jangan lupa tambahin role di sini biar bisa di-insert
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // --- RELATIONS ---

    // Relasi ke tabel barang (Barang yang dijual user)
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'user_id');
    }

    // Relasi ke tabel chat (Sebagai pengirim)
    public function pesanDikirim()
    {
        return $this->hasMany(Chat::class, 'id_pengirim');
    }

    // Relasi ke tabel chat (Sebagai penerima)
    public function pesanDiterima()
    {
        return $this->hasMany(Chat::class, 'id_penerima');
    }

    // Relasi ke tabel transaksi (Sebagai pembeli)
    public function transaksiSebagaiPembeli()
    {
        return $this->hasMany(Transaksi::class, 'id_pembeli');
    }

    // Relasi ke tabel transaksi (Sebagai penjual)
    public function transaksiSebagaiPenjual()
    {
        return $this->hasMany(Transaksi::class, 'id_penjual');
    }
}