<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('pagamentos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('compra_id')->constrained('gerenciamento_de_compras')->cascadeOnDelete();
    $table->decimal('valor', 10, 2);
    $table->string('metodo')->default('pix');
    $table->string('status')->default('pendente'); // pendente | pago | cancelado
    $table->string('codigo_pix')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
