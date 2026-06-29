<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtworksPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks_pages', function (Blueprint $table) {
            $table->id();

            // Первая секция (как на макете image_40a5aa.png)
            $table->string('s1_title')->nullable();        // Главный заголовок (Artworks)
            $table->string('s1_image')->nullable();        // Картина в раме
            $table->string('s1_subtitle')->nullable();     // Второе название под текстом (Conversation)
            $table->text('s1_text')->nullable();           // Текст описания (At sit molestie massa...)

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
        Schema::dropIfExists('artworks_pages');
    }
}
