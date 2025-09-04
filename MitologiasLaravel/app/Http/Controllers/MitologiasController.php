<?php

namespace App\Http\Controllers;

use App\Models\Mitologias;
use App\Http\Requests\StoreMitologiasRequest;
use App\Http\Requests\UpdateMitologiasRequest;

class MitologiasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Mitologias::all();//aqui se recupera todos los datos de mitologias y se almacena en data

        if ($data->isEmpty()){//aqui se verifica y muestra mensaje error si esta vacia los datos de mitologias
            $data = [
                'message' =>'No se encontraron mitologías' ,
                'status' =>404
            ];
            return response()->json($data, 404);
        }
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
    public function store(StoreMitologiasRequest $request)
    {
        //
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
