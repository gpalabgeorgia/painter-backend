<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // HOME, ABOUT...
            $table->string('url');   // / , /about
            $table->integer('sort')->default(0); // Порядок сортировки
            $table->boolean('is_active')->default(true); // Тот самый флаг Активен/Неактивен
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
        Schema::dropIfExists('navigation_items');
    }
}
