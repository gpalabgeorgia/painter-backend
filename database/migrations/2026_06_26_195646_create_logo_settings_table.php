<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_logo')->nullable(); // Файл росписи для хедера
            $table->string('footer_logo')->nullable(); // Файл росписи для футера
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
        Schema::dropIfExists('logo_settings');
    }
}
