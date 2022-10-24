<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory_logs', function (Blueprint $table) {
           $table->string('out_order_id')->change();
           $table->bigInteger('out_style_panel_id')->change();
        });
    }

    public function down()
    {
        // no going back
    }
};
