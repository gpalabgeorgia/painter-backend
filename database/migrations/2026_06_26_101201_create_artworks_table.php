<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('image');                         // Изображение картины
            $table->string('category')->default('Abstract'); // Категория (например, Sticks, Abstract)
            $table->string('title');                         // Название картины (Starry Night)
            $table->decimal('price', 10, 2);                 // Цена картины ($640.00)
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
        Schema::dropIfExists('artworks');
    }
}
