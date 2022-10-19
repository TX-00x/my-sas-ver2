<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_out_items_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_out_item_id')->constrained('stock_out_items');
            $table->foreignId('material_invoice_id')->constrained('material_invoices');
            $table->float('quantity');
            $table->string('unit');
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
        Schema::dropIfExists('stock_out_items_invoices');
    }
};
