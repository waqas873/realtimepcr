<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_test_results', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who added this history';
            $table->tinyInteger('type')->comment = 'type is the same from reporting units table.';
            $table->integer('patient_test_id')->nullable();
            $table->string('dropdown_value')->nullable();
            $table->string('input_value')->nullable();
            $table->string('specie')->nullable();
            $table->string('duration')->nullable();
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('patient_test_results');
    }
}
