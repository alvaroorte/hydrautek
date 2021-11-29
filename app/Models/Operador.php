<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'operadors';
    protected $fillable = array('id','nombre','apellidopat','apelliodmat','cargo');
    use HasFactory;
}
