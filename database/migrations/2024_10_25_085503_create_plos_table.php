<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major_id'); // Foreign key đến bảng majors
            $table->string('name'); // tên PLO
            $table->text('description'); // Mô tả chuẩn đầu ra
            $table->timestamps();

            // Thiết lập khóa ngoại đến bảng majors
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plos');
    }
}
