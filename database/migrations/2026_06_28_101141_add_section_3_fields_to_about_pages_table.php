<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSection3FieldsToAboutPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('s3_title')->nullable(); // Заголовок "Awards"

            // ЗАМЕНИЛИ json НА text. Теперь база схавает это без ошибок!
            $table->text('s3_logos')->nullable();

            $table->text('s3_text')->nullable();    // Описание под логотипами
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('about_pages', function (Blueprint $table) {
            $table->dropColumn(['s3_title', 's3_logos', 's3_text']);
        });
    }
}
