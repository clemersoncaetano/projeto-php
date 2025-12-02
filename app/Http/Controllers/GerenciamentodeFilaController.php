<?php

namespace App\Http\Controllers;

use App\Models\GerenciamentoDeFila;
use App\Http\Requests\CriarFilaRequest;
use App\Http\Requests\AtualizarFilaRequest;

class GerenciamentoDeFilaController extends Controller
{
    public function index()
    {
        return GerenciamentoDeFila::all();
    }

    public function store(CriarFilaRequest $request)
    {
        $fila = GerenciamentoDeFila::create($request->validated());

        return response()->json([
            'message' => 'Fila criada com sucesso!',
            'data' => $fila
        ], 201);
    }

    public function show($id)
    {
        return GerenciamentoDeFila::findOrFail($id);
    }

    public function update(AtualizarFilaRequest $request, $id)
    {
        $fila = GerenciamentoDeFila::findOrFail($id);
        $fila->update($request->validated());

        return ['message' => 'Fila atualizada com sucesso!'];
    }

    public function destroy($id)
    {
        $fila = GerenciamentoDeFila::findOrFail($id);
        $fila->delete();

        return ['message' => 'Fila deletada com sucesso!'];
    }
}
