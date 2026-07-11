<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Связь с таблицей покупателей (customers)
            // Если твоя таблица называется по-другому, замени 'customers' на её имя
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // Полный адрес доставки (текстовое поле, так как адреса могут быть длинными)
            $table->text('delivery_address');

            // Статус заказа с дефолтным значением 'new'
            $table->string('status')->default('new');

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
        Schema::dropIfExists('orders');
    }
}
