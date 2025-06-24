<?php

namespace App\Repository;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioRepository
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 10);

        $usuarios = Usuario::paginate($perPage);

        return response()->json($usuarios);
    }
    public function store($data)
    {
        $usuario = Usuario::create($data);

        return response()->json($usuario, 201);
    }


    public function update(Usuario $usuario, array $data)
    {
        $usuario->update($data);

        return response()->json($usuario);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado (soft delete)']);
    }

    function verificaExistencia($email) : ?Usuario
    {
        return Usuario::withTrashed()->where('email', $email)->first();        
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        $header = fgetcsv($handle);
        $created = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $usuarioData = array_combine($header, $data);

            $usuario = $this->verificaExistencia($usuarioData['email'] ?? '');
            error_log(print_r($usuario, true));
            if (!$usuario) {
                $this->store([
                    'nombre' => $usuarioData['nombre'] ?? '',
                    'apellidos' => $usuarioData['apellidos'] ?? '',
                    'email' => $usuarioData['email'] ?? '',
                    'telefono' => $usuarioData['telefono'] ?? '',
                    'direccion' => $usuarioData['direccion'] ?? '',
                ]);
                $created++;
            }else{

                if ($usuario->trashed()) {
                    $usuario->restore();                    
                    $created++;
                }

                $this->update($usuario, [
                    'nombre' => $usuarioData['nombre'] ?? '',
                    'apellidos' => $usuarioData['apellidos'] ?? '',
                    'telefono' => $usuarioData['telefono'] ?? '',
                    'direccion' => $usuarioData['direccion'] ?? '',
                ]);
            }
        }

        fclose($handle);

        return response()->json(['message' => "$created usuarios importados correctamente"]);
    }
}
