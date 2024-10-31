<?php

namespace Tests\Feature;

use App\Http\Requests\StoreSupplierRequest;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

    public function test_it_throws_error_for_invalid_document_length()
    {
        $this->expectException(ValidationException::class);

        $data = ['identity_document' => '12345678'];
        $validator = $this->createValidator($data);
        $validator->validate();
    }

    public function test_it_validates_required_fields()
    {
        $data = [
            'identity_document' => '',
            'supplier_name' => '',
            'email' => '',
            'supply_cep' => '',
            'supply_address_complement' => '',
            'phone' => '',
        ];

        $validator = $this->createValidator($data);

        $this->assertFalse($validator->passes());
        $this->assertEquals(
            'O campo supplier name é obrigatório.',
            $validator->errors()->first('supplier_name')
        );
        $this->assertEquals(
            'O campo identity document é obrigatório.',
            $validator->errors()->first('identity_document')
        );
        $this->assertEquals(
            'O campo email é obrigatório.',
            $validator->errors()->first('email')
        );
        $this->assertEquals(
            'O campo supply cep é obrigatório.',
            $validator->errors()->first('supply_cep')
        );
        $this->assertEquals(
            'O campo supply address complement é obrigatório.',
            $validator->errors()->first('supply_address_complement')
        );
        $this->assertEquals(
            'O campo phone é obrigatório.',
            $validator->errors()->first('phone')
        );
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

    public function test_it_fails_for_invalid_supply_cep_format()
    {
        $data = [
            'supply_cep' => '11111111'
        ];

        $validator = $this->createValidator($data);

        $this->assertFalse($validator->passes());
        $this->assertEquals(
            'O campo supply cep deve ser um formato válido.',
            $validator->errors()->first('supply_cep')
        );
    }

    public function test_it_fails_for_invalid_cpf()
    {
        $data = [
            'identity_document' => '13759958011',
            'type_person' => 'F'
        ];

        $validator = $this->createValidator($data);

        $this->assertFalse($validator->passes());
        $this->assertEquals(
            'O CPF deve ser válido.',
            $validator->errors()->first('identity_document')
        );
    }

    public function test_it_fails_for_invalid_cnpj()
    {
        $data = [
            'identity_document' => '28045354000299',
            'type_person' => 'J'
        ];

        $validator = $this->createValidator($data);

        $this->assertFalse($validator->passes());
        $this->assertEquals(
            'O CNPJ deve ser válido.',
            $validator->errors()->first('identity_document')
        );
    }

    protected function tearDown(): void
    {
        Supplier::where('email', 'supplier1@example.com')->withTrashed()->forceDelete();
        parent::tearDown();
    }
}
