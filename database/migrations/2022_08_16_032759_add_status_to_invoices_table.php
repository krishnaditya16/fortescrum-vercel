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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('inv_status')->after('expenses_id')->default(0);
            $table->string('subtotal_task')->after('total_task');
            $table->string('subtotal_ts')->after('total_ts');
            $table->string('subtotal_exp')->after('subtotal_ts');
            $table->string('exp_ammount')->after('qty_ts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('inv_status');
            $table->dropColumn('subtotal_task');
            $table->dropColumn('subtotal_ts');
            $table->dropColumn('subtotal_exp');
            $table->dropColumn('exp_ammount');
        });
    }
};
