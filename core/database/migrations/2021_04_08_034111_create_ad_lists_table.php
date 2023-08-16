<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('division');
            $table->string('district');
            $table->string('title');
            $table->decimal('price',18,8);
            $table->string('description');
            $table->string('negotiable')->nullable();
            $table->string('ownership');
            $table->text('fields')->default('[]');
            $table->integer('hide_contact')->default(0);
            $table->integer('featured')->default(0);
            $table->date('expired_date')->nullable();
            $table->integer('type')->comment('1 = sell , 0 = rent');
            $table->integer('status');
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
        Schema::dropIfExists('ad_lists');
    }
}
