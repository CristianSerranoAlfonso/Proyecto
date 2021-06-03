<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ['idEntidad', 'idAventura', 'nivel', 'turno', 'armadura', 'fuerza', 'destreza', 'inteligencia', 'cordura', 'carisma', 'sabiduria', 'caracteristica1', 'caracteristica2', 'caracteristica3', 'dinero'];
}
