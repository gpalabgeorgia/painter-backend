<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_sections', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true); // Включение/выключение видео
            $table->string('video_url')->required();     // Ссылка на YouTube / Vimeo / файл
            $table->string('video_cover')->nullable();   // Фоновое изображение (превью), если нужно
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
        Schema::dropIfExists('video_sections');
    }
}
