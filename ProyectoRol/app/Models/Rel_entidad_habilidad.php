<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rel_entidad_habilidad extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="entidad_habilidad";
    protected $fillable = ['entidad_id', 'habilidad_id'];
}
