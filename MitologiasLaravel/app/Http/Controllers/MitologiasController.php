<?php

namespace App\Http\Controllers;

use App\Models\Mitologias;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMitologiasRequest;
use App\Http\Requests\UpdateMitologiasRequest;
use Illuminate\Support\Facades\Validator;

class MitologiasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Trae todas las mitologías con su civilización relacionada
        $mitologias = Mitologias::with('civilizacion')->get();
        //with carga la relacion de la tabla civilizaciones definida en el modelo Mitologias

        if ($mitologias->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron mitologías',
                'status' => 404
            ], 404);
        }

        // Transformar los datos para devolver solo lo que queremos
        $result = $mitologias->map(function ($mitologia) {
            return [
                'id' => $mitologia->id,
                'titulo' => $mitologia->titulo,
                'Historia' => $mitologia->Historia,
                'civilizacion' => $mitologia->civilizacion->civilizacion// operador ternario (? si valor true : no valor false)para
                //  evitar error si no hay civilizacion
            ];
        });

        return response()->json([
            'Mitologias' => $result,
            'status' => 200
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [// Se crean las reglas de validación
            'Historia' => 'required|string|max:4000',
            'titulo' => 'required|string|max:25',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            // Imagen opcional, tipos permitidos y tamaño máximo 5MB
            'civilizacion_id' => 'required|integer|exists:civilizaciones,id'
            // Asegura que la civilización exista en la tabla civilizaciones
            //usando exists:civilizaciones,id (nombre de la tabla y columna)
        ]);
        if ($validator->fails()) {// Verifica si la validación falla
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);
        }

        try {
            $mitologias = Mitologias::create([//crea nuevo registro
                'Historia' => $request->Historia,
                'titulo' => $request->titulo,
                'civilizacion_id' => $request->civilizacion_id
            ]);
              // Si se envió una imagen, la procesamos en este if
            if ($request->hasFile('imagen')) {
                // Si ya tenía una imagen anterior, se elimina
                if ($mitologias->imagen) {
                    Storage::disk('public')->delete($mitologias->imagen);
                }

                // Se guarda la nueva imagen
                $path = $request->file('imagen')->store('mitologias', 'public');
                $mitologias->imagen = $path;
                $mitologias->save();
            }
            $data = [//mensaje de exito
                'message' => 'Mitología creada exitosamente',
                'Mitologia' => $mitologias,
                'imagen_url' => $mitologias->imagen ? asset('storage/' . $mitologias->imagen) : null,
                'status' => 201
            ];
            return response()->json($data, 201);//retorna mensaje de exito

        } catch (\Exception $e) {//captura errores
            $data = [
                'message' => 'Error al crear la mitología',
                'error' => $e->getMessage(),
                'status' => 500
            ];
            return response()->json($data, 500);//retorna mensaje de error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $mitologia = Mitologias::with('civilizacion')->find($id);//busca mitologia por id y trae su civilizacion relacionada
        if (!$mitologia) {//verifica si existe la mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [//muestra mitologia encontrada
            'Mitologia' => $mitologia->titulo,
            'civilizacion' => $mitologia->civilizacion->civilizacion,
            'Historia' => $mitologia->Historia,
            'status' => 200
        ];
        return response()->json($data, 200);//retorna mensaje de exito
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $mitologia = Mitologias::find($id);//busca mitologia por id
        //
        $validator = Validator::make($request->all(), [// Se crean las reglas de validación
            'Historia' => 'required|string|max:4000',
            'titulo' => 'required|string|max:25',
            'civilizacion_id' => 'required|integer|exists:civilizaciones,id' // Asegura que la civilización exista en la tabla civilizaciones
        ]);
        if ($validator->fails()) {// Verifica si la validación falla
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);//retorna mensaje de error
        }
        if (!$mitologia) {//verifica si existe la mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);//retorna mensaje de error
        }
        try {
            $mitologia->Historia = $request->Historia;//actualiza historia
            $mitologia->titulo = $request->titulo;//actualiza titulo
            $mitologia->civilizacion_id = $request->civilizacion_id;//actualiza civilizacion

            $mitologia->save();//actualiza mitologia

            $data = [//mensaje de exito
                'message' => 'Mitología actualizada exitosamente',
                'Mitologia' => $mitologia->titulo,
                'status' => 200
            ];
            return response()->json($data, 200);

        } catch (\Exception $e) {//captura errores
            $data = [
                'message' => 'Error al actualizar la mitología',
                'error' => $e->getMessage(),
                'status' => 500
            ];
            return response()->json($data, 500);//retorna mensaje de error
        }
    }

    public function updatePartial(Request $request,$id)
    {
        $mitologia = Mitologias::find($id);//busca mitologia por id
        //
        $validator = Validator::make($request->all(), [// Se crean las reglas de validación
            'Historia' => '|string|max:4000',
            'titulo' => '|string|max:25',
            'civilizacion_id' => '|integer|exists:civilizaciones,id' // Asegura que la civilización exista en la tabla civilizaciones
        ]);
        if ($validator->fails()) {// Verifica si la validación falla
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);//retorna mensaje de error
        }
        if (!$mitologia) {//verifica si existe la mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);//retorna mensaje de error
        }
        try {
            if (!$request->hasAny(['Historia', 'titulo', 'civilizacion_id'])) {// Verifica si al menos uno de los campos está presente en la solicitud
                $data = [
                    'message' => 'No se proporcionaron datos para actualizar',
                    'status' => 400
                ];
                return response()->json($data, 400);//retorna mensaje de error
            }
            if ($request->has('Historia')) {
                $mitologia->Historia = $request->Historia;//actualiza historia
            }
            if ($request->has('titulo')) {
                $mitologia->titulo = $request->titulo;//actualiza titulo
            }
            if ($request->has('civilizacion_id')) {
                $mitologia->civilizacion_id = $request->civilizacion_id;//actualiza civilizacion
            }
            $mitologia->save();//actualiza mitologia
            $data = [//mensaje de exito
                'message' => 'Mitología actualizada exitosamente',
                'Mitologia' => $mitologia->titulo,
                'status' => 200
            ];
            return response()->json($data, 200);

        } catch (\Exception $e) {//captura errores
            $data = [
                'message' => 'Error al actualizar la mitología',
                'error' => $e->getMessage(),
                'status' => 500
            ];
            return response()->json($data, 500);//retorna mensaje de error
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $mitologia = Mitologias::find($id);//busca mitologia por id
        if (!$mitologia) {//verifica si existe la mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $titulo = $mitologia->titulo; // Guarda el título antes de eliminar la mitología
        $mitologia->delete();//elimina mitologia

        $data = [//mensaje de exito
            'message' => 'Mitología eliminada exitosamente',
            'titulo' => $titulo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    //asociar mitologia a usuario (guardar mitologia)
    public function attachUser(Request $request, $IdMitologia)
    {
        $mitologia = Mitologias::find($IdMitologia);

        if (!$mitologia) {
            return response()->json(['message' => 'Mitología no encontrada'], 404);
        }

        // Asociar al usuario autenticado
        $request->user()->mitologiasGuardadas()->syncWithoutDetaching([$IdMitologia]);

        return response()->json([
            'message' => "La mitología {$mitologia->id} fue asociada al usuario autenticado ({$request->user()->id})"
        ]);
    }

    public function detachUser($IdMitologia)
    {
        // Encuentra la mitología y el usuario por sus IDs
        $mitologia = Mitologias::find($IdMitologia);
        $usuario = auth()->user(); // Obtiene el usuario autenticado

        if(!$mitologia){//verifica si existe mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        if(!$usuario){//verifica si existe usuario
            $data = [
                'message' => 'Se necesita iniciar sesión',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // DESASOCIA al usuario con la mitología:
        //usuariosQueGuardaron es el nombre de la funcion en el MODELO Mitologias para
        //  la relacion muchos a muchos, por eso viene de $mitologia
        $mitologia->usuariosQueGuardaron()->detach([$usuario->id]);
        return response()->json([
            'message' => "Usuario {$usuario->id} desasociado de la mitología {$mitologia->id}"
        ]);
    }

    //
    public function showAttached($IdMitologia)
    {
        // Encuentra la mitología y el usuario por sus IDs
        $mitologia = Mitologias::find($IdMitologia);

        if(!$mitologia){//verifica si existe mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // Obtiene los usuarios asociados a la mitología y los guarda en la variable $usuarios
        $usuarios = $mitologia->usuariosQueGuardaron()->select('users.id', 'users.name')->get();
           return response()->json([
                'mitologia_id' => $mitologia->id,
                'usuarios' => $usuarios->pluck('name'), //pluck extrae solo los nombres de los usuarios y no toda la info
                'status' => 200
            ]);
    }
}
