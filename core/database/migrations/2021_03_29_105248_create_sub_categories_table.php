<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned();
            $table->string('name',60)->unique();
            $table->string('slug',60)->unique();
            $table->integer('status')->unsigned();
            $table->integer('sell')->unsigned();
            $table->integer('rent')->unsigned();
            $table->integer('rent_type')->comment('0 = no type, 1 = daily, 2 = 7days, 3 = 30days, 4 = 365days');
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
        Schema::dropIfExists('sub_categories');
    }
}
