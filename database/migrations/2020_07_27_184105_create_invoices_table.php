<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('unique_id')->nullable();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who generated this invoice';
            $table->integer('patient_id')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->decimal('total_discount', 8, 2)->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('amount_remaining')->nullable();
            $table->integer('delivery_time')->nullable();
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('invoices');
    }
}
