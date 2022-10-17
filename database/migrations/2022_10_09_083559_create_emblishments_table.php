<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('embellishments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('cost');
            $table->float('setup_cost');

            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'EmblishmentSeeder',
            '--force' => true,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('embellishments');
    }
};
