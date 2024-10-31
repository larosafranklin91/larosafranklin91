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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('identity_document', 14)->unique();
            $table->string('email');
            $table->number('supply_cep', 8);
            $table->string('supply_city');
            $table->string('supply_state');
            $table->string('supply_address');
            $table->string('supply_address_complement', 20);
            $table->string('phone', 11);
            $table->date('birthdate')->nullable();
            $table->enum('type_person', ['F', 'J']);
            $table->timestamps();
            $table->softDeletes();
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
