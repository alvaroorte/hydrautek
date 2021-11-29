<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cajas';
    protected $fillable = array('id','fecha','tipo','razon_social','concepto','num_documento','importe','saldo');
    use HasFactory;
}
