<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cotizacions';
    protected $fillable = array('cantidad','sub_total','total','fecha','id_bien','id_articulos','codigo_coti','nit_cliente','validez','identificador');
    use HasFactory;
}
