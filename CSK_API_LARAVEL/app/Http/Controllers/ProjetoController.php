<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        return Projeto::where('user_id', $userId)->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'area_atuacao' => 'nullable|string|max:255',
            'favorito' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();

        $projeto = Projeto::create($validated);

        return response()->json($projeto, 201);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'area_atuacao' => 'nullable|string|max:255',
            'favorito' => 'boolean',
        ]);

        $userId = auth()->id();

        $projeto = Projeto::findOrFail($userId);
        $projeto->update($validated);

        return response()->json($projeto, 200);
    }

    public function destroy($id)
    {
        Projeto::destroy($id);

        return response()->json(null, 204);
    }
}
