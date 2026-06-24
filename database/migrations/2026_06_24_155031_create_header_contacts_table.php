<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type');  // phone, email, telegram, instagram, vk...
            $table->string('value'); // +7..., test@mail.ru, https://...
            $table->string('label')->nullable(); // Название для удобства админа
            $table->boolean('is_active')->default(true); // Тоже можно скрыть
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
        Schema::dropIfExists('header_contacts');
    }
}
