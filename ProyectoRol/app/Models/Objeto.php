<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ["idUsuario","nombre", "rango", "tipo", "armadura", "fuerza", "destreza", "inteligencia", "cordura", "sabiduria", "evasion", "precio", "descripcion", "imagen"];

    public function entidades(){
        return $this->belongsToMany(Entidad::class);
    }
}
