<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            // Привязка к клиенту. Если удалить клиента, удалятся и его адреса (onDelete('cascade'))
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // Данные получателя для конкретного адреса
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable(); // Телефон, как ты просил, может быть не указан

            // География
            $table->string('country');
            $table->string('region')->nullable();
            $table->string('city');
            $table->string('zip_code');
            $table->text('address');

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
        Schema::dropIfExists('customer_addresses');
    }
}
