<?php

use App\Models\LegalEntity;
use App\Models\Person;
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
            $table->enum('type', ['Pessoa Física', 'Pessoa Jurídica']);
            $table->string('company_industry', 100);
            $table->foreignIdFor(Person::class, 'person_id')->nullable();
            $table->foreignIdFor(LegalEntity::class, 'legal_entity_id')->nullable();
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
