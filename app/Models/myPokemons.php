<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class myPokemons extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'img',
        'move',
        'type',
        'user_id',
    ];
}
