<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSection2FieldsToAboutPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            // Поля для Секции 2 (Цитата)
            $table->string('s2_image')->nullable();     // Фото художника для цитаты
            $table->text('s2_quote')->nullable();       // Текст цитаты
            $table->string('s2_signature')->nullable(); // Файл подписи (svg/png)
            $table->string('s2_name')->nullable();      // Имя художника
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            //
        });
    }
}
