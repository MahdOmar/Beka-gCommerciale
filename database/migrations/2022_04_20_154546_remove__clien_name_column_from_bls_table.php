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
        Schema::table('bls', function (Blueprint $table) {
            $table->dropColumn('ClientName');
            $table->dropColumn('ClientPhone');
            $table->dropColumn('ClientAdress');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bls', function (Blueprint $table) {
            //
        });
    }
};
