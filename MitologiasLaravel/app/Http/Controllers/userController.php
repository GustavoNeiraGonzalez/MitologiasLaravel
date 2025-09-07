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
    public function show($id){
        $user = User::find($id);
        if(!$user){
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    public function updatePartial(Request $request, $id){
        $VALIDATOR = Validator::make($request->all(),[
            'name' => '|string|max:30',
            'password' => '|string|min:8'
        ]);
        if($VALIDATOR->fails()){
            $data = ([
                'message' => 'error de validacion',
                'errors' => $VALIDATOR->errors(),
                'status'=>422
            ]);
            return response()->json($data,422);
        }
        $user = User::find($id);
        if(!$user){
            $data = ([
                'message' => 'usuario no encontrado',
                'status'=>404
            ]);
            return response()->json($data,404);
        }
        if(!$request->hasAny(['name','password'])){//verifica que se envie al menos un dato para actualizar
            $data = ([
                'message' => 'no se enviaron datos para actualizar',
                'status'=>422
            ]);
            return response()->json($data,422);
        }

        if($request->has('name')){//si se envia el dato se actualiza
            $user->name = $request->name;
        }
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        $user->save();//guarda los cambios

        $data = ([
            'message' => 'Usuario actualizado con éxito',
            'user' => $user,
            'status' => 200
        ]);
        return response()->json($data, 200);
    }

    public function destroy($id){
        $user = User::find($id);
        if(!$user){
            $data = ([
                'message' => 'usuario no encontrado',
                'status'=>404
            ]);
            return response()->json($data,404);
        }
        $name = $user->name;//almacena el nombre del usuario antes de eliminarlo
        $user->delete();
        $data = ([
            'message' => 'Usuario eliminado con éxito',
            'user' => $name,
            'status' => 200
        ]);
        return response()->json($data, 200);
    }
}
