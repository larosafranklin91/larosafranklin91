<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->comment('Razão Social');
            $table->string('trading_name')->nullable()->comment('Nome Fantasia');
            $table->boolean('active')->default(true)->comment('Indica se a empresa está com a situação cadastral ativa');
            $table->string('registration_number')->unique()->comment('CNPJ');
            $table->string('cnae')->nullable()->comment('Cód. Atividade Econômica');
            $table->string('juridic_kind')->nullable()->comment('Cód. Natureza Juridica');
            $table->boolean('parent_company')->default(false)->comment('Indica se a empresa é matriz ou filial');
            $table->foreignId('parent_id')->nullable()->constrained('suppliers')->onDelete('cascade')->comment('ID da empresa matriz');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
