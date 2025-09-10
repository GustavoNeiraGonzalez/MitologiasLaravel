<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Civilizacion;
use App\Http\Requests\StoreCivilizacionRequest;
use App\Http\Requests\UpdateCivilizacionRequest;
use Illuminate\Support\Facades\Validator;

class CivilizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $civilizaciones = Civilizacion::with('Mitologias')->get();//aqui se recupera todos los datos de civilizaciones y se almacena en data
        if ($civilizaciones->isEmpty()){//aqui se verifica y muestra mensaje error si esta vacia los datos de civilizaciones
            $data = [
                'message' =>'No se encontraron civilizaciones' ,
                'status' =>404
            ];
            return response()->json($data, 404);
        }

       $result = $civilizaciones->map(function ($civilizacion) {
            return [
                'id' => $civilizacion->id,
                'civilizacion' => $civilizacion->civilizacion,
                'Mitologias' => $civilizacion->Mitologias->map(function ($mitologia) {//map recorre cada mitologia y
                // devuelve un nuevo array con los titulos asociados a la civilizacion
                    return [
                        'titulo' => $mitologia->titulo,
                    ];
                })
            ];
        });
        return response()->json($result, 200);
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
        //
        $validator = Validator::make($request->all(),[
            'civilizacion' => 'required|string|max:50|unique:civilizaciones'
            ]);
        if ($validator->fails()) {
                $data = [
                    'message' => 'Error de validación',
                    'errors' => $validator->errors(),
                    'status' => 422
                ];
            return response()->json($data, 422);
        }
        // Crear una nueva civilización
        $civilizacion = Civilizacion::create([
            'civilizacion' => $request->civilizacion
        ]);
        return response()->json($civilizacion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $civilizacion = Civilizacion::with('Mitologias')->find($id);//busca civilizacion por id y con sus mitologias
        if (!$civilizacion) {//si no existe muestra mensaje error
            $data = [
                'message' => 'Civilización no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Civilizacion' => $civilizacion->civilizacion,
            'Mitologias' => $civilizacion->Mitologias->map(function($mitologia){
                return [
                    'titulo' => $mitologia->titulo
                ];
            }),
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Civilizacion $civilizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $civilizaciones = Civilizacion::find($id);//busca civilizacion por id

        if (!$civilizaciones) {//si no existe muestra mensaje error
            return response()->json(['message' => 'Civilización no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [//valida que el campo civilizacion
            'civilizacion' => 'required|string|max:50|unique:civilizaciones'
        ]);
        if ($validator->fails()){
                $data = [
                    'message' => 'Error de validación',
                    'errors' => $validator->errors(),
                    'status' => 422
                ];
            return response()->json($data, 422);
        }
        $civilizaciones->civilizacion = $request->civilizacion;//actualiza civilizacion
        $civilizaciones->save();
        $data = [
            'message' => 'Civilización actualizada con éxito',
            'civilizacion' => $civilizaciones->civilizacion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $civilizacion = Civilizacion::find($id);
        if (!$civilizacion) {
            return response()->json(['message' => 'Civilización no encontrada'], 404);
        }
        $titulo = $civilizacion->civilizacion;
        $civilizacion->delete();
        $data = [
            'message' => "Civilización eliminada con éxito",
            'civilizacion' => $titulo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
