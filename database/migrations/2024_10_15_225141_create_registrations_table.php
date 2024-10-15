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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade'); // Clave foránea de places
            $table->timestamp('registered_at'); // Hora de registro
            $table->string('photo_path'); // Ruta a la foto enviada
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
