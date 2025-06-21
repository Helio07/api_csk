<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    public function index()
    {
        $stakeholders = Stakeholder::all();
        return response()->json($stakeholders, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'classificacao' => 'nullable|string|max:255',
            'projeto_id' => 'required|exists:projetos,id',
        ]);

        $stakeholder = Stakeholder::create($validated);

        return response()->json($stakeholder, 201);
    }

    public function show($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        return response()->json($stakeholder, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'classificacao' => 'nullable|string|max:255',
            'projeto_id' => 'sometimes|required|exists:projetos,id',
        ]);

        $stakeholder = Stakeholder::findOrFail($id);
        $stakeholder->update($validated);

        return response()->json($stakeholder, 200);
    }

    public function destroy($id)
    {
        Stakeholder::destroy($id);
        return response()->json(null, 204);
    }
}
