<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who added this test';
            $table->integer('patient_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('test_id')->nullable();
            $table->integer('test_profile_id')->nullable();
            $table->tinyInteger('type')->default(1)->comment = '1 = simple test , 2 = covid test ';
            $table->tinyInteger('api_sent')->default(0)->comment = '0 = this is not an api deliver test , 1 = passenger detail is delivered to api  , 2 = Test results are sent to api';
            $table->tinyInteger('api_cancelled')->default(0);
            $table->tinyInteger('status')->default('0')->comment = '0 = pending , 1 = detected for covid , 2 = not detected for covid';
            $table->integer('processed_by')->nullable();
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
        Schema::dropIfExists('patient_tests');
    }
}
