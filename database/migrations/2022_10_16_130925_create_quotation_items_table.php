<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations');
            $table->foreignId('style_id')->constrained('styles');
            $table->foreignId('category_id')->constrained('categories');
            $table->integer('quantity');
            $table->string('price_type');
            $table->float('unit_price');
            $table->float('unit_price_total');
            $table->float('embellishment_total');
            $table->string('production_type');
            $table->longText('note')->nullable();
            $table->float('item_gross_total');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotation_items');
    }
};
