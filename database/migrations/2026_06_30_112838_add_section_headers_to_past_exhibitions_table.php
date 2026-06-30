<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionHeadersToPastExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('past_exhibitions', function (Blueprint $table) {
            $table->string('section_title')->nullable()->default('Past Exhibitions');
            $table->text('section_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('past_exhibitions', function (Blueprint $table) {
            $table->dropColumn(['section_title', 'section_description']);
        });
    }
}
