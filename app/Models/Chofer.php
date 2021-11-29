<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    protected $primaryKey = 'idChofer';
    protected $table = 'chofers';
    protected $fillable = array('nombre','apellidoPat','apellidoMat','ci','telefono','estado');
}
