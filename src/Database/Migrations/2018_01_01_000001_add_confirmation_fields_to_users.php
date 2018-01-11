<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmationFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     * Add the confirmed and confirmation_token columns
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * Remove the confirmed and confirmation_token columns
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('confirmed');
            $table->dropColumn('confirmation_token');
        });
    }
}
