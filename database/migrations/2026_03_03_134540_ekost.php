<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pembeli', 'penjual'])->default('pembeli')->after('password');
        });

        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->enum('nama_kategori', ['elektronik', 'non elektronik']);
            $table->timestamps();
        });

        // barang

        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('kondisi_barang', 50);
            $table->decimal('harga', 10, 2);
            $table->string('foto');
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia');
            $table->timestamps();
        });

        // chat
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengirim')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_penerima')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_barang')->constrained('barangs')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->text('pesan');
            $table->timestamps();
        });

        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            // Foreign Keys 
            $table->foreignId('id_barang')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('id_pembeli')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_penjual')->constrained('users')->onDelete('cascade');

            // Detail Transaksi 
            $table->enum('metode_pembayaran', ['COD', 'Transfer']);
            $table->string('bukti_transfer')->nullable();
            $table->dateTime('tanggal_transaksi');

            $table->enum('status_transaksi', [
                'Menunggu Pembayaran',
                'Menunggu Verifikasi',
                'Diverifikasi',
                'Diproses',
                'Selesai'
            ])->default('Menunggu Pembayaran');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
