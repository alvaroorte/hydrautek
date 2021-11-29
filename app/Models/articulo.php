<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articulo extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'articulos';
    protected $fillable = array('id','nombre','cantidad','id_bien','marca','reemplazo');
    use HasFactory;
}
