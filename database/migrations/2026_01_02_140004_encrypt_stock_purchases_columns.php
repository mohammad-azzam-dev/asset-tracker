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
            $table->text('stock_type_data')->nullable()->after('user_id');
            $table->text('purchase_price_data')->nullable()->after('stock_type_data');
            $table->text('quantity_data')->nullable()->after('purchase_price_data');
            $table->text('unit_data')->nullable()->after('quantity_data');
            $table->text('purchase_date_data')->nullable()->after('unit_data');
            $table->text('notes_data')->nullable()->after('purchase_date_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_purchases', function (Blueprint $table) {
            $table->dropColumn([
                'stock_type_data',
                'purchase_price_data',
                'quantity_data',
                'unit_data',
                'purchase_date_data',
                'notes_data',
            ]);
        });
    }
};
