<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enemigo extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ["idEntidad", "fuerza", "jefe"];

    public function escenarios(){
        return $this->belongsToMany(Escenario::class);
    }
}
