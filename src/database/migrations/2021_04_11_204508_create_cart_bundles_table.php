<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')
                ->references('id')
                ->on('carts');
            $table->foreignId('order_id')
                ->references('id')
                ->on('orders');
            $table->integer('quantity')
                ->default(1);
            $table->integer('price_per_bundle')
                ->default(1);
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
        Schema::dropIfExists('cart_bundles');
    }
}
