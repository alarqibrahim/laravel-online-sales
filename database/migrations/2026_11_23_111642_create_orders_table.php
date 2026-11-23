
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // Kode pesanan
            $table->string('code', 40)->unique();

            // Relasi dengan tabel users
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Relasi dengan tabel shipping_services
            $table->foreignId('shipping_service_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Data penerima
            $table->string('recipient_name', 120);
            $table->string('phone', 30);
            $table->text('address');

            // Informasi pengiriman
            $table->string('shipping_courier', 80);
            $table->string('shipping_service', 80);
            $table->string('shipping_eta', 80)->nullable();

            // Informasi pembayaran
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2);
            $table->decimal('grand_total', 15, 2);

            // Status pesanan
            $table->string('status', 30)->default('pending');

            // Waktu pemesanan
            $table->timestamp('ordered_at');

            // Validasi pesanan
            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('validated_at')->nullable();

            // Timestamp otomatis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
