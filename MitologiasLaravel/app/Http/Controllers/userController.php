<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

    //----------------------------------show mitologias guardadas por usuario-----------------------------------
    public function showAttached($id){
        $user = User::find($id);
        if(!$user){
            $data = ([
                'message' => 'usuario no encontrado',
                'status'=>404
            ]);
            return response()->json($data,404);
        }
        $mitologias = $user->mitologiasGuardadas()->select('mitologias.id', 'mitologias.titulo')->get();
        if($mitologias->isEmpty()){
            $data = ([
                'message' => 'El usuario no tiene mitologias guardadas',
                'status'=>404
            ]);
            return response()->json($data,404);
        }
        $data = ([
            'user' => $user->name,
            'user_id' => $user->id,
            'mitologias guardadas' => $mitologias->pluck('titulo'),
            'status' => 200
        ]);
        return response()->json($data, 200);
    }
    //-----------------------------------autenticacion-----------------------------------
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8'
        ]);
        if($validator->fails()) {
            $data = ([
                'message' => 'error de validacion',
                'errors' => $validator->errors(),
                'status'=>422
            ]);
            return response()->json($data,422);
        }
        $user = User::where('email', $request->email)->first();//busca el usuario por email

        if (!$user || !Hash::check($request->password, $user->password)) {//verifica si el usuario existe y si la contraseña es correcta

            $data = ([//si las credenciales son incorrectas
                'message' => 'Credenciales incorrectas',
                'status'=>401
            ]);
            return response()->json($data,401);
        }else{//si las credenciales son correctas
            $token = $user->createToken('auth_token')->plainTextToken;//crea un token de autenticacion

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 200
            ], 200);
        }
    }

    public function logout(Request $request){
        if (! $request->user()) {
            $data = ([
                'message' => 'No autenticado',
                'status' => 401
            ]);
            return response()->json($data, 401);
        }
        $request->user()->currentAccessToken()->delete();//elimina el token de autenticacion actual
        $data = ([
            'message' => 'Cierre de sesión exitoso',
            'status' => 200
        ]);
        return response()->json($data, 200);
    }
}
