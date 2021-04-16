<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who added this category';
            $table->string('name')->nullable();
            $table->tinyInteger('type')->nullable()->comment = '1 = Chain Reaction / PCR / No PCR , 2 = Test Medicines , 3 = Genotype Reports Categories , 4 = parameters';
            $table->string('medicine_label')->nullable();
            $table->string('units')->nullable();
            $table->string('normal_value')->nullable();
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
        Schema::dropIfExists('test_categories');
    }
}
