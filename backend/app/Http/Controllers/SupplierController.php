<?php

namespace App\Http\Controllers;

use App\Dto\SupplierInputDTO;
use App\Http\Requests\CreateSupplierRequest;
use App\Http\Requests\ListSuppliersRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="Operations related to suppliers management"
 * )
 */
class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service){}

    /**
     * @OA\Get(
     *     path="/api/suppliers",
     *     summary="List all suppliers",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="filter_by",
     *         in="query",
     *         description="Filter suppliers by column",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="filter_value",
     *         in="query",
     *         description="Filter suppliers value",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Supplier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     )
     * )
     */
    public function index(ListSuppliersRequest $request){
        $data = $request->validated();
        return SupplierResource::collection($this->service->list($data), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/suppliers",
     *     summary="Create a new supplier",
     *     tags={"Suppliers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateSupplierRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Supplier created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while creating Supplier"
     *     )
     * )
     */
    public function store(CreateSupplierRequest $request)
    {
        $data = $request->validated();
        try {
            $supplierDTO = new SupplierInputDTO(...$data);
            $supplier = $this->service->create($supplierDTO);
            return new SupplierResource($supplier, 201);
        } catch (\Exception $exception) {
            return new JsonResponse('Error while creating Supplier' . $exception, 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/suppliers/{id}",
     *     summary="Get a supplier by ID",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Supplier ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplier not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while searching Supplier"
     *     )
     * )
     */
    public function show(int $id){
        try {
            $supplier = $this->service->find($id);
            return new SupplierResource($supplier, 200);
        } catch (\Exception $exception) {
            return new JsonResponse('Error while searching Supplier' . $exception, 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/suppliers/{id}",
     *     summary="Update a supplier by ID",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Supplier ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateSupplierRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while updating Supplier"
     *     )
     * )
     */
    public function update(int $id, UpdateSupplierRequest $request){
        $data = $request->validated();
        try {
            $supplierDTO = new SupplierInputDTO(...$data);
            $supplier = $this->service->update($id, $supplierDTO);
            return new SupplierResource($supplier, 200);
        } catch (\Exception $exception) {
            return new JsonResponse('Error while updating Supplier' . $exception, 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/suppliers/{id}",
     *     summary="Delete a supplier by ID",
     *     tags={"Suppliers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Supplier ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplier deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while deleting Supplier"
     *     )
     * )
     */
    public function destroy(int $id){
        try{
            if($this->service->delete($id)){
                return new JsonResponse('', 200);
            }
        }catch(Exception $exception){
            return new JsonResponse('Error while deleting Supplier' . $exception, 500);
        }
    }

}
