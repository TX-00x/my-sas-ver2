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
        Schema::create('inventory_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_variation_id')->constrained();
            $table->foreignId('material_invoice_id')->constrained();
            $table->float('in')->nullable();
            $table->float('out')->nullable();
            $table->float('unit_price');
            $table->float('total_price');
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
        Schema::dropIfExists('inventory_summaries');
    }
};
