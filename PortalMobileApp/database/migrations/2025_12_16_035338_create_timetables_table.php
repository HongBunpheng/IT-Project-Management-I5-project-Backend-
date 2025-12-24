<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();

            // teacher
            $table->unsignedBigInteger('user_id');

            // subject comes later
            $table->unsignedBigInteger('subject_id')->nullable();

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('semester_id')->nullable();

            $table->enum('day_of_week', ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
            $table->string('title')->nullable();
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
