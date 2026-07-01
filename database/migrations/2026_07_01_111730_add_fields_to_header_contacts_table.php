<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToHeaderContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('header_contacts', function (Blueprint $table) {
            $table->string('contact_title')->nullable()->default('Get in touch');
            $table->text('contact_description')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('header_contacts', function (Blueprint $table) {
            //
        });
    }
}
