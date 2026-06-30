<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePastExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название картины / выставки (например: Convallis Arcu)
            $table->text('description')->nullable(); // Маленькое описание под названием
            $table->string('image'); // Фотография картины
            $table->integer('sort_order')->default(0); // Порядок сортировки (чтобы можно было менять их местами)
            $table->boolean('is_active')->default(true); // Активно ли отображение
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
        Schema::dropIfExists('past_exhibitions');
    }
}
