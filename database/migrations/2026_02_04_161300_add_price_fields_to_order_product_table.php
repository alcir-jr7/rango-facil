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
        Schema::table('order_product', function (Blueprint $table) {
            $table->enum('price_type', ['normal', 'minimo'])->after('quantity');
            $table->decimal('unit_price', 10, 2)->after('price_type');

            // se quiser manter o campo antigo:
            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn(['price_type', 'unit_price']);
            
            // se removeu o price:
            $table->decimal('price', 10, 2);
        });
    }
};
