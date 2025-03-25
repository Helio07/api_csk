<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ]
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return response()->json(['error' => 'O e-mail já está cadastrado.'], 400);
        }

        try {
            $data = $validated;
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            Auth::login($user);

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar usuário.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Usuário não encontrado.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'password' => [
                'sometimes',
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ]
        ]);

        try {
            if(isset($validated['password'])){
                $validated['password'] = Hash::make($validated['password']);
            }
            User::findOrFail($id)->update($validated);
            return response()->json([
                'message' => 'Usuário atualizado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        try {
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas.'], 401);
            }
    
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'token' => $token,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao realizar login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
