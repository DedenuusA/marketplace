<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // ID pengguna
            $table->foreignId('toko_id'); // ID toko
            $table->foreignId('kategori_id'); // ID kategori
            $table->string('nama_product')->nullable();
            $table->string('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->enum('kondisi', ['baru', 'bekas'])->nullable();
            $table->string('image')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
