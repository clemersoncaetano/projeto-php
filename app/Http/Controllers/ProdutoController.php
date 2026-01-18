<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(Produto::all());
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'estoque' => 'required|integer'
        ]);

        $produto = Produto::create($dados);

        return response()->json($produto, 201);
    }

    public function show($id)
    {
        return response()->json(Produto::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $produto->update($request->all());

        return response()->json($produto);
    }

    public function destroy($id)
    {
        Produto::destroy($id);

        return response()->json(['message' => 'Produto removido']);
    }
}
