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
            $table->uuid('aggregate_id');
            $table->string('number');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('sales_agent_id')->constrained('users');
            $table->foreignId('customer_agent_id')->constrained('users');
//            $table->foreignId('quotation_freight_id')->constrained('quotation_freights');
            $table->string('type');
            $table->string('club');
            $table->string('attention_person');
            $table->decimal('items_net_amount', 20, 2);
            $table->decimal('quotation_gross_amount', 20, 2);
            $table->boolean('payment_term_20')->nullable();
            $table->foreignId('created_by_id')->constrained('users');
            $table->boolean('requires_sales_approval');
            $table->foreignId('sales_action_taken_by_id')->nullable()->constrained('users');
            $table->string('sales_action')->nullable();
            $table->timestamp('sales_action_taken_at')->nullable();
            $table->longText('sales_rejected_reason')->nullable();
            $table->timestamp('customer_action_taken_at')->nullable();
            $table->string('customer_action')->nullable();
            $table->longText('customer_rejected_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
