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
        Schema::table('plos', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['major_id']); // Tên cột khóa ngoại
    
            // Xóa cột major_id
            $table->dropColumn('major_id');
        });
    }
    
    public function down()
    {
        Schema::table('plos', function (Blueprint $table) {
            // Khôi phục cột major_id nếu cần
            $table->unsignedBigInteger('major_id');
    
            // Khôi phục khóa ngoại nếu cần
            $table->foreign('major_id')->references('id')->on('majors');
        });
    }
    
};
