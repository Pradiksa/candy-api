<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLashtalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lashtalks', function (Blueprint $table) {
            $table->id();
            $table->string('PFour_SecOne_TxtOne');
            $table->string('PFour_SecOne_TxtTwo');
            $table->string('PFour_SecTwo_TxtOne');
            $table->string('PFour_SecTwo_TxtTwo');
            $table->string('PFour_SecThree_TxtOne');
            $table->string('PFour_SecThree_TxtTwo');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lashtalks');
    }
}
