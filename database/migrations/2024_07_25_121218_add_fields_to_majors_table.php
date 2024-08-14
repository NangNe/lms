<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFieldsToMajorsTable extends Migration
{
    public function up()
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->timestamp('upload_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->after('name'); // Ngày tải lên với thời gian hiện tại
            $table->text('description')->nullable()->after('upload_date'); // Mô tả
            $table->string('decision_number')->nullable()->after('description'); // Số quyết định
            $table->integer('total_credits')->nullable()->after('decision_number'); // Tổng số tín chỉ
        });
    }

    public function down()
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn(['upload_date', 'description', 'decision_number', 'total_credits']);
        });
    }
}

