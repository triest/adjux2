<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->nullable(true);
            $table->string('name', 50)->nullable(true);
            $table->string('femili', 50)->nullable(true);
            $table->string('phone', 50)->nullable(true);
            $table->text('description')->nullable(true);
            $table->bigInteger('education_id')->nullable()->unsigned()->index();
            $table->string('ip', 50)->nullable(true);
            $table->string('email');
            $table->timestamps();

        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a');
    }
}
