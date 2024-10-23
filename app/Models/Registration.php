<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',        // ID del usuario
        'place_id',       // ID del lugar
        'registered_at',  // Timestamp del registro
        'photo_path',     // Campo nulo o path de la foto (si lo tienes)
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    // Relación con el modelo User (usuarios)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Place (lugares)
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // countRegistrations static

}
