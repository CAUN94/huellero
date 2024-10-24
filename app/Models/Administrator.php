<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Obtener todos los usuarios que son administradores
    public static function getAllAdmins()
    {
        return User::whereIn('id', self::pluck('user_id'))->get();
    }
}
