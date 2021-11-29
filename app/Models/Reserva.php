<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'reservas';
    protected $fillable = array('fecha','num_reserva','id_bien','id_articulo','cantidad','codigo_reserva',
    'detalle','nit_cliente','cliente','id_cliente','p_venta','sub_total','total','descuento','identificador');
    use HasFactory;
}
