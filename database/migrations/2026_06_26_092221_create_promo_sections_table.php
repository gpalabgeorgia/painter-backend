<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_sections', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();       // Путь к изображению художника
            $table->string('title');                   // Заголовок (Learn Painting)
            $table->text('description');               // Текстовое описание
            $table->string('button_text')->default('START NOW'); // Текст на кнопке
            $table->string('button_url')->nullable();  // Ссылка для кнопки
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
        Schema::dropIfExists('promo_sections');
    }
}
