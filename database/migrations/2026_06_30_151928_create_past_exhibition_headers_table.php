<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePastExhibitionHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_exhibition_headers', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->default('Past Exhibitions'); // Левый заголовок
            $table->text('section_description'); // Правый текст
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
        Schema::dropIfExists('past_exhibition_headers');
    }
}
