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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
            $table->dropUnique('cart_items_cart_id_product_id_unique');

            //Novos campos
            $table->enum('price_type', ['normal', 'minimo'])->after('quantity');
            $table->decimal('unit_price', 10, 2)->after('price_type');
            $table->unique(['cart_id', 'product_id', 'price_type']);
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
            $table->dropUnique(['cart_id', 'product_id', 'price_type']);
            $table->dropColumn(['price_type', 'unit_price']);

            // restaura unique antigo
            $table->unique(['cart_id', 'product_id']);
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
