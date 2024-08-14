<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('topic');
            $table->integer('number_of_periods');
            $table->text('objectives')->nullable();
            $table->string('clos')->nullable();
            $table->string('lecture_method')->nullable();
            $table->string('active')->nullable();
            $table->string('s_download')->nullable(); // Lưu trữ đường dẫn file tải lên
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
