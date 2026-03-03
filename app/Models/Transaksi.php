<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'id_barang',
        'id_pembeli',
        'id_penjual',
        'metode_pembayaran',
        'bukti_transfer',
        'tanggal_transaksi',
        'status_transaksi',
    ];

    // Biar otomatis jadi object Carbon (gampang diformat tanggalnya)
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    // --- RELATIONS ---

    // Transaksi ini beli barang apa
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Transaksi ini dibeli sama siapa
    public function pembeli()
    {
        return $this->belongsTo(User::class, 'id_pembeli');
    }

    // Transaksi ini dijual sama siapa
    public function penjual()
    {
        return $this->belongsTo(User::class, 'id_penjual');
    }
}