<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mitologias', function (Blueprint $table) {
            //
        $table->unsignedBigInteger('civilizacion_id'); // crea la columna
        $table->foreign('civilizacion_id')
            ->references('id')
            ->on('civilizaciones')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitologias', function (Blueprint $table) {
            //
            $table->dropForeign(['civilizacion_id']);
            $table->dropColumn('civilizacion_id');
        });
    }
};
