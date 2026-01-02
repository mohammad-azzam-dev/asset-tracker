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
        Schema::table('stock_purchases', function (Blueprint $table) {
            $table->dropColumn([
                'stock_type',
                'purchase_price',
                'quantity',
                'unit',
                'purchase_date',
                'notes',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_purchases', function (Blueprint $table) {
            $table->string('stock_type')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->decimal('quantity', 12, 4)->default(1);
            $table->string('unit')->default('oz');
            $table->date('purchase_date')->nullable();
            $table->text('notes')->nullable();
        });
    }
};
