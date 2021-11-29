<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'proveedors';
    protected $fillable = array('nombre','codigo_prov','nit','celular');
    use HasFactory;
}
