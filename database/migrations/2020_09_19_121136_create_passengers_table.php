<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who generated this passenger';
            $table->integer('patient_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('airline')->nullable();
            $table->integer('country_id')->nullable();
            //$table->string('collection_point')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('flight_date')->nullable();
            $table->string('flight_time')->nullable();
            $table->string('booking_ref_no')->nullable();
            $table->string('ticket_no')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
