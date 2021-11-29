<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $primaryKey = 'idMarca';
    protected $table = 'marcas';
    protected $fillable = array('nombreMarca','estado');


    //relacion lugar-genero
    public function genero()
    {
      return $this->belongsTo('App\Models\Genero','idGenero');
    }
}
