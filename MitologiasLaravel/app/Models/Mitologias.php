<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitologias extends Model
{
    /** @use HasFactory<\Database\Factories\MitologiasFactory> */
    use HasFactory;
    protected $fillable = [
        'Historia',
        'titulo',
        'civilizacion_id'
    ];

    public function usuariosQueGuardaron()
    {
        return $this->belongsToMany(User::class, 'mitologia_user', 'mitologia_id', 'user_id');
    }
}
