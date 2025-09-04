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
            $table->string('titulo')->after('id'); // 👈 agrega el campo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitologias', function (Blueprint $table) {
            //
        });
    }
};
