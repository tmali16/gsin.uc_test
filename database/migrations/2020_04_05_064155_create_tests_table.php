<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string("title_kg");
            $table->string("title_ru");
            $table->text("description_kg")->nullable()->default(null);
            $table->text("description_ru")->nullable()->default(null);
            $table->boolean("state")->default(false);
            $table->integer("timer");
            $table->integer("question_count");
            $table->integer("min_correct")->default("0");
            $table->integer("question_rand");
            $table->bigInteger("user_id")->unsigned()->index();
            $table->timestamps();
        });
        Schema::table("tests", function(Blueprint $table){
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
        Schema::dropIfExists('tests');
    }
}
