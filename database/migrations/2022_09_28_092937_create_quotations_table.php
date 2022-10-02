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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('customer_service_person_id')->constrained('users');
            $table->foreignId('customer_type_id')->constrained();
            $table->foreignId('customer_sales_person_id')->constrained('users');
            $table->string('attention_person_name');
            $table->enum('quotation_type', ['general', 'funding']);
            $table->enum('payment_terms', ['cash', 'account']);
            $table->foreignId('freight_charges_region_id')->constrained('freight_charges_regions');
            $table->decimal('cost_per_region',15,2);
            $table->integer('no_of_boxes');
            $table->decimal('total_freight_charge',15,2);
            $table->boolean('apply_air_freight_charge');
            $table->decimal('total_quotation_charge',15,2);
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
        Schema::dropIfExists('quotations');
    }
};
