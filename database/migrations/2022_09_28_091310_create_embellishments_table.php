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
        Schema::create('embellishments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('embellishment_types_id')->constrained();
            $table->decimal('embellishment_cost', 15,2);
            $table->decimal('setup_cost', 15,2);
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
        Schema::dropIfExists('embellishments');
    }
};
