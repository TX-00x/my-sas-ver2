<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotation_freights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations');
            $table->foreignId('freight_charge_id')->constrained('freight_charges');
            $table->float('freight_cost');
            $table->integer('boxes_count');
            $table->float('surcharge_percentage');
            $table->float('total_freight_cost');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotation_freights');
    }
};
