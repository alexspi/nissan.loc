<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelCompatibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_compatibility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mark');
            $table->string('market');
            $table->string('model');
            $table->string('modif');
            $table->string('date');
            $table->string('body');
            $table->string('engine');
            $table->string('trans');
            $table->timestamps();
        });


        Schema::create('prso_products_model_compatibility', function (Blueprint $table) {
            $table->integer('model_id')->unsigned()->index();
            $table->foreign('model_id')->references('id')->on('model_compatibility')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('prso_products')->onDelete('cascade');

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
        Schema::drop('model_compatibility');
        Schema::drop('prso_products_model_compatibility');
    }
}
