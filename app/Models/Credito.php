<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'creditos';
    protected $fillable = array('id','tipo','fecha','identificador','total','saldo');
    use HasFactory;
}
