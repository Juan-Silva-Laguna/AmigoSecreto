<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class UsuarioController extends Controller
{

    public function mostrarRegistro()
    {
        return view('usuarios.registro');
    }

    public function mostrarIngreso()
    {
        return view('usuarios.ingreso');
    }

    public function store(Request $request)
    {
        try {
            $usuario = Usuario::create($request->all());
            return response()->json(['message' => 'Registro exitoso', 'icon' => 'success', 'usuario' => $usuario], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['message' => 'Error al registrar usuario', 'icon' => 'error'], 500);
        }
    }

    public function login(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'indicativo' => 'required|numeric',
            'whatsapp' => 'required|numeric',
            'codigo' => 'required|numeric',
        ]);

        // Obtener los datos del formulario
        $indicativo = $request->indicativo;
        $whatsapp = $request->whatsapp;
        $codigo = $request->codigo;

        // Buscar al usuario en la base de datos
        $usuario = Usuario::where('indicativo', $indicativo)
                          ->where('whatsapp', $whatsapp)
                          ->first();

        // Verificar si el usuario existe y el código es correcto
        if ($usuario) {

            if ($usuario->codigo == $codigo) {
                // Si las validaciones son exitosas, crea una sesión
                Session::put('usuario', ['id' => $usuario->id, 'nombre' => $usuario->nombre, 'indicativo' => $indicativo, 'whatsapp' => $whatsapp]);
                $previousUrl = URL::previous();
                // Puedes personalizar el nombre y la ruta de la sesión según tus necesidades
                return response()->json(['url' => $previousUrl, 'message' => 'Hola, '.$usuario->nombre, 'icon' => 'success', 'usuario' => $usuario], 200);
            } else {
                // Si las validaciones fallan, redirige de nuevo al formulario con un mensaje de error
                return response()->json(['message' => 'Código incorrecto', 'icon' => 'error'], 422);
            }
        }else{
            return response()->json(['message' => 'WhatsApp incorrecto', 'icon' => 'error'], 422);
        }
    }
    public function salir(){
        Session::forget('usuario');
        return redirect('/ingreso');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        $usuario->update($request->all());
        return redirect()->route('usuarios.show', $usuario->id);
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        return redirect()->route('usuarios.index');
    }
}
