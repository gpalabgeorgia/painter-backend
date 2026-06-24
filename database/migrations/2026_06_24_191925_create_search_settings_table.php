<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Результаты поиска');
            $table->string('no_results_title')->default('Ничего не найдено');
            $table->text('no_results_text'); // Убрали дефолтное значение отсюда
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
        Schema::dropIfExists('search_settings');
    }
}
