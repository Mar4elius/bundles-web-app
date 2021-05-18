<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')
                ->nullable();
            $table->string('apartment')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->foreignId('province_id')
                ->nullable()
                ->references('id')
                ->on('provinces');
            $table->string('postal_code')
                ->nullable();
            //FIXME: add location column
            $table->string('phone', 13)
                ->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('profile_photo_path')
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
        Schema::dropIfExists('users');
    }
}
