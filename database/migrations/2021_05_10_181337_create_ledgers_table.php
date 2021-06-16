<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who created this';
            $table->integer('collection_point_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('embassy_user_id')->nullable();
            $table->integer('airline_user_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('system_invoice_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('amount')->nullable();
            $table->tinyInteger('is_debit')->default(0);
            $table->tinyInteger('is_credit')->default(0);
            $table->integer('balance')->nullable();
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
        Schema::dropIfExists('ledgers');
    }
}
