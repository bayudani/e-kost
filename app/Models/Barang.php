<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kategori_id',
        'user_id',
        'nama_barang',
        'deskripsi',
        'kondisi_barang',
        'harga',
        'foto',
        'status',
    ];

    // --- RELATIONS ---

    // Barang ini milik kategori apa
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Barang ini milik user/penjual siapa
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke chat (Obrolan yang bahas barang ini)
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_barang');
    }

    // Relasi ke transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_barang');
    }
}