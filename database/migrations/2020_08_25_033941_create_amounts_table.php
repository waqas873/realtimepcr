<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('from_user')->nullable()->comment = 'from_user is user_id who transffered amount.';
            $table->string('description')->nullable();
            $table->integer('patient_id')->nullable();
            $table->tinyInteger('type')->nullable()->comment = '0 = amount from patient , 1 = amount from other staff member or admin , 2 = expense';
            $table->tinyInteger('is_accepted')->default('0')->comment = '1 = make it accepted or rejected , 2 = accepted , 3 = rejected';
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
        Schema::dropIfExists('amounts');
    }
}
