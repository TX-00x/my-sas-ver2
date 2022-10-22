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
//            $table->foreignId('quotation_freight_id')->constrained('quotation_freights');
            $table->string('type');
            $table->string('club');
            $table->string('attention_person');
            $table->float('items_net_amount');
            $table->float('quotation_gross_amount');
            $table->boolean('payment_term_20')->nullable();
            $table->foreignId('created_by_id')->constrained('users');
            $table->boolean('requires_sales_approval');
            $table->timestamp('sales_action_taken_by')->nullable();
            $table->string('sales_action')->nullable();
            $table->timestamp('customer_action_taken_by')->nullable();
            $table->string('customer_action')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
