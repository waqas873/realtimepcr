<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who generated this lab';
            $table->text('name')->nullable();
            $table->tinyInteger('type')->nullable()->comment = '1 = Main lab , 2 = Sub lab';
            $table->string('domain')->nullable();
            $table->string('city')->nullable();
            $table->string('focal_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(1)->comment = '1 = Enabled , 0 = Disabled';
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
        Schema::dropIfExists('labs');
    }
}
