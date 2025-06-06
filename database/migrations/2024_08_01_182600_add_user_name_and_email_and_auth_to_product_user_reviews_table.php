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
        Schema::table('product_user_reviews', function (Blueprint $table) {
            $table->string('user_name')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('user_name');
            $table->foreignId('user_id')->nullable()->change();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_user_reviews', function (Blueprint $table) {
            //
        });
    }
};
