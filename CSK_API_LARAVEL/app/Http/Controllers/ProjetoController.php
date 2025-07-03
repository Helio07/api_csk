<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $projetos = Projeto::where('user_id', $userId)->get();

        $projetos->transform(function ($projeto) {
            unset($projeto->user_id);
            return $projeto;
        });

        return $projetos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'area_atuacao' => 'nullable|string|max:255',
            'favorito' => 'boolean',
            'descricao' => 'nullable|string|max:1500',
            'data_inicio' => 'nullable|date',
            'data_final' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        Projeto::create($validated);

        return response()->json(['message' => 'Projeto criado com sucesso'], 201);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'area_atuacao' => 'nullable|string|max:255',
            'favorito' => 'boolean',
        ]);

        $userId = auth()->id();

        $projeto = Projeto::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $projeto->update($validated);

        return response()->json(['message' => 'Projeto atualizado com sucesso'], 200);
    }

    public function destroy($id)
    {
        Projeto::destroy($id);

        return response()->json(null, 204);
    }
}
