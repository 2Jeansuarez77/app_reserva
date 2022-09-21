<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Facades\DB;

use App\Models\Reservas_butaca; 

class Reserva extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function getReservas()
    {
        $data = Reserva::select('reservas.*','nombres', 'apellidos', 'dni')
                ->join('socios', 'socios.id', '=', 'reservas.socio_id')
                ->orderBy('fecha_reserva', 'asc')->get();
    
        foreach ($data as $key => $reserva) {

            $reserva->butacas = Reserva::getReservaButacas($reserva->id);

            $data[$key] =  $reserva;
        }
        return $data;
    }

    private static function getReservaButacas($reserva_id)
    {
        return Reservas_butaca::where('reserva_id', $reserva_id)->get();
    }

    public static function estaReservado($butacas, $fecha, $reserva_id = null)
    {
        foreach ($butacas as  $value) {
            if(Reservas_butaca::estaReservado($value["fila"], $value["columna"], $fecha, $reserva_id))
            {
                return true; 
            }
        }

        return false;
    }

    public static function createReservas($reserva_data){

        // creamos una transaction para mantener una transparencia en los datos en caso de errores
        DB::beginTransaction();
        try {

            $reserva = new Reserva();
            $reserva->fecha_reserva = $reserva_data->fecha_reserva;
            $reserva->socio_id = $reserva_data->socio_id;
            $reserva->save();

            if(!$reserva->save())
            {
                DB::rollBack();
                return false;
            }

            foreach ($reserva_data->butacas as $key => $value) 
            {
                if(!Reservas_butaca::createButacas($value, $reserva->id))
                {
                    DB::rollBack();
                    return false; 
                }
            }

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollBack();
            return false;//throw $th;
        }

    }

    public static function actualizarReservar($data, $id)
    {
         // creamos una transaction para mantener una transparencia en los datos en caso de errores
         DB::beginTransaction();
         try {
 
             $reserva =  Reserva::find($id);
             $reserva->fecha_reserva = $data->fecha_reserva;
             $reserva->socio_id = $data->socio_id;
 
             if(!$reserva->save())
             {
                 DB::rollBack();
                 return false;
             }
 
            Reservas_butaca::where('reserva_id', $id)->delete();

             foreach ($data->butacas as $key => $value) 
             {

                if(empty($value->id))
                {
                    Reservas_butaca::createButacas($value, $reserva->id);

                }elseif(!Reservas_butaca::actualizarButacas($value, $value->id))
                {
                    DB::rollBack();
                    return false; 
                }
             }
 
             DB::commit();
             return true;
 
         } catch (\Throwable $th) {
             DB::rollBack();
             return false;//throw $th;
         }
    }

    public static function eliminarReserva($id)
    {
        // creamos una transaction para mantener una transparencia en los datos en caso de errores
        DB::beginTransaction();
        try {
            $reserva = Reserva::find($id)->delete();
            $reserva_butacas =  Reservas_butaca::where('reserva_id', $id)->delete();

            if(!$reserva || !$reserva_butacas)
            {
                DB::rollBack();
                return false;
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public static function estaDiponible($fila, $columna, $fecha)
    {
        return !Reservas_butaca::estaReservado($fila, $columna, $fecha);
    }

}
