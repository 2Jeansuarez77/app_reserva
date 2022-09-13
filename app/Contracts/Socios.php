<?php
namespace App\Contracts;
use App\Models\Socio; 

interface InterfaceSocio
{

    public function save($socio) : Socio;
}
?> 