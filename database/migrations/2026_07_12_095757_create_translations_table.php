<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index(); // Например: 'menu.home', 'button.save'
            $table->string('lang_code', 5); // Сюда будут падать 'en', 'es', 'ru' и т.д.
            $table->text('value')->nullable(); // Сам текст перевода
            $table->timestamps();

            // Уникальный индекс, чтобы для одного языка не было двух одинаковых ключей
            $table->unique(['key', 'lang_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
