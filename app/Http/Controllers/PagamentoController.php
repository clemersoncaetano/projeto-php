<?php
namespace App\Http\Controllers;




use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\GerenciamentoDeCompra;
use App\Models\GerenciamentoDeFila;
use Illuminate\Support\Str;
use DB;

class PagamentoController extends Controller
{
    /**
     * Criar pagamento (PIX)
     */
    public function criar(Request $request)
    {
        $request->validate([
            'compra_id' => 'required|exists:gerenciamento_de_compras,id',
        ]);

        $compra = GerenciamentoDeCompra::findOrFail($request->compra_id);

        $pagamento = Pagamento::create([
            'user_id' => auth()->id(),
            'compra_id' => $compra->id,
            'valor' => $compra->preco * $compra->quantidade,
            'metodo' => 'pix',
            'status' => 'pendente',
            'codigo_pix' => 'PIX-' . Str::uuid(),
        ]);

        return response()->json([
            'message' => 'Pagamento PIX criado',
            'pagamento' => $pagamento
        ], 201);
    }

    /**
     * Confirmar pagamento (simulando webhook)
     */
    public function confirmar($id)
    {
        return DB::transaction(function () use ($id) {

            $pagamento = Pagamento::findOrFail($id);

            if ($pagamento->status === 'pago') {
                return response()->json(['message' => 'Pagamento já confirmado'], 400);
            }

            // 1. Confirma pagamento
            $pagamento->update(['status' => 'pago']);

            // 2. Remove usuário da fila (se estiver)
            GerenciamentoDeFila::where('user_id', $pagamento->user_id)->delete();

            // 3. Coloca usuário no final da fila
            GerenciamentoDeFila::create([
                'user_id' => $pagamento->user_id,
                'ativo' => true
            ]);

            return response()->json([
                'message' => 'Pagamento confirmado e usuário movido para o fim da fila'
            ]);
        });
    }
}
