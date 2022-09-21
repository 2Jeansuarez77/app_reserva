<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Socio extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function getSocios(){
        return Socio::orderBy('nombres', 'asc')->get();
    }

    public static function create($data)
    {
        // creamos el socio
        $socio = new Socio();
        $socio->dni = $data->dni;
        $socio->nombres = $data->nombres;
        $socio->apellidos = $data->apellidos;
        $socio->fecha_alta = date("Y-m-d");

        return $socio->save();
    }

    public static function actualizarSocio($data, $id)
    {
        $socio = Socio::find($id);
        $socio->dni = $data->dni;
        $socio->nombres = $data->nombres;
        $socio->apellidos = $data->apellidos;
        return $socio->save();
    }

    public static function eliminarSocio($id){
        $socio = Socio::find($id);
        $socio->dni = null;
        $socio->save();

        return $socio->delete();
    }


}
