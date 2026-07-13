<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_translations', function (Blueprint $table) {
            $table->id();

            // Полиморфная связь (создаст сразу два поля: translatable_type и translatable_id)
            // Это позволит привязывать перевод к ЛЮБОЙ модели (Exhibition, Artwork, Page и т.д.)
            $table->morphs('translatable');

            // Какое именно поле мы перевели (например: 's1_title', 'description', 'name')
            $table->string('field');

            // Код языка (например: 'en', 'fr')
            $table->string('lang_code', 10);

            // Сам переведенный текст (ставим longText, чтобы влезали и огромные статьи, и мелкие кнопки)
            $table->longText('value')->nullable();

            $table->timestamps();

            // Индекс для молниеносного поиска переводов
            $table->index(['translatable_type', 'translatable_id', 'field', 'lang_code'], 'content_trans_main_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_translations');
    }
}
