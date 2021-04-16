<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who generated this patient';
            $table->char('name',100)->nullable();
            $table->char('cnic',15)->nullable();
            $table->char('age',3)->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->char('contact_no',20)->nullable();
            $table->char('email',100)->nullable();
            $table->string('image')->nullable();
            $table->integer('reffered_by')->nullable();
            $table->tinyInteger('is_deleted')->default('0');
            $table->char('sample_date')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
