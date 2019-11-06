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
            // $table->bigIncrements('id');
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();

            $table->bigIncrements('id');
            $table->boolean('is_admin');
            $table->unsignedBigInteger('job_title_id');
            $table->string('last_name', 20);
            $table->string('first_name', 20);
            $table->string('last_name_kana', 50);
            $table->string('first_name_kana', 50);
            $table->string('profile_image_path', 50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->enum('gender', ['male', 'female']);
            $table->date('hired_at');
            $table->date('birth_at');
            $table->string('remarks', 300)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('job_title_id')->references('id')->on('job_titles');
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
