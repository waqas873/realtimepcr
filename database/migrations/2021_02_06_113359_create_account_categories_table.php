<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who added this category';
            $table->string('name')->nullable();
            $table->tinyInteger('type')->nullable()->comment = '1 = cash payment , 2 = cash recieved';
            $table->tinyInteger('status')->default(1)->comment = '0 = inactive , 1 = active';
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
        Schema::dropIfExists('account_categories');
    }
}
