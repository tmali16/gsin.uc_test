<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("test_id")->unsigned()->index();
            $table->string("question_kg")->nullable()->default(null);;
            $table->string("question_ru")->nullable()->default(null);;
            $table->string("a_kg");
            $table->string("a_ru");
            $table->string("b_kg");
            $table->string("b_ru");
            $table->string("c_kg")->nullable()->default(null);
            $table->string("c_ru")->nullable()->default(null);
            $table->string("d_kg")->nullable()->default(null);
            $table->string("d_ru")->nullable()->default(null);
            $table->string("answer")->nullable()->default(null);
            $table->timestamps();
        });
        Schema::table("questions", function(Blueprint $table){
            $table->foreign("test_id")->references("id")->on("tests");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
