<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('reporting_hrs')->nullable();
            $table->integer('sample_id')->nullable();
            $table->integer('reporting_unit_id')->nullable();
            $table->string('units')->nullable();
            $table->string('normal_value')->nullable();
            $table->integer('price')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('test_category_id')->nullable();
            $table->tinyInteger('registration_type')->default(1)->comment = '1 = local patient , 2 = overseas patient';
            $table->tinyInteger('type')->default('1')->comment = '1 = simple test , 2 = Covid test';
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('tests');
    }
}
