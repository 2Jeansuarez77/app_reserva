<?php

namespace App\Http\Controllers;

use App\Http\Requests\SociosPostRequest;

use Illuminate\Http\Request;
use App\Models\Socio; 

use App\Contracts\SocioRepository;


class SociosController extends Controller
{
    //
    public function index(SocioRepository $socioRepository)
    {
        return view('socios/manage');
    }

    // function crear socios
    public function store(SociosPostRequest $request, SocioRepository $socioRepository )
    {
        $socio = $socioRepository->create($request);
        return response()->json(['message' => true],200);
    }

    // function para actualizar informacion socio
    public function actualizarSocio(SociosPostRequest $request, $id,  SocioRepository $socioRepository)
    {
        $socio = $socioRepository->actualizarSocio($request, $id);
        return response()->json(['message' => true], 200);
    }

    // function para obtener todos los socios
    public function getSocios(SocioRepository $socioRepository)
    {
        $data['socios'] = $socioRepository->getSocios();
        return response()->json($data, 200);
    }

    // fuction para eliminar un socio
    public function eliminarSocio($id, SocioRepository $socioRepository)
    {
        $socio = $socioRepository->eliminarSocio($id);
        return response()->json(['message' => true], 200);
    }
}
