<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 20)->unique();
            $table->string('bio_id', 30)->unique();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('designation_id')->constrained('designations');
            $table->date('joining_date')->index();
            $table->string('name');
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->enum("gender", ["Male", "Female", "Other"])->index();
            $table->enum("merital_status", ["Single", "Married", "Divorce", "Widowed"])->index();
            $table->date('birth_date');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->float('salary_range');
            $table->string('image')->nullable();
            $table->char('status', 10)->default('a')->index();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('ip_address', 100)->nullable();
            $table->integer('branch_id')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
