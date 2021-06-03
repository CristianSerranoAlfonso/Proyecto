<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;
    protected $table="entidades";
    public $timestamps=false;
    protected $fillable = ['idUsuario','nombre', 'sexo', 'deidad','vida', 'precision', 'evasion', 'efectoNegativo1', 'baseEfectoNegativo1',
     'efectoNegativo2', 'baseEfectoNegativo2', 'efectoPositivo1', 'baseEfectoPositivo1', 'efectoPositivo2', 'baseEfectoPositivo2',
      'posX', 'posY', 'historia', 'imagen'];

    public function objetos(){
        return $this->belongsToMany(Objeto::class);
    }

    public function habilidades(){
        return $this->belongsToMany(Habilidad::class);
    }
}
