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
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('role')->nullable()->comment = '1=admin , 2=doctors , 0=receptionist , 3 = covid staff , 4 = lab user , 5 = collection point user , 6 = airline user';
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('lab_id')->nullable();
            $table->integer('collection_point_id')->nullable();
            $table->integer('airline_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->char('cnic',15)->nullable();
            $table->char('contact_no',20)->nullable();
            $table->integer('pay')->nullable();
            $table->tinyInteger('status')->default(1)->comment = '0 = inactive , 1 = active';
            $table->rememberToken();
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
