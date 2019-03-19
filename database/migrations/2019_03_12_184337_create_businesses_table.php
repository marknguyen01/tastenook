<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');

            // Business address
            $table->string('address');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip_code', 5);

            $table->double('vote_avg', 2, 1)->default(0);

            // Stats
            $table->integer('vote_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('view_count')->default(0);


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
        Schema::dropIfExists('businesses');
    }
}
