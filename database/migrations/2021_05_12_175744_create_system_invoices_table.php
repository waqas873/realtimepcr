<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who created this';
            $table->integer('collection_point_id')->nullable();
            $table->integer('lab_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->integer('embassy_user_id')->nullable();
            $table->integer('airline_user_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->integer('amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_recieved')->default(1);

            $table->integer('amount_id')->nullable();
            $table->tinyInteger('is_bank_payment')->default(0);
            $table->integer('account_category_id')->nullable();
            $table->tinyInteger('is_journal')->default(0);

            $table->date('date')->nullable();
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
        Schema::dropIfExists('system_invoices');
    }
}
