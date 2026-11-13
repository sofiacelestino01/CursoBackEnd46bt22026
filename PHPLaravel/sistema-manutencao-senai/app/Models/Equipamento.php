<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $fillable = [
        'tag',
        'nome',
        'setor',
        'criticidade',
        'status',
    ];
}
