<?php
namespace App\Contracts;
use App\Models\Reserva; 

class ReservaRepository
{

    public function create($reserva_data)
    {
        return Reserva::createReservas($reserva_data);
    }

    public function getReservas()
    {
        return Reserva::getReservas();
    }

    public function eliminarReserva($id)
    {
        return Reserva::eliminarReserva($id);
    }

    public function actualizarReservar($reserva_data, $id)
    {
        return Reserva::actualizarReservar($reserva_data, $id);
    }

    public function estaReservado($butacas, $fecha, $id = null)
    {
        return Reserva::estaReservado($butacas, $fecha, $id);
    }

    public function estaDiponible($fila, $columna, $fecha){
        return Reserva::estaDiponible($fila, $columna, $fecha);
    }
}
?> 