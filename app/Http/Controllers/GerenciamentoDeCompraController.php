<?php

namespace App\Http\Controllers;

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
        return DB::transaction(function ()use($request){
            $primeiro = GerenciamentoDeFila::orderBy('id')->first();

            if (!$primeiro) {
                return response()->json(['message' => 'Fila vazia!'], 400);
            }

            $compra = GerenciamentoDeCompra::create([
                'user_id' => $primeiro->user_id,
                 'produto' => $request->produto,
                 'quantidade' => $request->quantidade,
                 'preco' => $request->preco,
            ]);

            $primeiro->delete();

            GerenciamentoDeFila::create([
                'user_id' => $compra->user_id,
                'ativo' => true,
            ]);

            return response()->json([
                'message' => 'Compra registrada e fila atualizada!',
                'compra' => $compra,
            ], 201);
        });
    }
}
