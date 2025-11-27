<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_recipes', function (Blueprint $table) {
            if (!Schema::hasColumn('product_recipes', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('product')->onDelete('cascade');
            }
            if (!Schema::hasColumn('product_recipes', 'inventory_item_id')) {
                $table->foreignId('inventory_item_id')->nullable()->constrained('inventory_items')->onDelete('cascade');
            }
            if (!Schema::hasColumn('product_recipes', 'quantity_needed')) {
                $table->decimal('quantity_needed', 10, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_recipes', function (Blueprint $table) {
            if (Schema::hasColumn('product_recipes', 'quantity_needed')) {
                $table->dropColumn('quantity_needed');
            }
            if (Schema::hasColumn('product_recipes', 'inventory_item_id')) {
                $table->dropForeign(['inventory_item_id']);
                $table->dropColumn('inventory_item_id');
            }
            if (Schema::hasColumn('product_recipes', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
};
