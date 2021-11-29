<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pagos';
    protected $fillable = array('id','nombre','ci','monto','id_credito','fecha','tipo');
    use HasFactory;
}
