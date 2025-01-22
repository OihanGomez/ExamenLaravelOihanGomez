<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Events;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'apellido' =>'required|string',
                'dni'=>'required|string',
                'fecha_nacimiento'=>'required|string',
                'role' => 'required|string'
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'apellido' => $validatedData['apellido'],
                'dni' => $validatedData['dni'],
                'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                'role' => $validatedData['role'],
            ]);
 
 
            return response()->json(['message' => 'Usuario registrado correctamente'], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en el registro'], 500);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
 
 
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
 
 
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
 
 
        return response()->json(['message' => 'Inicio de sesión exitoso', 'token' => $token], 200);
    }
 
 
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    public function index(Request $request){

        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $dentistas = User::where('role', 'dentista')->get();
        return response()->json($dentistas);
    }

    public function mostrarAsistentes($id){
        $event = Events::find($id);
        return response()->json($event->User);
    }

    public function mostrarDentistas($id){
        $user = User::find($id);
        return response()->json($user->Events); 
    }


    public function apuntarse(Request $request, $id){
        $event = Events::find($id);
        $user = $request->user();
        
        $event->user()->attach($user->id);

        
    }

}
