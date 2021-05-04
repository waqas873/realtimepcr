<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liabilities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who created this';
            $table->tinyInteger('type')->nullable()->comment = '1 = assets , 2 = liabilities';
            $table->tinyInteger('sub_type')->nullable()->comment = '1 = current , 2 = non current';
            $table->string('name')->nullable();
            $table->integer('value')->nullable();
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
        Schema::dropIfExists('liabilities');
    }
}
