<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'bancos';
    protected $fillable = array('nombre_banco','cuenta','saldo_inicial');
    use HasFactory;
}
