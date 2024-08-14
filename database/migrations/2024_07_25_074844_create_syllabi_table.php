<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyllabiTable extends Migration
{
    public function up()
    {
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');  // Khóa ngoại liên kết với bảng courses
            $table->string('title');  // Tiêu đề đề cương
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('syllabi');
    }
}