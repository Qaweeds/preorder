<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('goodsgroup_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();

            $table->string('photo');
            $table->boolean('ready_or_not')->default(1);
            $table->string('delivery');
            $table->string('season');
            $table->date('date_start_sale');
            $table->decimal('price');
            $table->text('comment')->nullable();
            $table->decimal('rating')->nullable();
            $table->integer('votes_count')->nullable();
            $table->decimal('rating_total')->nullable();
            $table->string('channel');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('goodsgroup_id')->references('id')->on('goodsgroups');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('country_id')->references('id')->on('countries');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
