<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_pages', function (Blueprint $table) {
            // Поля для Секции 1
            $table->id(); // <--- ЭТОТ ПУНКТ ОБЯЗАТЕЛЕН, ОН СОЗДАЕТ КОЛОНКУ 'id'

            $table->string('s1_title')->nullable();
            $table->string('s1_image')->nullable();
            $table->string('s1_subtitle')->nullable();
            $table->text('s1_text')->nullable();

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
        Schema::dropIfExists('about_pages');
    }
}
