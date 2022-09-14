<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio; 
use App\Models\Reserva; 

use App\Contracts\ReservaRepository;

class ReservasController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getReservas(ReservaRepository $reservaRepository)
    {
        $data['reservas'] = $reservaRepository->getReservas();
        
        return response()->json($data, 200);
        
    }

    // function crear reservas
    public function store(Request $request, ReservaRepository $reservaRepository)
    {
        $butacas = request('butacas');
        $fecha_reserva = request('fecha_reserva');

        if(empty($butacas)){
            return response()->json(['message' => 'Agregue una fila y columna, para reservar', 'error' => true],200);
        }
        if($reservaRepository->estaReservado($butacas, $fecha_reserva))
        {
            return response()->json(['message' => 'Ya existe una reserva en las fechas y butacas asignadas', 'error' => true],200);
        }
        elseif(!$reservaRepository->create($request))
        {
            return response()->json(['message' => 'No fue posible completar la operacion', 'error' => true],200);
        }

        return response()->json(['message' => 'Reserva exitosa', 'error' => false],200);
    }

    // function para actualizar informacion socio
    public function actualizarReserva(Request $request, $id,  ReservaRepository $reservaRepository)
    {
        $butacas = request('butacas');
        $fecha_reserva = request('fecha_reserva');

        if($reservaRepository->estaReservado($butacas, $fecha_reserva, $id))
        {
            return response()->json(['message' => 'Ya existe una reserva en las fechas y butacas asignadas', 'error' => true],200);
        }

        $reserva = $reservaRepository->actualizarReservar($request, $id);

        if(!$reserva)
        {
            return response()->json(['message' => 'No fue posible actualizar la reserva', 'error' => true],200);
        }

        return response()->json(['message' => 'Reserva actualizada exitosamente', 'error' => false],200);

    }

    // fuction para eliminar un socio
    public function eliminarReserva($id, ReservaRepository $reservaRepository)
    {
        $reserva = $reservaRepository->eliminarReserva($id);
        if(!$reserva)
        {
            return response()->json(['message' => 'No fue posible eliminar la reserva', 'error' => true],200);
        }

        return response()->json(['message' => 'Reserva eliminada exitosamente', 'error' => false],200);


    }

    public function estaDisponible($fila, $columna, ReservaRepository $reservaRepository)
    {

        $fecha = request('fecha');

        if($reservaRepository->estaDiponible($fila, $columna, $fecha)){
            
            return response()->json(['message' => '', 'error' => false],200);
        }

        return response()->json(['message' => 'Butaca ingresada no esta disponible para esa fecha', 'error' => true],200);


    }

}
