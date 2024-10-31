<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="Controller responsável por manipular os dados dos fornecedores.",
 * )
 */
class SupplierController extends Controller
{
    private SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * @OA\Get(
     *     path="/suppliers",
     *     summary="Obter todos os fornecedores",
     *     description="Retorna todos os fornecedores cadastrados.",
     *     operationId="getAllSuppliers",
     *     tags={"Suppliers"},
     *      @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Quantos registros por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Qual página deseja visualizar",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     * @OA\Parameter(
     *     name="type_person",
     *     in="query",
     *     required=false,
     *     description="Tipo de pessoa (física ou jurídica)",
     *     @OA\Schema(type="string", enum={"F", "J"})
     * ),
     * @OA\Parameter(
     *     name="supply_city",
     *     in="query",
     *     required=false,
     *     description="Cidade de fornecimento",
     *     @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     *     name="supply_state",
     *     in="query",
     *     required=false,
     *     description="Estado de fornecimento",
     *     @OA\Schema(type="string", maxLength=2)
     * ),
     * @OA\Parameter(
     *     name="supplier_name",
     *     in="query",
     *     required=false,
     *     description="Nome do fornecedor",
     *     @OA\Schema(type="string")
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Retorna a lista de fornecedores",
     *     @OA\JsonContent(
     *         type="object",
     *        @OA\Property(
     *             property="data",
     *             type="array",
     *              @OA\Items(ref="#/components/schemas/Supplier")
     *         ),
     *         @OA\Property(
     *             property="current_page",
     *             type="integer",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="total_pages",
     *             type="integer",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="total_items",
     *             type="integer",
     *             example=1
     *         ),
     *         @OA\Property(
     *             property="per_page",
     *             type="integer",
     *             example=10
     *         )
     *     )
     * ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Erro interno do servidor.")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $filters = $request->only(['type_person', 'supply_city', 'supply_state', 'supplier_name']);
        $orderBy = $request->get('orderBy', 'id');
        $sort = $request->get('sort', 'asc');
        $getDeleted = filter_var($request->get('getDeleted', false), FILTER_VALIDATE_BOOLEAN);

        $perPage = $request->get('per_page', 10); // Itens por página
        $page = $request->get('page', 1); // Página atual

        $suppliers = $this->supplierService->getFilteredSuppliers($filters, $orderBy, $sort, $getDeleted, $perPage, $page);

        return response()->json([
            'data' => $suppliers->items(),
            'current_page' => $suppliers->currentPage(),
            'total_pages' => $suppliers->lastPage(),
            'total_items' => $suppliers->total(),
            'per_page' => $suppliers->perPage(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/suppliers",
     *     summary="Cria um novo fornecedor",
     *     description="Armazena o fornecedor no banco de dados.",
     *     operationId="storeSupplier",
     *     tags={"Suppliers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"supplier_name", "identity_document", "email", "supply_cep", "supply_address_complement", "phone"},
     *             @OA\Property(property="supplier_name", type="string", example="Nome do Fornecedor"),
     *             @OA\Property(property="identity_document", type="string", example="09018331937", description="CPF ou CNPJ"),
     *             @OA\Property(property="email", type="string", format="email", example="supplier@example.com"),
     *             @OA\Property(property="supply_cep", type="string", example="82540230"),
     *             @OA\Property(property="supply_address_complement", type="string", example="123"),
     *             @OA\Property(property="phone", type="string", example="41984653641"),
     *             @OA\Property(property="birthday", type="date", format="date", example="2002-08-20", description="Data de nascimento (apenas se for pessoa física)"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="O fornecedor é criado e adicionado ao banco de dados",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fornecedor criado com sucesso!"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Supplier")),
     *             @OA\Property(property="current_page", type="number", example=1),
     *             @OA\Property(property="total_pages", type="number", example=20),
     *             @OA\Property(property="total_items", type="number", example=250),
     *             @OA\Property(property="per_page", type="number", example=10),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ocorreu algum erro na validação dos dados",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ocorreu um erro durante a validação dos dados. Consulte a documentação."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\AdditionalProperties(
     *                     type="array",
     *                     @OA\Items(type="string", example="The field has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->only(['supplier_name', 'identity_document', 'email', 'supply_cep', 'supply_address_complement', 'phone', 'birthdate', 'type_person']);
        try {
            $supplier = $this->supplierService->createSupplier($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Fornecedor criado com sucesso!',
            'data' => $supplier
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/suppliers/{supplier}",
     *     tags={"Suppliers"},
     *     summary="Obter fornecedor por ID",
     *     description="Retorna os detalhes de um fornecedor específico.",
     *     @OA\Parameter(
     *         name="supplier",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do fornecedor"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Supplier"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Fornecedor não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Erro interno do servidor.")
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        $supplierId = $request->route('supplier');

        $supplier = $this->supplierService->getSupplierById($supplierId);


        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($supplier, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/suppliers/document/{document}",
     *     summary="Obter fornecedor por número de documento (CPF ou CNPJ)",
     *     description="Retorna os detalhes de um fornecedor específico.",
     *     operationId="getSupplierByDocument",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="document",
     *         in="path",
     *         required=true,
     *         description="Número do documento",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Supplier"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Fornecedor não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Erro interno do servidor.")
     *         )
     *     )
     * )
     */
    public function showByDocument(Request $request)
    {
        $supplierDocument = $request->route('document');

        $supplier = $this->supplierService->getSupplierByDocument($supplierDocument);

        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($supplier, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *     path="/suppliers/{supplier}",
     *     summary="Atualiza as informações do fornecedor",
     *     description="Atualiza as informações de um fornecedor no banco de dados.",
     *     operationId="updateSupplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="supplier",
     *         in="path",
     *         required=true,
     *         description="ID do fornecedor que vai ser atualizado",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="supplier_name", type="string", example="Nome do Fornecedor"),
     *             @OA\Property(property="identity_document", type="string", example="09018331937", description="CPF ou CNPJ"),
     *             @OA\Property(property="email", type="string", format="email", example="supplier@example.com"),
     *             @OA\Property(property="supply_cep", type="string", example="82540230"),
     *             @OA\Property(property="supply_address_complement", type="string", example="123"),
     *             @OA\Property(property="phone", type="string", example="41984653641"),
     *             @OA\Property(property="birthday", type="date", format="date", example="2002-08-20", description="Data de nascimento (apenas se for pessoa física)"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor é atualizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fornecedor atualizado com sucesso!!"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Supplier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fornecedor não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro nas validações",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="message", type="string", example="O campo de e-mail deve ser um formato válido.")
     *         )
     *     )
     * )
     */
    public function update(UpdateSupplierRequest $request)
    {
        $data = $request->only(['supplier_name', 'email', 'supply_cep', 'supply_address_complement', 'phone', 'birthdate']);
        $supplierId = $request->route('supplier');
        $supplier = $this->supplierService->getSupplierById($supplierId);

        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        try {
            $supplier =  $this->supplierService->updateSupplier($data, $supplierId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Fornecedor atualizado com sucesso!',
            'data' => $supplier
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/suppliers/{supplier}",
     *     summary="Remover um fornecedor de forma segura",
     *     description="Ao deletar um fornecedor, ele permanecerá no banco de dados, mas não aparecerá nos registros",
     *     operationId="deleteSupplier",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="supplier",
     *         in="path",
     *         required=true,
     *         description="ID do fornecedor que vai ser removido",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Fornecedor é removido",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Fornecedor não encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request)
    {
        $supplierId = $request->route('supplier');
        $supplier = $this->supplierService->getSupplierById($supplierId);

        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->supplierService->deleteSupplier($supplierId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
