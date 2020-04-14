<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("fn");
            $table->string("mn");
            $table->string("ln")->nullable()->default(null);
            $table->integer("code")->default(random_int(000000, 999999));
            $table->integer("point")->default(null);
            $table->json("result")->nullable()->default(null);
            $table->boolean('passed')->default(false);
            $table->bigInteger("test_id")->unsigned()->index();
            $table->bigInteger("user_id")->unsigned()->index();
            $table->timestamps();
        });
        Schema::table("students", function(Blueprint $table){
            $table->foreign("test_id")->references("id")->on("tests");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
