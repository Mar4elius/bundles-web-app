<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users');
            $table->string('order_number', 10)
                ->unique();
            $table->string('transaction_id')
                ->unique();
            $table->foreignId('shipping_address_id')
                ->references('id')
                ->on('address_user');
            $table->foreignId('billing_address_id')
                ->references('id')
                ->on('address_user');
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'decline'
            ])->default('pending');
            $table->boolean('payment_status')
                ->default(1);
            $table->string('payment_method')
                ->nullable();
            $table->integer('subtotal')
                ->default(0);
            $table->text('notes')
                ->nullable();
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
        Schema::dropIfExists('orders');
    }
}
