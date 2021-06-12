<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on('users');
            $table->string('phone', 16)
                ->nullable();
            $table->string('address')
                ->nullable();
            $table->string('apartment')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('postal_code', 7)
                ->nullable();
            //FIXME: add location column
            $table->foreignId('province_id')
                ->nullable()
                ->references('id')
                ->on('provinces');
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
        Schema::dropIfExists('addresses');
    }
}
