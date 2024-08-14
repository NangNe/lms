<?php
// database/migrations/xxxx_xx_xx_remove_description_from_majors_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDescriptionFromMajorsTable extends Migration
{
    public function up()
    {
        Schema::table('majors', function (Blueprint $table) {

            $table->dropColumn('upload_date'); 
            
        });
    }

    public function down()
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->text('description')->nullable()->after('upload_date'); // Khôi phục cột mô tả nếu cần
            $table->string('decision_number')->nullable()->after('description'); // Khôi phục cột số quyết định nếu cần
            $table->integer('total_credits')->nullable()->after('decision_number'); // Khôi phục cột tổng số tín chỉ nếu cần
            $table->date('upload_date')->nullable()->after('total_credits'); // Khôi phục cột ngày tải lên nếu cần

        });
    }
}
