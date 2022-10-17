<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotation_item_embellishments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_item_id')->constrained('quotation_items');
            $table->foreignId('embellishment_id')->constrained('embellishments');
            $table->string('position')->nullable();
            $table->integer('quantity');
            $table->float('cost');
            $table->float('total_embellishment_cost');
            $table->float('setup_cost');
            $table->integer('setup_quantity');
            $table->float('total_setup_cost');
            $table->float('total_cost');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotation_item_embellishments');
    }
};
