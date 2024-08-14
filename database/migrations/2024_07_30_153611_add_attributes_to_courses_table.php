<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            //
            $table->string('english_name')->nullable();
            $table->string('time_allocation')->nullable();
            $table->string('main_instructor')->nullable();
            $table->text('co_instructors')->nullable();
            $table->string('department')->nullable();
            $table->string('prior_course')->nullable();
            $table->string('co_requisite')->nullable();
            $table->boolean('is_mandatory')->default(false);
            $table->enum('knowledge_area', ['General', 'Core', 'Specialized', 'Internship', 'Thesis']);
            $table->string('objectives')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('student_tasks')->nullable();
            $table->string('decision_no')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->text('note')->nullable();
            $table->date('approved_date')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course', function (Blueprint $table) {
            //
        });
    }
};
