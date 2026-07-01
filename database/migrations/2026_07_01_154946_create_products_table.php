<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');                     // Название картины (Analogue, Majesty)
            $table->string('subtitle')->nullable();      // Второстепенное название (Abstract, Landscape)
            $table->string('image');                     // Путь к картинке
            $table->decimal('price', 10, 2);             // Цена (800.00)
            $table->boolean('is_active')->default(true); // Видимость в магазине
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
        Schema::dropIfExists('products');
    }
}
