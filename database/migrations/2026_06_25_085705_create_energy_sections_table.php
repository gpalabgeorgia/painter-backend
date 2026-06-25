<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergySectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_sections', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true); // Включатель/выключатель секции

            // Текстовый контент
            $table->text('title')->nullable(); // Большой главный заголовок
            $table->text('text_1')->nullable(); // Абзац текста 1
            $table->text('text_2')->nullable(); // Абзац текста 2

            // Заготовки на будущее (пока просто поля в базе)
            $table->string('read_more_url')->nullable();
            $table->string('instagram_count')->nullable();
            $table->string('tumblr_count')->nullable();
            $table->string('facebook_count')->nullable();

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
        Schema::dropIfExists('energy_sections');
    }
}
