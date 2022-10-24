<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        if (app()->environment(['production'])) {
            Schema::table('material_invoices', function (Blueprint $table) {
                $table->dateTimeTz('invoiced_date')->after('updated_at')->nullable();
            });

            dispatch(new \App\Jobs\FillInvoicedDate());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_invoices', function (Blueprint $table) {
            $table->dropColumn('invoiced_date');
        });
    }
};