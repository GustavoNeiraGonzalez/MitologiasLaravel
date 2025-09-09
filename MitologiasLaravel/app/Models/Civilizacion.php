<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civilizacion extends Model
{
    /** @use HasFactory<\Database\Factories\CivilizacionFactory> */
    use HasFactory;
    protected $table = 'civilizaciones'; // <- nombre real de tu tabla en la
    // base de datos

    protected $fillable = ['civilizacion'];//campos que se pueden llenar

    public function mitologias()
    {
        return $this->hasMany(Mitologias::class);
    }

}
