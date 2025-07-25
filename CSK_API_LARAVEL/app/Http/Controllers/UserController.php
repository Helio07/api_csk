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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'telefone' => 'required|string|max:15',
            ]);

            if (User::where('email', $validated['email'])->exists()) {
                return response()->json(['error' => 'O e-mail já está cadastrado.'], 400);
            }

            $data = $validated;
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            Auth::login($user);

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
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
    public function show()
    {
        try {
            $user = Auth::user();
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'telefone' => $user->telefone,
            ], 200);
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
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'telefone' => 'sometimes|required|string|max:15',

        ]);

        try {
            $user->update($validated);
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
                    'telefone' => $user->telefone,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao realizar login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function trocarSenha(Request $request)
    {
        $request->validate([
            'senha_atual' => 'required|string',
            'nova_senha' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/',
                'confirmed'
            ],
        ]);

        $user = Auth::user();
        if (!Hash::check($request->senha_atual, $user->password)) {
            return response()->json([
                'message' => 'Senha atual incorreta.'
            ], 403);
        }

        $user->password = Hash::make($request->nova_senha);
        $user->save();

        return response()->json([
            'message' => 'Senha alterada com sucesso.'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }

}
