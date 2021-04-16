<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_points', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment = 'user_id is from users table who generated this collection point';
            $table->text('name')->nullable();
            $table->string('domain')->nullable();
            $table->string('focal_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('city')->nullable();
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
        Schema::dropIfExists('collection_points');
    }
}
