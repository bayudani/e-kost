<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'id_barang',
        'pesan',
    ];

    // --- RELATIONS ---

    // Chat ini dikirim oleh siapa
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim');
    }

    // Chat ini dikirim ke siapa
    public function penerima()
    {
        return $this->belongsTo(User::class, 'id_penerima');
    }

    // Chat ini lagi bahas barang apa
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}