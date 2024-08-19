<?php

namespace App\Http\Controllers;

use App\Repositories\FornecedorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FornecedorController extends Controller
{
    protected $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function index()
    {
        return view('fornecedores');
    }

    public function buscarCNPJ(Request $request)
    {
        $cnpj = preg_replace('/\D/', '', $request->input('cnpj'));

        if (strlen($cnpj) !== 14) {
            return response()->json(['error' => 'CNPJ inválido'], 422);
        }

        try {
            $response = $this->fornecedorRepository->buscarCNPJ($cnpj);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'CNPJ não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar CNPJ'], 500);
        }
    }

    public function getFornecedores()
    {
        $query = $this->fornecedorRepository->getAllFornecedores();
        
        return DataTables::eloquent($query)
            ->addColumn('cpf_cnpj', function ($fornecedor) {
                return $fornecedor->cpf ? $fornecedor->cpf : $fornecedor->cnpj;
            })
            ->addColumn('logradouro_completo', function ($fornecedor) {
                return $fornecedor->endereco->logradouro . ', ' . $fornecedor->endereco->numero . ' - ' . $fornecedor->endereco->complemento . ' (' . $fornecedor->endereco->bairro . ')';
            })
            ->addColumn('contatos.telefone', function ($fornecedor) {
                return $fornecedor->contatos->pluck('telefone')->implode(', ');
            })
            ->addColumn('contatos.email', function ($fornecedor) {
                $emails = $fornecedor->contatos->pluck('email')->filter()->implode(', ');
                return $emails ?: 'N/A';
            })
            ->filterColumn('cpf_cnpj', function($query, $keyword) {
                $keyword = preg_replace('/[^\d]/', '', $keyword);
                $query->where(function($query) use ($keyword) {
                    $query->where('cpf', 'like', "%{$keyword}%")
                        ->orWhere('cnpj', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('logradouro_completo', function($query, $keyword) {
                $query->whereHas('endereco', function($query) use ($keyword) {
                    $query->where('logradouro', 'like', "%{$keyword}%")
                        ->orWhere('numero', 'like', "%{$keyword}%")
                        ->orWhere('complemento', 'like', "%{$keyword}%")
                        ->orWhere('bairro', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('contatos.telefone', function($query, $keyword) {
                $keyword = preg_replace('/[^\d]/', '', $keyword);
                $query->whereHas('contatos', function($query) use ($keyword) {
                    $query->where('telefone', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('contatos.email', function($query, $keyword) {
                $query->whereHas('contatos', function($query) use ($keyword) {
                    $query->where('email', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }

/**
 * @OA\Get(
 *     path="/api/fornecedores",
 *     summary="Retorna uma lista paginada de fornecedores",
 *     description="Retorna uma lista de fornecedores com filtros opcionais e ordenação",
 *     tags={"Fornecedores"},
 *     @OA\Parameter(
 *         name="filter_value",
 *         in="query",
 *         description="Valor a ser filtrado",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="filter_by",
 *         in="query",
 *         description="Campo pelo qual o filtro será aplicado",
 *         required=false,
 *         @OA\Schema(type="string", enum={"nome", "cpf", "cnpj", "logradouro", "telefone", "email"})
 *     ),
 *     @OA\Parameter(
 *         name="order_by",
 *         in="query",
 *         description="Campo pelo qual a ordenação será aplicada",
 *         required=false,
 *         @OA\Schema(type="string", enum={"nome", "cpf", "cnpj"})
 *     ),
 *     @OA\Parameter(
 *         name="direction",
 *         in="query",
 *         description="Direção da ordenação (asc ou desc)",
 *         required=false,
 *         @OA\Schema(type="string", enum={"asc", "desc"})
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de fornecedores retornada com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/Fornecedor")
 *             ),
 *             @OA\Property(property="current_page", type="integer"),
 *             @OA\Property(property="last_page", type="integer"),
 *             @OA\Property(property="per_page", type="integer"),
 *             @OA\Property(property="total", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro de validação"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro no servidor"
 *     )
 * )
 */
    public function getFornecedoresList(Request $request)
    {
        // Extraindo os parâmetros de filtro, ordenação e paginação da request
        $params = [
            'filter_value' => $request->input('filter_value'),
            'filter_by' => $request->input('filter_by'),
            'order_by' => $request->input('order_by'),
            'direction' => $request->input('direction'),
        ];

        // Obtendo os fornecedores paginados através do repositório
        $fornecedores = $this->fornecedorRepository->getFornecedoresList($params);

        // Retornando a resposta em JSON para ser usada na API ou em uma view
        return response()->json($fornecedores);
    }

    public function store(Request $request)
    {
        $data = $this->validateAndNormalize($request);

        try {
            $this->fornecedorRepository->storeFornecedor($data);
            return response()->json(['success' => 'Fornecedor adicionado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['general' => 'Erro ao adicionar o fornecedor. Tente novamente.']], 500);
        }
    }

    public function edit($id)
    {
        $fornecedor = $this->fornecedorRepository->findFornecedorById($id);
        return response()->json($fornecedor);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateAndNormalize($request, $id);

        try {
            $this->fornecedorRepository->updateFornecedor($id, $data);
            return response()->json(['message' => 'Fornecedor atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['general' => 'Erro ao atualizar o fornecedor. Tente novamente.']], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->fornecedorRepository->deleteFornecedor($id);
            return response()->json(['message' => 'Fornecedor removido com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['general' => 'Erro ao remover o fornecedor. Tente novamente.']], 500);
        }
    }

    private function validateAndNormalize(Request $request, $id = null)
    {
        // Limpar os campos para manter apenas números
        $cpf = $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null;
        $cnpj = $request->cnpj ? preg_replace('/\D/', '', $request->cnpj) : null;
        $cep = $request->cep ? preg_replace('/\D/', '', $request->cep) : null;
        $telefone = $request->telefone ? preg_replace('/\D/', '', $request->telefone) : null;

        // UF armazenada em letras maiúsculas
        $uf = strtoupper($request->uf);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|regex:/^\d{11}$/|unique:fornecedores,cpf,' . $id,
            'cnpj' => 'nullable|string|size:14|regex:/^\d{14}$/|unique:fornecedores,cnpj,' . $id,
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:6',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|size:2|regex:/^[A-Z]{2}$/i',
            'cep' => 'required|string|size:8',
            'telefone.*' => 'required|string|min:10|max:11|regex:/^\d{10,11}$/',
            'email.*' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            response()->json(['errors' => $validator->errors()->getMessages()], 422)->throwResponse();
        }

        if ($cpf && !validarCPF($cpf)) {
            response()->json(['errors' => ['cpf' => 'O CPF informado é inválido.']], 422)->throwResponse();
        }
    
        if ($cnpj && !validarCNPJ($cnpj)) {
            response()->json(['errors' => ['cnpj' => 'O CNPJ informado é inválido.']], 422)->throwResponse();
        }

        if (($cpf && $cnpj) || (!$cpf && !$cnpj)) {
            response()->json(['errors' => ['cpf_cnpj' => 'Preencha apenas o CPF ou o CNPJ, não ambos.']], 422)->throwResponse();
        }

        return compact('cpf', 'cnpj', 'cep', 'telefone', 'uf') + $request->all();
    }
}
