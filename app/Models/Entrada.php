<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'entradas';
    protected $fillable = array('cantidad','p_total','total','fecha','id_bien','id_articulos','proveedor','nit_proveedor','identificador','detalle','p_unitario','num_factura','cscredito','csfactura','codigo','created_at');
    use HasFactory;
}
