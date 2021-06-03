<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rel_enemigo_escenario extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="enemigo_escenario";
    protected $fillable = ['enemigo_id', 'escenario_id'];
}
