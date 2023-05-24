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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('assignee');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('priority');
            $table->smallInteger('status')->default(0);
            $table->foreignId('board_id')->constrained('boards');
            $table->foreignId('sprint_id')->constrained('sprints');
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('backlog_id')->constrained('backlogs');
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
        Schema::dropIfExists('tasks');
    }
};
