<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    public function up()
    {
        // Dropar a tabela fornecedores se existir
        Schema::dropIfExists('fornecedores');

        // Criar a tabela fornecedores
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo'); // CNPJ ou CPF
            $table->string('documento')->unique(); // CNPJ/CPF
            $table->string('contato');
            $table->string('endereco');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Este método será chamado para reverter a migration
        Schema::dropIfExists('fornecedores');
    }
}




?>