<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('sales_agent_id')->constrained('users');
            $table->foreignId('customer_agent_id')->constrained('users');
            $table->string('type');
            $table->string('club');
            $table->string('attention_person');
            $table->float('items_net_amount');
            $table->float('quotation_gross_amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
