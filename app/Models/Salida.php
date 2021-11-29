<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'salidas';
    protected $fillable = array('cantidad','fecha','id_bien','id_articulos','cliente','nit_cliente',
                        'identificador','codigo_cli','p_venta','num_factura','sccredito','scfactura',
                        'sub_total','total','descuento','created_at');
    use HasFactory;
}
