
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {

            $table->id();

            // Relasi dengan tabel orders
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi dengan tabel products
            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Informasi produk
            $table->string('product_name', 150);

            // Harga produk
            $table->decimal('price', 15, 2);

            // Jumlah produk
            $table->unsignedInteger('quantity');

            // Total harga produk
            $table->decimal('subtotal', 15, 2);

            // Timestamp otomatis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
