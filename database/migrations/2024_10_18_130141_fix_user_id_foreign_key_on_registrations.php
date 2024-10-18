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
        Schema::table('registrations', function (Blueprint $table) {
            // Eliminar la clave foránea incorrecta
            $table->dropForeign(['user_id']);

            // Agregar la clave foránea correcta apuntando a la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Eliminar la clave foránea correcta
            $table->dropForeign(['user_id']);

            // Restaurar la clave foránea incorrecta si fuera necesario
            $table->foreign('user_id')->references('id')->on('registrations')->onDelete('cascade');
        });
    }
};
