<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    use HasFactory;
    protected $table="habilidades";
    public $timestamps=false;
    protected $fillable = ['nombre', 'facultadNegativa', 'baseFacultadNegativa','facultadPositiva', 'baseFacultadNegativa',
     'facultadPositiva', 'nivelHabilidad', 'dado', 'valorBase', 'ataque', 'area', 'usuario_id'];

     public function entidades(){
        return $this->belongsToMany(Entidad::class);
    }
}
