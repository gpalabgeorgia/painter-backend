<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true); // Включение/выключение секции

            // Левая часть
            $table->string('left_title')->nullable();
            $table->text('left_text_1')->nullable();
            $table->text('left_text_2')->nullable();

            // Центральная часть (картина)
            $table->string('center_image')->nullable();

            // Правая часть
            $table->string('right_small_text')->nullable();

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
        Schema::dropIfExists('hero_sections');
    }
}
