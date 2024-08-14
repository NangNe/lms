<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->text('description_material')->nullable();
            $table->boolean('is_main_material')->default(false);
            $table->string('isbn', 20)->nullable();
            $table->boolean('is_hard_copy')->default(false);
            $table->boolean('is_online')->default(false);
            $table->text('note')->nullable();
            $table->string('author', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->date('published_date')->nullable();
            $table->string('edition', 50)->nullable();
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
        Schema::dropIfExists('materials');
    }
}
