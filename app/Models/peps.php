<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peps extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'peps';
    protected $fillable = array('id','cantidad','costo','id_articulo');
    use HasFactory;
}
