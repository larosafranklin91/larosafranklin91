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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->engine = 'InnoDB';  //garantir o uso do InnoDB
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('nome'); // Nome da pessoa ou nome da empresa
            $table->string('documento', 15)->unique(); // CNPJ ou CPF
            $table->string('telefone');
            $table->string('email');
            $table->string('endereco')->nullable();
            $table->boolean('ativo')->default(true); // Default true
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
