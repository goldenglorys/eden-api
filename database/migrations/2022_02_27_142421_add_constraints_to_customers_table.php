<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('location_area')->references('id')
                ->on('location_areas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('country_of_domicile')->references('id')
                ->on('countries_of_domicile')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('gardener')->references('id')
                ->on('gardeners')->cascadeOnDelete()->cascadeOnUpdate();
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
            $table->dropForeign('customers_location_area_foreign');
            $table->dropForeign('customers_countries_of_domicile_foreign');
            $table->dropForeign('customers_gardener_foreign');
        });
    }
};
