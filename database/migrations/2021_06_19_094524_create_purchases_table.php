<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who created this';
            $table->integer('supplier_id')->nullable();
            $table->integer('purchase_type')->nullable();
            $table->integer('price')->default(0);
            $table->string('unique_id')->nullable();
            $table->integer('advance_payment')->default(0);
            $table->integer('remaining_balance')->default(0);
            $table->date('date')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
