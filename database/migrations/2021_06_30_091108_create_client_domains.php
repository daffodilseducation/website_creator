<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_domains', function (Blueprint $table) {
            Schema::create('client_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('secret_key')->nullable();
            $table->string('domain')->nullable();
            $table->string('login_redirect_url')->nullable();
            $table->string('logout_redirect_url')->nullable();
            $table->string('decryption_key')->nullable();
            $table->timestamps();
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_domains', function (Blueprint $table) {
            //
        });
    }
}
