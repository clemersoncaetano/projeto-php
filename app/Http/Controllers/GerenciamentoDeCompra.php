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
            'user_id' => 'required|integer',
            'purchase_time' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $compra = new GerenciamentoDeCompra();
        $compra->user_id = $request->input('user_id');
        $compra->purchase_time = $request->input('purchase_time');
        $compra->amount = $request->input('amount');
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
            'purchase_time' => ['sometimes', 'required', 'date'],
            'amount' => ['sometimes', 'required', 'numeric'],
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
        return DB::transaction(function () {
            $primeiro = gerenciamentodefilacontrollerController::orderBy('id')->first();

            if (!$primeiro) {
                return response()->json(['message' => 'Fila vazia!'], 400);
            }

            $compra = GerenciamentoDeCompra::create([
                'user_id' => $primeiro->user_id,
                'amount' => $primeiro->amount,
                'purchase_time' => now(),
            ]);

            $primeiro->delete();

            gerenciamentodefilacontrollerController::create([
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
