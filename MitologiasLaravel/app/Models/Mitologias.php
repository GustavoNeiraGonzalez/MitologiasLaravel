<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitologias extends Model
{
    /** @use HasFactory<\Database\Factories\MitologiasFactory> */
    use HasFactory;
    protected $fillable = [
        'Historia'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
