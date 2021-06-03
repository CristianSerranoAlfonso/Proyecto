<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tirada extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = ["idEscenario", "idEntidad", "idHabilidad", "comentario", "tirada", "foco"];
}
