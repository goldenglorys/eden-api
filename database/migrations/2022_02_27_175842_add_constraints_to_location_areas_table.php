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
        Schema::table('location_areas', function (Blueprint $table) {
            $table->foreign('country')->references('id')
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
        Schema::table('location_areas', function (Blueprint $table) {
            $table->dropForeign('location_areas_country_foreign');
        });
    }
};
