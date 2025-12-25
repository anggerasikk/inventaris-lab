<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama barang
            $table->text('description')->nullable(); // deskripsi barang
            $table->integer('quantity'); // jumlah stok
            $table->string('category'); // kategori: elektronik, alat, bahan, dll
            $table->string('location'); // lokasi penyimpanan
            $table->string('condition')->default('good'); // kondisi: good, damaged, broken
            $table->date('purchase_date')->nullable(); // tanggal pembelian
            $table->decimal('price', 10, 2)->nullable(); // harga
            $table->timestamps();
             $table->boolean('is_available')->default(true); // untuk status ketersediaan
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};