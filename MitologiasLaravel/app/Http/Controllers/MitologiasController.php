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
        //
        $mitologias = Mitologias::all();//aqui se recupera todos los datos de mitologias y se almacena en data

        if ($mitologias->isEmpty()){//aqui se verifica y muestra mensaje error si esta vacia los datos de mitologias
            $data = [
                'message' =>'No se encontraron mitologías' ,
                'status' =>404
            ];
            return response()->json($data, 404);
        }
        $data = [
                'Mitologias' =>$mitologias ,
                'status' =>200
            ];
        return response()->json($data, 200);
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
                'titulo' => $request->titulo
            ]);

            $data = [//mensaje de exito
                'message' => 'Mitología creada exitosamente',
                'Mitologia' => $mitologias,
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
        $mitologia = Mitologias::find($id);//busca mitologia por id
        if (!$mitologia) {//verifica si existe la mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [//muestra mitologia encontrada
            'Mitologia' => $mitologia,
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
            if (!$request->hasAny(['Historia', 'titulo'])) {// Verifica si al menos uno de los campos está presente en la solicitud
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
    public function attachUser($IdMitologia, $IdUsuario)
    {
        // Encuentra la mitología y el usuario por sus IDs
        $mitologia = Mitologias::find($IdMitologia);
        $usuario = User::find($IdUsuario);

        if(!$mitologia){//verifica si existe mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        if(!$usuario){//verifica si existe usuario
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // Asocia al usuario con la mitología:
        //usuariosQueGuardaron es el nombre de la funcion en el MODELO Mitologias para
        //  la relacion muchos a muchos, por eso viene de $mitologia
        $mitologia->usuariosQueGuardaron()->syncWithoutDetaching([$usuario->id]);// Evita duplicados
        return response()->json([
            'message' => "Usuario {$usuario->id} asociado a la mitología {$mitologia->id}"
        ]);
    }

     public function detachUser($IdMitologia, $IdUsuario)
    {
        // Encuentra la mitología y el usuario por sus IDs
        $mitologia = Mitologias::find($IdMitologia);
        $usuario = User::find($IdUsuario);

        if(!$mitologia){//verifica si existe mitologia
            $data = [
                'message' => 'Mitología no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        if(!$usuario){//verifica si existe usuario
            $data = [
                'message' => 'Usuario no encontrado',
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
}
