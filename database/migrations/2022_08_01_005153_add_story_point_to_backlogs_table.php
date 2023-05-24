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
        Schema::table('backlogs', function (Blueprint $table) {
            $table->bigInteger('story_point')->after('description')->default(0);
            $table->string('sprint_name')->after('name');
            $table->foreignId('sprint_id')->after('project_id')->constrained('sprints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backlogs', function (Blueprint $table) {
            $table->dropColumn('story_point');
            $table->dropColumn('sprint_id');
        });
    }
};
