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
        Schema::table('sprints', function (Blueprint $table) {
            $table->renameColumn('story_point', 'total_sp');
            $table->date('start_date')->after('description');
            $table->date('end_date')->after('start_date');
            $table->bigInteger('focus_factor')->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sprints', function (Blueprint $table) {
            $table->dropColumn('total_sp');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('focus_factor');
        });
    }
};
