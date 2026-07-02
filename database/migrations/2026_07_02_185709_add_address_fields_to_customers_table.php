<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('country')->nullable()->after('phone');
            $table->string('region')->nullable()->after('country'); // Регион / Область
            $table->string('city')->nullable()->after('region');
            $table->string('zip_code')->nullable()->after('city');
            $table->text('address')->nullable()->after('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['country', 'region', 'city', 'zip_code', 'address']);
        });
    }
}
