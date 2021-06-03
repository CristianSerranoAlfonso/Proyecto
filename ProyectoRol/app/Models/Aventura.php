<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aventura extends Model
{
    use HasFactory;
    protected $table="aventuras";
    public $timestamps=false;
    protected $fillable = ["idUsuario", "nombre"];
}
