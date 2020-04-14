<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_id')->unsigned()->index();
            $table->bigInteger('student_id')->unsigned()->index();
            $table->bigInteger('question_id')->unsigned()->index();
            $table->string('student_answer');
            $table->string('answer');
            $table->timestamps();
        });
        Schema::table("answers", function(Blueprint $table){
            $table->foreign("test_id")->references("id")->on("tests");
            $table->foreign("student_id")->references("id")->on("students");
            $table->foreign("question_id")->references("id")->on("questions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
