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
            $table->string('avatar')->default('/images/default_business.jpg');

            // Business address
            $table->string('street_address');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip_code', 5);
            $table->string('phone_number', 10);

            $table->string('website');

            // Business Geopoint
            $table->unsignedDecimal('lng')->default(0);
            $table->unsignedDecimal('lat')->default(0);

            $table->double('rating_avg', 2, 1)->default(0);

            // Stats
            $table->integer('view_count')->default(0);
            $table->integer('review_count')->default(0);


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
