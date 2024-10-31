<?php

namespace Tests\Feature;

use App\Http\Requests\StoreSupplierRequest;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Models\Supplier;
use Illuminate\Http\Response;

class SupplierRequestTest extends TestCase
{
    protected function createValidator(array $data)
    {
        $request = new StoreSupplierRequest();
        $request->merge($data);
        return Validator::make($data, $request->rules(), $request->messages());
    }

    public function test_it_sets_type_person_to_f_for_11_digit_document()
    {
        $response = $this->postJson('/api/v1/suppliers', [
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('F', Supplier::where('email', 'supplier1@example.com')->first()->type_person);
    }

    public function test_it_sets_type_person_to_j_for_14_digit_document()
    {
        $response = $this->postJson('/api/v1/suppliers', [
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '28045354000252',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('J', Supplier::where('email', 'supplier1@example.com')->first()->type_person);
    }

    public function test_it_validates_unique_document_and_email()
    {
        $response = $this->postJson('/api/v1/suppliers', [
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty(Supplier::where('email', 'supplier1@example.com')->first());
        $this->assertEquals('Teste de Fornecedor', Supplier::latest()->first()->supplier_name);

        $response = $this->postJson('/api/v1/suppliers', [
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function tearDown(): void
    {
        Supplier::where('email', 'supplier1@example.com')->withTrashed()->forceDelete();
        parent::tearDown();
    }
}
