<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SupplierUpdateValidatorTest extends TestCase
{
    protected function createValidator(array $data)
    {
        $request = new UpdateSupplierRequest();
        $request->merge($data);

        return Validator::make($data, $request->rules(), $request->messages());
    }

    public function testUpdateSupplierIdentityDocumentIsBlocked()
    {
        $supplier = Supplier::factory()->create([
            'email' => 'supplier1@example.com',
            'identity_document' => '13759958044'
        ]);

        $updateData = [
            'supplier_name' => 'Fornecedor Atualizado',
            'identity_document' => '13759958055'
        ];

        $this->expectException(ValidationException::class);

        $validator = $this->createValidator($updateData);
        $validator->validate();

        $supplier->refresh();
        $this->assertEquals('13759958044', $supplier->identity_document);
    }

    public function testRejectsInvalidFields()
    {
        $updateData = [
            'supplier_name' => 'Fornecedor Atualizado',
            'invalid_field' => 'valor inválido',
            'another_invalid_field' => 12345
        ];

        $validator = $this->createValidator($updateData);

        $this->assertArrayNotHasKey('invalid_field', $validator->validated());
        $this->assertArrayNotHasKey('another_invalid_field', $validator->validated());
    }

    public function testValidatesOnlyAllowedFields()
    {
        $data = [
            'supplier_name' => 'Fornecedor Válido',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
        ];

        $validator = $this->createValidator($data);

        $this->assertTrue($validator->passes());
        $validatedData = $validator->validated();
        $this->assertEquals($data['supplier_name'], $validatedData['supplier_name']);
        $this->assertEquals($data['email'], $validatedData['email']);
    }

    protected function tearDown(): void
    {
        Supplier::where('email', 'supplier1@example.com')->withTrashed()->forceDelete();
        parent::tearDown();
    }
}
