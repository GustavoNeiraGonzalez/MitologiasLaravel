<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index()
    {
        //
        $users = User::all();//aqui se recupera todos los datos de usuarios y se almacena en data
        if ($users->isEmpty()){//aqui se verifica y muestra mensaje error si esta vacia los datos de usuarios
            $data = [
                'message' =>'No se encontraron usuarios' ,
                'status' =>404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Users' =>$users,
            'status' =>200
        ];
        return response()->json($data, 200);
    }
    //
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'error de validacion',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);
        }


        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $data = [
                'message' => 'Usuario creado con exito',
                'user' => $user,
                'status' => 201
            ];
            return response()->json($data, 201);

        } catch (\Exception $e) {
            //throw $e;
            $data = [
                'message' => 'Error al crear usuario',
                'error' => $e->getMessage(),
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    }
}
