<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->default('Exhibitions'); // Название страницы
            $table->string('subtitle')->default('CURRENT EXHIBITION'); // Маленький текст слева
            $table->string('title'); // Название выставки
            $table->date('start_date'); // Дата начала
            $table->date('end_date'); // Дата окончания
            $table->text('description'); // Короткий текст-описание справа
            $table->string('bg_image')->nullable(); // Фоновое изображение баннера
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
        Schema::dropIfExists('current_exhibitions');
    }
}
