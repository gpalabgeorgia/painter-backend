<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtworkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');       // Название (Stonewall, Analogue...)
            $table->string('image');       // Картинка
            $table->text('description');   // Короткий текст под названием
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
        Schema::dropIfExists('artwork_items');
    }
}
