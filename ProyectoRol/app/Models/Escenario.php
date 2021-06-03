<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escenario extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ["idAventura", "nombre", "activo", "imagen"];

    public function enemigos(){
        return $this->belongsToMany(Enemigo::class);
    }
}
