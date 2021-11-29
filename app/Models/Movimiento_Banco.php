<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento_Banco extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'movimiento_bancos';
    protected $fillable = array('id','id_banco','fecha','tipo','razon_social','concepto','num_documento','importe');
    use HasFactory;
}
