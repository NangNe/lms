<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id(); // ID của assignment (tự động tăng)
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('component_name', 255);
            $table->float('weight'); 
            $table->text('clo_ids')->nullable(); 
            $table->string('assessment_type', 255)->nullable(); 
            $table->string('assessment_tool', 255)->nullable(); 
            $table->float('clo_weight')->nullable(); 
            $table->text('plos')->nullable(); 
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
        Schema::dropIfExists('assignments');
    }
}
