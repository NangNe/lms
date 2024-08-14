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
        Schema::create('courses_lo', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); 
            $table->string('name');
            $table->text('detail')->nullable(); 
            $table->text('knowledge')->nullable(); 
            $table->text('skills')->nullable(); 
            $table->text('autonomy_responsibility')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_lo');
    }
};
