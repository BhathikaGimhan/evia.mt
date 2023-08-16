<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormBuildersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_builders', function (Blueprint $table) {
            $table->id();
            $table->integer('subcategory_id');
            $table->integer('type')->comment('1 = input, 2 = select, 3 = checkbox, 4 = textarea, 5 = radio');
            $table->string('label');
            $table->string('name');
            $table->string('placeholder');
            $table->integer('required')->comment('1 = yes, 0 = no');
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
        Schema::dropIfExists('form_builders');
    }
}
