<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\GerenciamentoDeFila;
use App\Http\Requests\CriarFilaRequest;
use App\Http\Requests\AtualizarFilaRequest;

class GerenciamentoDeFilaController extends Controller
{
public function adicionarpedido(CriarFilaRequest $request)
    {
       $Order = Order::create([
        'Cliente' => $request->Cliente,
        'bebida' => $request->bebida,
        'status' => 'pendente',
       ]);
         return response()->json(['msg' => 'Pedido adicionado com sucesso!', 'pedido' => $Order]);
    
    }


   public function listarFila()
    {
        $fila = Order::where('status', 'pendente')->orderby ('id')->get();
        return response()->json($fila);
    }


    public function processarPróximo(){
        $pedido = Order::where('status', 'pendente')->orderby('id')->first();
        if ($pedido) {
            $pedido->status = 'processando';
            $pedido->save();
            return response()->json(['msg' => 'Pedido em processamento', 'pedido' => $pedido]);
        } else {
            return response()->json(['msg' => 'Nenhum pedido pendente na fila.']);
        }
    }
    public function index()
    {
        return response()->json(['msg' => 'Gerenciamento de Fila ativo']);
    }
}