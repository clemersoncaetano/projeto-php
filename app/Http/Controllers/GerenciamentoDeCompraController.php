<?php

namespace App\Http\Controllers;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\GerenciamentoDeCompra;
use App\Models\GerenciamentoDeFila;

class GerenciamentoDeCompraController extends Controller
{
                 
    public function criarCompra(Request $request)
    {
       $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'produto' => 'required|string',
        'quantidade' => 'required|integer|min:1',
        'preco' => 'required|numeric|min:0',
    ]);
          $compra = GerenciamentoDeCompra::create([
        'user_id' => $request->user_id,
        'produto' => $request->produto,
        'quantidade' => $request->quantidade,
        'preco' => $request->preco,
    ]);
    $compra->save();

        return response()->json(['message' => 'Compra criada com sucesso!'], 201);
    }

   
    public function listarCompra()
    {
        return GerenciamentoDeCompra::all();
    }


    public function mostrarCompra($id)
    {
        return GerenciamentoDeCompra::findOrFail($id);
    }

   
    public function atualizarCompra(Request $request, $id)
    {
        $compra = GerenciamentoDeCompra::findOrFail($id);

        $validado = $request->validate([
         'user_id' => 'required|integer|exists:users,id',
        'produto' => 'required|string',
        'quantidade' => 'required|integer|min:1',
        'preco' => 'required|numeric|min:0',
        ]);

        $compra->update($validado);

        return response()->json(['message' => 'Compra atualizada com sucesso!']);
    }

 
    public function deletarCompra($id)
    {
        $compra = GerenciamentoDeCompra::findOrFail($id);
        $compra->delete();

        return response()->json(['message' => 'Compra deletada com sucesso!']);
    }

public function registrarCompra(Request $request)
{
    $request->validate([
        'produto' => 'required|string',
        'quantidade' => 'required|integer|min:1',
        'preco' => 'required|numeric|min:0',
    ]);

    return DB::transaction(function () use ($request) {

        // 1️⃣ Pega o primeiro da fila
        $primeiro = GerenciamentoDeFila::orderBy('position')->first();

        if (!$primeiro) {
            return response()->json([
                'message' => 'Fila vazia!'
            ], 400);
        }

        // 2️⃣ Registra a compra
        $compra = GerenciamentoDeCompra::create([
            'user_id' => $primeiro->user_id,
            'produto' => $request->produto,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
        ]);

        // 3️⃣ Remove o usuário da posição atual
        $primeiro->delete();

        // 4️⃣ Descobre a última posição da fila
        $ultimaPosicao = GerenciamentoDeFila::max('position') ?? 0;

        // 5️⃣ Reinsere o usuário no FINAL da fila
        GerenciamentoDeFila::create([
            'user_id' => $compra->user_id,
            'position' => $ultimaPosicao + 1,
            'ativo' => true,
        ]);

        return response()->json([
            'message' => 'Compra registrada e usuário movido para o fim da fila!',
            'compra' => $compra
        ], 201);
    });
}
}
