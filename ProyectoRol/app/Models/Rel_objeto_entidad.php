<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rel_objeto_entidad extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="entidad_objeto";
    protected $fillable = ['entidad_id', 'objeto_id'];
}
