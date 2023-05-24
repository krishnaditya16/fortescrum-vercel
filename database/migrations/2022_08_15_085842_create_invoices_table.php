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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_address');
            $table->date('issued');
            $table->date('deadline');
            $table->string('tax_percent')->nullable();
            $table->string('discount_percent')->nullable();
            $table->bigInteger('tax_ammount')->nullable();
            $table->bigInteger('discount_ammount')->nullable();
            $table->bigInteger('total_all');
            $table->string('client_id');
            $table->string('project_id');
            $table->string('task_id');
            $table->string('timesheet_id');
            $table->string('expenses_id');
            $table->string('rate_task');
            $table->string('rate_ts');
            $table->string('qty_task');
            $table->string('qty_ts');
            $table->string('total_task');
            $table->string('total_ts');
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
        Schema::dropIfExists('invoices');
    }
};
