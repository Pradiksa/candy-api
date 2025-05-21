<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('PTwo_SecOne_TxtOne');
            $table->string('PTwo_SecOne_TxtTwo');
            $table->string('PTwo_SecOne_TxtThree');
            $table->string('PTwo_SecOne_TxtFour');
            $table->string('PTwo_SecOne_TxtFive');
            $table->string('PTwo_SecOne_Img');
            $table->string('PTwo_SecTwo_Img');
            $table->string('PTwo_SecTwo_TxtOne');
            $table->string('PTwo_SecTwo_TxtTwo');
            $table->string('PTwo_SecTwo_TxtThree');
            $table->string('PTwo_SecTwo_TxtFour');
            $table->string('PTwo_SecThree_TxtOne');
            $table->string('PTwo_SecThree_TxtTwo');
            $table->string('PTwo_SecThree_TxtThree');
            $table->string('PTwo_SecThree_Img');
            $table->string('PTwo_SecFour_Img');
            $table->string('PTwo_SecFour_TxtOne');
            $table->string('PTwo_SecFour_TxtTwo');
            $table->string('PTwo_SecFour_TxtThree');
            $table->string('PTwo_SecFive_Policy');
            $table->string('MoreOne_SecOne');
            $table->string('MoreOne_SecTwo_TxtOne');
            $table->string('MoreOne_SecTwo_ColOne');
            $table->string('MoreOne_SecTwo_ColTwo');
            $table->string('MoreOne_SecTwo_ColThree');
            $table->string('MoreOne_SecThree_Txt');
            $table->string('MoreOne_SecThree_Img');
            $table->string('MoreTwo_SecOne');
            $table->string('MoreTwo_SecTwo_TxtOne');



            $table->string('MoreTwo_SecTwo_ColOne');
            $table->string('MoreTwo_SecTwo_ColTwo');
            $table->string('MoreTwo_SecTwo_ColThree');
            $table->string('MoreTwo_SecThree_Txt');
            $table->string('MoreTwo_SecThree_Img');
            $table->string('MoreThree_SecOne');
            $table->string('MoreThree_SecTwo');
            $table->string('MoreThree_SecThree_Txt');
            $table->string('MoreThree_SecThree_Img');
            $table->string('MoreFour_SecOne');
            $table->string('MoreFour_SecTwo');
            $table->string('MoreFour_SecThree_Txt');
            $table->string('MoreFour_SecThree_Img');
           
            

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
        Schema::dropIfExists('courses');
    }
}
