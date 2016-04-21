<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GAOffices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('GAOffices', function ($table) {
            $table->increments('id');
            $table->string('UID', 100);
            $table->string('Name', 255);
            $table->string('Email', 255);
            $table->string('Phone', 20);
            $table->string('Logo_URL', 255);
            $table->integer('Logo_ID');
            $table->string('DomainName', 255);
            $table->integer('isActive')->default(1);
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
        Schema::drop('GAOffices');
    }
}
