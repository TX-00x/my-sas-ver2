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
        Schema::create('embellishment_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_id')->constrained('styles');
            $table->string('image_path');
            $table->foreignId('embellishment_id')->constrained('embellishment_types');
            $table->string('position');
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
        Schema::dropIfExists('embellishment_style');
    }
};
