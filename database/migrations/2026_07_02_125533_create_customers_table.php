<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Имя
            $table->string('last_name'); // Фамилия
            $table->string('email')->unique(); // Эл. почта
            $table->string('phone')->nullable(); // Телефон (необязательное)
            $table->string('avatar')->nullable(); // Фото / Аватар
            $table->string('password'); // Пароль
            $table->rememberToken();
            $table->timestamps(); // Это автоматически создаст created_at (дата регистрации)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
