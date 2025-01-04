<?php

namespace App\Http\Controllers;
use App\Models\Sala;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
class JuegoController extends Controller
{
    public function index()
    {
        $salas = Sala::withCount('grupos')
        ->join('usuarios', 'usuarios.id', '=', 'salas.id_creador')
        ->join('grupos', 'salas.id', '=', 'grupos.id_sala')
        ->select('salas.*', 'usuarios.nombre as nombre_creador', 'usuarios.id as id_usuario')
        ->where('grupos.id_usuario', session('usuario')['id'])
        ->get();

        return view('home.index', compact('salas'));
    }

    public function verGrupo($codigo)
    {
        if (Session::has('usuario')) {
            $sala = Sala::withCount('grupos')
            ->join('usuarios', 'usuarios.id', '=', 'salas.id_creador')
            ->join('grupos', 'salas.id', '=', 'grupos.id_sala')
            ->select('salas.*', 'usuarios.nombre as nombre_creador', 'usuarios.id as id_usuario')
            ->where('salas.codigo', $codigo)
            ->first();

            $grupos = Sala::join('grupos', 'salas.id', '=', 'grupos.id_sala')
            ->join('usuarios', 'usuarios.id', '=', 'grupos.id_usuario')
            ->select('usuarios.*', 'grupos.id_usuario', 'grupos.id_sala' , 'grupos.id_usuario_corresponde')
            ->where('salas.codigo', $codigo)
            ->get();

            return view('home.equipo', compact('sala', 'grupos'));
        }else{
            return view('usuarios.ingreso');
        }
    }

    public function verOculto($codigo)
    {
        if (Session::has('usuario')) {
            $usuarioOculto = Sala::join('grupos', 'salas.id', '=', 'grupos.id_sala')
            ->join('usuarios', 'usuarios.id', '=', 'grupos.id_usuario_corresponde')
            ->select('usuarios.*')
            ->where('salas.codigo', $codigo)
            ->where('grupos.id_usuario', session('usuario')['id'])
            ->first();

            return view('home.ver', compact('usuarioOculto'));
        }else{
            return view('usuarios.ingreso');
        }
    }

    public function unirme($id)
    {
        $grupo = new Grupo();
        $grupo->id_sala = $id;
        $grupo->id_usuario = session('usuario')['id'];
        $grupo->save();

        return response()->json(['message' => 'Vinculacion exitosa', 'icon' => 'success'], 200);
    }


    public function sorteo($id, Request $request)
    {
        // Obtén la instancia de la sala por su ID
        $grupo = new Grupo();
        $sorteoData = $request->all()['sorteo'];

        $count = count($sorteoData);
        for ($i = 0; $i < $count; $i++) {
            $asignacion = $sorteoData[$i];

            // Asegúrate de que el usuario exista en la grupo antes de actualizar
            if ($grupo->where('id_sala', $id)->where('id_usuario', $asignacion[0])->exists()) {
                // Actualiza el campo 'id_usuario_corresponde'
                // Ajusta esto según la estructura real de tu modelo Usuario y el nombre del campo
                $grupo->where('id_sala', $id)->where('id_usuario', $asignacion[0])->update(['id_usuario_corresponde' => $asignacion[1]]);
            }
        }


        return response()->json(['message' => 'Sorteo Exitoso', 'icon' => 'success'], 200);
    }

    public function store(Request $request)
    {
        try {
            $sala = Sala::create($request->all());
            $usuario = Grupo::create(['id_sala' => $sala['id'], 'id_usuario' => session('usuario')['id'] ]);
            return response()->json(['message' => 'Registro exitoso', 'icon' => 'success'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['message' => 'Error al crear sala', 'icon' => 'error'], 500);
        }
    }
}
