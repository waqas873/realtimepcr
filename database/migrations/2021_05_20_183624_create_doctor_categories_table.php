<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'who created this';
            $table->integer('doctor_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->tinyInteger('custom_prizes')->default(1);
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
        Schema::dropIfExists('doctor_categories');
    }
}
