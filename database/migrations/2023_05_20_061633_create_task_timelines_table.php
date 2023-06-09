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
        Schema::create('task_timelines', function (Blueprint $table) {
            $table->id();
            $table->string('current_progress');
            $table->string('notes');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('task_id')->constrained('tasks');
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
        Schema::dropIfExists('task_timelines');
    }
};
