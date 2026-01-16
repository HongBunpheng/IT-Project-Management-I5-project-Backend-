<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acad_year_id')
                ->constrained('academic_years')
                ->cascadeOnDelete();

            $table->integer('semester_num'); // 1 or 2
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);

            $table->timestamps();

            // optional but nice: prevent duplicate semester per year
            $table->unique(['acad_year_id', 'semester_num']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
