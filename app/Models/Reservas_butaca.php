<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Reservas_butaca extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function createButacas($data, $reserva_id)
    {
        $butaca =  new Reservas_butaca();
        $butaca->fila = $data["fila"];
        $butaca->columna = $data["columna"];
        $butaca->reserva_id = $reserva_id;

        return $butaca->save();
    }

    public static function estaReservado($fila, $columna, $fecha, $reserva_id = null)
    {

        $butacas = Reservas_butaca::join('reservas', 'reservas.id', '=', 'reservas_butacas.reserva_id')
                   ->where('fila',$fila)
                   ->where('columna', $columna)
                   ->where('fecha_reserva', $fecha)
                   ->where('reserva_id','!=', $reserva_id)
                   ->get();

        return $butacas->count() > 0;
    }

    public static function actualizarButacas($data, $id)
    {
        $butaca = Reservas_butaca::find($id);
        $butaca->fila = $data["fila"];
        $butaca->columna = $data["columna"];
        $butaca->deleted_at = null;

        return $butaca->save();
    }
}
