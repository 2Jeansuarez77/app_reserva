<?php
namespace App\Contracts;
use App\Models\Socio; 

class SocioRepository
{

    public function create($socio_data)
    {
        return Socio::create($socio_data);
    }

    public function getSocios()
    {
        return Socio::getSocios();
    }

    public function eliminarSocio($id)
    {
        return Socio::eliminarSocio($id);
    }

    public function actualizarSocio($socio_data, $id)
    {
        return Socio::actualizarSocio($socio_data, $id);
    }
}
?> 