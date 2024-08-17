<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;
use App\Models\Endereco;
use App\Models\Contato;

class FornecedorSeeder extends Seeder
{
    public function run()
    {
        $fornecedores = [
            [
                'nome' => 'Allyson Luan Dunke',
                'cpf' => '08004168990',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua Teste',
                    'numero' => '374',
                    'complemento' => 'Ap 205',
                    'bairro' => 'Mercês',
                    'cidade' => 'Curitiba',
                    'uf' => 'PR',
                    'cep' => '80810900',
                ],
                'contatos' => [
                    ['telefone' => '41984759815', 'email' => 'allyson.dunke@gmail.com'],
                    ['telefone' => '41999988888', 'email' => 'contato@allyson.dunke.com.br'],
                    ['telefone' => '41988887777', 'email' => 'contato@allyson.dunke2.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa A',
                'cpf' => null,
                'cnpj' => '11222333000181',
                'endereco' => [
                    'logradouro' => 'Rua A',
                    'numero' => '123',
                    'complemento' => 'Sala 1',
                    'bairro' => 'Centro',
                    'cidade' => 'São Paulo',
                    'uf' => 'SP',
                    'cep' => '01001000',
                ],
                'contatos' => [
                    ['telefone' => '11987654321', 'email' => 'contato@empresaA.com.br'],
                    ['telefone' => '11987654322', 'email' => 'contato@empresaA2.com.br'],
                    ['telefone' => '11987654323', 'email' => 'contato@empresaA3.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa B',
                'cpf' => null,
                'cnpj' => '12345678000195',
                'endereco' => [
                    'logradouro' => 'Rua B',
                    'numero' => '456',
                    'complemento' => 'Sala 2',
                    'bairro' => 'Bairro B',
                    'cidade' => 'Rio de Janeiro',
                    'uf' => 'RJ',
                    'cep' => '20020000',
                ],
                'contatos' => [
                    ['telefone' => '21987654321', 'email' => 'contato@empresaB.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa C',
                'cpf' => null,
                'cnpj' => '33122456000104',
                'endereco' => [
                    'logradouro' => 'Rua C',
                    'numero' => '789',
                    'complemento' => 'Sala 3',
                    'bairro' => 'Bairro C',
                    'cidade' => 'Curitiba',
                    'uf' => 'PR',
                    'cep' => '80010000',
                ],
                'contatos' => [
                    ['telefone' => '41987654321', 'email' => 'contato@empresaC.com.br'],
                ],
            ],
            [
                'nome' => 'João da Silva',
                'cpf' => '53663265080',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua D',
                    'numero' => '321',
                    'complemento' => 'Ap 1',
                    'bairro' => 'Bairro D',
                    'cidade' => 'Belo Horizonte',
                    'uf' => 'MG',
                    'cep' => '30140000',
                ],
                'contatos' => [
                    ['telefone' => '31987654321', 'email' => 'joao@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Maria Oliveira',
                'cpf' => '48628548009',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua E',
                    'numero' => '654',
                    'complemento' => 'Casa 1',
                    'bairro' => 'Bairro E',
                    'cidade' => 'Fortaleza',
                    'uf' => 'CE',
                    'cep' => '60010000',
                ],
                'contatos' => [
                    ['telefone' => '85987654321', 'email' => 'maria@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa D',
                'cpf' => null,
                'cnpj' => '98765432000194',
                'endereco' => [
                    'logradouro' => 'Rua F',
                    'numero' => '987',
                    'complemento' => 'Sala 4',
                    'bairro' => 'Bairro F',
                    'cidade' => 'Salvador',
                    'uf' => 'BA',
                    'cep' => '40020000',
                ],
                'contatos' => [
                    ['telefone' => '71987654321', 'email' => 'contato@empresaD.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa E',
                'cpf' => null,
                'cnpj' => '19283746000172',
                'endereco' => [
                    'logradouro' => 'Rua G',
                    'numero' => '654',
                    'complemento' => 'Sala 5',
                    'bairro' => 'Bairro G',
                    'cidade' => 'Florianópolis',
                    'uf' => 'SC',
                    'cep' => '88010000',
                ],
                'contatos' => [
                    ['telefone' => '48987654321', 'email' => 'contato@empresaE.com.br'],
                ],
            ],
            [
                'nome' => 'Carlos Eduardo',
                'cpf' => '31721763040',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua H',
                    'numero' => '654',
                    'complemento' => 'Ap 2',
                    'bairro' => 'Bairro H',
                    'cidade' => 'Porto Alegre',
                    'uf' => 'RS',
                    'cep' => '90020000',
                ],
                'contatos' => [
                    ['telefone' => '51987654321', 'email' => 'carlos@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Ana Paula',
                'cpf' => '40426426088',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua I',
                    'numero' => '321',
                    'complemento' => 'Casa 2',
                    'bairro' => 'Bairro I',
                    'cidade' => 'Recife',
                    'uf' => 'PE',
                    'cep' => '50010000',
                ],
                'contatos' => [
                    ['telefone' => '81987654321', 'email' => 'ana@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa F',
                'cpf' => null,
                'cnpj' => '12398745000129',
                'endereco' => [
                    'logradouro' => 'Rua J',
                    'numero' => '123',
                    'complemento' => 'Sala 6',
                    'bairro' => 'Bairro J',
                    'cidade' => 'Brasília',
                    'uf' => 'DF',
                    'cep' => '70010000',
                ],
                'contatos' => [
                    ['telefone' => '61987654321', 'email' => 'contato@empresaF.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa G',
                'cpf' => null,
                'cnpj' => '32165498000102',
                'endereco' => [
                    'logradouro' => 'Rua K',
                    'numero' => '456',
                    'complemento' => 'Sala 7',
                    'bairro' => 'Bairro K',
                    'cidade' => 'Campinas',
                    'uf' => 'SP',
                    'cep' => '13010000',
                ],
                'contatos' => [
                    ['telefone' => '19987654321', 'email' => 'contato@empresaG.com.br'],
                ],
            ],
            [
                'nome' => 'Paulo Roberto',
                'cpf' => '04327348058',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua L',
                    'numero' => '789',
                    'complemento' => 'Ap 3',
                    'bairro' => 'Bairro L',
                    'cidade' => 'Goiânia',
                    'uf' => 'GO',
                    'cep' => '74010000',
                ],
                'contatos' => [
                    ['telefone' => '62987654321', 'email' => 'paulo@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa H',
                'cpf' => null,
                'cnpj' => '33221100000104',
                'endereco' => [
                    'logradouro' => 'Rua M',
                    'numero' => '123',
                    'complemento' => 'Sala 8',
                    'bairro' => 'Bairro M',
                    'cidade' => 'Vitória',
                    'uf' => 'ES',
                    'cep' => '29010000',
                ],
                'contatos' => [
                    ['telefone' => '27987654321', 'email' => 'contato@empresaH.com.br'],
                ],
            ],
            [
                'nome' => 'Rafael Sousa',
                'cpf' => '87860196000',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua N',
                    'numero' => '654',
                    'complemento' => 'Casa 3',
                    'bairro' => 'Bairro N',
                    'cidade' => 'João Pessoa',
                    'uf' => 'PB',
                    'cep' => '58010000',
                ],
                'contatos' => [
                    ['telefone' => '83987654321', 'email' => 'rafael@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Gabriela Santos',
                'cpf' => '61319589049',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua O',
                    'numero' => '321',
                    'complemento' => 'Casa 4',
                    'bairro' => 'Bairro O',
                    'cidade' => 'Maceió',
                    'uf' => 'AL',
                    'cep' => '57010000',
                ],
                'contatos' => [
                    ['telefone' => '82987654321', 'email' => 'gabriela@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa I',
                'cpf' => null,
                'cnpj' => '12345000000191',
                'endereco' => [
                    'logradouro' => 'Rua P',
                    'numero' => '987',
                    'complemento' => 'Sala 9',
                    'bairro' => 'Bairro P',
                    'cidade' => 'Manaus',
                    'uf' => 'AM',
                    'cep' => '69010000',
                ],
                'contatos' => [
                    ['telefone' => '92987654321', 'email' => 'contato@empresaI.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa J',
                'cpf' => null,
                'cnpj' => '10987654000129',
                'endereco' => [
                    'logradouro' => 'Rua Q',
                    'numero' => '654',
                    'complemento' => 'Sala 10',
                    'bairro' => 'Bairro Q',
                    'cidade' => 'Belém',
                    'uf' => 'PA',
                    'cep' => '66010000',
                ],
                'contatos' => [
                    ['telefone' => '91987654321', 'email' => 'contato@empresaJ.com.br'],
                ],
            ],
            [
                'nome' => 'Roberto Lima',
                'cpf' => '37581807088',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua R',
                    'numero' => '321',
                    'complemento' => 'Ap 4',
                    'bairro' => 'Bairro R',
                    'cidade' => 'Natal',
                    'uf' => 'RN',
                    'cep' => '59010000',
                ],
                'contatos' => [
                    ['telefone' => '84987654321', 'email' => 'roberto@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa K',
                'cpf' => null,
                'cnpj' => '11122333000166',
                'endereco' => [
                    'logradouro' => 'Rua S',
                    'numero' => '789',
                    'complemento' => 'Sala 11',
                    'bairro' => 'Bairro S',
                    'cidade' => 'Aracaju',
                    'uf' => 'SE',
                    'cep' => '49010000',
                ],
                'contatos' => [
                    ['telefone' => '79987654321', 'email' => 'contato@empresaK.com.br'],
                ],
            ],
            [
                'nome' => 'Empresa L',
                'cpf' => null,
                'cnpj' => '21098765000142',
                'endereco' => [
                    'logradouro' => 'Rua T',
                    'numero' => '123',
                    'complemento' => 'Sala 12',
                    'bairro' => 'Bairro T',
                    'cidade' => 'Teresina',
                    'uf' => 'PI',
                    'cep' => '64010000',
                ],
                'contatos' => [
                    ['telefone' => '86987654321', 'email' => 'contato@empresaL.com.br'],
                ],
            ],
            [
                'nome' => 'Fernanda Costa',
                'cpf' => '55994626090',
                'cnpj' => null,
                'endereco' => [
                    'logradouro' => 'Rua U',
                    'numero' => '654',
                    'complemento' => 'Casa 5',
                    'bairro' => 'Bairro U',
                    'cidade' => 'São Luís',
                    'uf' => 'MA',
                    'cep' => '65010000',
                ],
                'contatos' => [
                    ['telefone' => '98987654321', 'email' => 'fernanda@exemplo.com'],
                ],
            ],
            [
                'nome' => 'Empresa M',
                'cpf' => null,
                'cnpj' => '99887766000109',
                'endereco' => [
                    'logradouro' => 'Rua V',
                    'numero' => '321',
                    'complemento' => 'Sala 13',
                    'bairro' => 'Bairro V',
                    'cidade' => 'Campo Grande',
                    'uf' => 'MS',
                    'cep' => '79010000',
                ],
                'contatos' => [
                    ['telefone' => '67987654321', 'email' => 'contato@empresaM.com.br'],
                ],
            ],
        ];

        foreach ($fornecedores as $data) {
            $endereco = Endereco::create($data['endereco']);
            $fornecedor = Fornecedor::create([
                'nome' => $data['nome'],
                'cpf' => $data['cpf'],
                'cnpj' => $data['cnpj'],
                'endereco_id' => $endereco->id,
            ]);

            foreach ($data['contatos'] as $contato) {
                Contato::create([
                    'fornecedor_id' => $fornecedor->id,
                    'telefone' => $contato['telefone'],
                    'email' => $contato['email'],
                ]);
            }
        }
    }
}
