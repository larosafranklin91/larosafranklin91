<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SupplierController extends Controller
{
    public function __construct(
        private SupplierRepositoryInterface $repository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $suppliers = $this->repository->paginate(
            params: $request->query(),
            perPage: $request->query('per_page', 10),
            page: $request->query('page', 1)
        );

        return SupplierResource::collection($suppliers)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = $this->repository->create($request->validated());

        return SupplierResource::make($supplier)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $supplier = $this->repository->find($id);

            return SupplierResource::make($supplier)
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Supplier Not Found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, string $id)
    {
        try {
            $supplier = $this->repository->update($id, $request->validated());

            return SupplierResource::make($supplier)
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("Supplier Not Found");
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->repository->delete($id)) {
          throw new NotFoundException("Supplier Not Found");
        }

        return response()->noContent();
    }
}
