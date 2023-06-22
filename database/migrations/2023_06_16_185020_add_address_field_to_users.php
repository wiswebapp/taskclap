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
        Schema::table('users', function (Blueprint $table) {
            $table->string('house_no')->after('address')->nullable();
            $table->string('landmark')->after('house_no')->nullable();
            $table->text('address_local')->after('landmark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('house_no');
            $table->dropColumn('landmark');
            $table->dropColumn('address_local');
        });
    }
};
