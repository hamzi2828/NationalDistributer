<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
     public function up()
     {
         Schema::table('coupons', function (Blueprint $table) {
             $table->integer('used_frequency')->default(0)->after('use_frequency');
         });
     }
 
     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('coupons', function (Blueprint $table) {
             $table->integer('used_frequency')->default(0)->after('use_frequency');
         });
     }
};
