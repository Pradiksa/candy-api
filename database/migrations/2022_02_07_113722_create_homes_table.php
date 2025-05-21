<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->string('POne_SecOne_TxtOne');
            $table->string('POne_SecOne_TxtTwo');
            $table->string('POne_SecOne_Img');
            $table->string('POne_SecTwo_Txt');
            $table->string('POne_SecTwo_Img');
            $table->string('POne_SecThree_ImgOne');
            $table->string('POne_SecThree_ImgTwo');
            $table->string('POne_SecThree_ImgThree');
            $table->string('POne_SecThree_Txt');
            $table->string('POne_SecThree_ImgFour');
            $table->string('POne_SecFour_Txt');
            $table->string('POne_SecFour_Img');
            
           

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
        Schema::dropIfExists('homes');
    }
}
