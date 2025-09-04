<?php

namespace App\Http\Controllers;

use App\Models\Mitologias;
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
    public function show(Mitologias $mitologias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mitologias $mitologias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMitologiasRequest $request, Mitologias $mitologias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitologias $mitologias)
    {
        //
    }
}
