<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Chat;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. BUAT DATA USER (Sesuai role di wireframe)
        // ==========================================
        $admin = User::create([
            'name' => 'Admin KostPlace',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $penjual = User::create([
            'name' => 'Ulla Shop', // Sesuai di UI chat/transaksi
            'email' => 'ulla@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
        ]);

        $pembeli = User::create([
            'name' => 'Avrilla Rizki', // Sesuai di UI chat
            'email' => 'rilla@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        // ==========================================
        // 2. BUAT DATA KATEGORI
        // ==========================================
        $kategoriElektronik = Kategori::create([
            'nama_kategori' => 'elektronik'
        ]);
        
        $kategoriNonElektronik = Kategori::create([
            'nama_kategori' => 'non elektronik'
        ]);

        // ==========================================
        // 3. BUAT DATA BARANG
        // ==========================================
        $barang1 = Barang::create([
            'kategori_id' => $kategoriElektronik->id,
            'user_id' => $penjual->id,
            'nama_barang' => 'Kulkas Mini',
            'deskripsi' => 'Masih layak pakai, no minus. Cocok banget buat anak kosan biar minuman tetap dingin.',
            'kondisi_barang' => 'Bekas - Sangat Baik',
            'harga' => 250000,
            'foto' => 'kulkas_mini.jpg', // Pastikan upload foto dummy kalau mau ngetes UI
            'status' => 'tersedia',
        ]);

        $barang2 = Barang::create([
            'kategori_id' => $kategoriNonElektronik->id,
            'user_id' => $penjual->id,
            'nama_barang' => 'Lemari Pakaian',
            'deskripsi' => 'Bahan plastik tebal, anti rayap. Jual cepat mau lulus dan balik kampung.',
            'kondisi_barang' => 'Bekas - Baik',
            'harga' => 100000,
            'foto' => 'lemari_pakaian.jpg',
            'status' => 'tersedia',
        ]);

        // ==========================================
        // 4. BUAT DATA CHAT (Biar fitur Livewire-nya langsung keliatan real)
        // ==========================================
        Chat::create([
            'id_pengirim' => $pembeli->id,
            'id_penerima' => $penjual->id,
            'id_barang' => $barang1->id,
            'pesan' => 'Kulkas mini masih ada kak?',
        ]);

        Chat::create([
            'id_pengirim' => $penjual->id,
            'id_penerima' => $pembeli->id,
            'id_barang' => $barang1->id,
            'pesan' => 'Masih ada kak, mau nego atau langsung ambil nih?',
        ]);

        // ==========================================
        // 5. BUAT DATA TRANSAKSI
        // ==========================================
        // Transaksi 1: Via Transfer (Menunggu Verifikasi Admin)
        Transaksi::create([
            'id_barang' => $barang1->id,
            'id_pembeli' => $pembeli->id,
            'id_penjual' => $penjual->id,
            'metode_pembayaran' => 'Transfer',
            'bukti_transfer' => 'bukti_tf_dummy.jpg',
            'tanggal_transaksi' => Carbon::now(),
            'status_transaksi' => 'Diverifikasi', 
        ]);
        Transaksi::create([
            'id_barang' => $barang1->id,
            'id_pembeli' => $pembeli->id,
            'id_penjual' => $penjual->id,
            'metode_pembayaran' => 'Transfer',
            'bukti_transfer' => 'bukti_tf_dummy.jpg',
            'tanggal_transaksi' => Carbon::now(),
            'status_transaksi' => 'Menunggu Pembayaran', 
        ]);

        // Transaksi 2: Via COD 
        Transaksi::create([
            'id_barang' => $barang2->id,
            'id_pembeli' => $pembeli->id,
            'id_penjual' => $penjual->id,
            'metode_pembayaran' => 'COD',
            'bukti_transfer' => null, // Kalau COD kan nggak ada resi TF bro
            'tanggal_transaksi' => Carbon::now()->subDays(1),
            'status_transaksi' => 'Menunggu Pembayaran',
        ]);
    }
}