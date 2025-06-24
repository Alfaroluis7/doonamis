<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Repository\UsuarioRepository;

class UsuariosController extends Controller
{
    protected $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function index(Request $request)
    {
        return $this->usuarioRepository->index($request);
    }

    public function store(Request $request)
    {   
        $data = $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        return $this->usuarioRepository->store($data);
    }

    public function update(Request $request, $id)
    {   

        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        return $this->usuarioRepository->update($usuario, $data);
    }

    public function destroy($id)
    {
        return $this->usuarioRepository->destroy($id);
    }

    public function importCsv(Request $request)
    {
        return $this->usuarioRepository->importCsv($request);
    }
}
