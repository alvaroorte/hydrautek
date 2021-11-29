<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'biens';
    protected $fillable = array('id','nombre');
    use HasFactory;
}
