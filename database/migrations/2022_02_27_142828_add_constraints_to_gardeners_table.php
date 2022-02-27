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
        Schema::table('gardeners', function (Blueprint $table) {
            $table->foreign('location_area')->references('id')
                ->on('location_areas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('country_of_domicile')->references('id')
                ->on('countries_of_domicile')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gardeners', function (Blueprint $table) {
            $table->dropForeign('gardeners_location_area_foreign');
            $table->dropForeign('gardeners_countries_of_domicile_foreign');
        });
    }
};
