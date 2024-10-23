<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo
    protected $table = 'places';

    // Define los campos que se pueden asignar de forma masiva (mass assignable)
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public function distanceTo($lat, $lon)
    {
        $earthRadius = 6371; // Radio de la Tierra en kilómetros

        // Convertir de grados a radianes
        $dLat = deg2rad($this->latitude - $lat);
        $dLon = deg2rad($this->longitude - $lon);

        // Aplicar la fórmula de Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat)) * cos(deg2rad($this->latitude)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calcular la distancia
        $distance = $earthRadius * $c;

        // if distance lowwe than 100m return true alse return false
        if ($distance < 0.1) {
            return true;
        } else {
            return false;
        }
    }

    // Relación con el modelo Registration (registros)
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }    
}
