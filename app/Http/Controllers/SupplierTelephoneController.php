<?php

namespace App\Http\Controllers;

use App\Http\Requests\TelephoneRequest;
use App\Http\Resources\TelephoneResource;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use App\Repositories\Telephone\TelephoneEloquentRepository;
use Illuminate\Http\Request;

class SupplierTelephoneController extends Controller
{
    public function __construct(
        private  TelephoneEloquentRepository $repository,
        private SupplierRepositoryInterface $supplierRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index($supplierId)
    {
        request()->query->set('include', 'telephones');

        $supplier = $this->supplierRepository->find($supplierId);

        return TelephoneResource::collection($supplier->telephones)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TelephoneRequest $request, $supplierId)
    {
        $supplier = $this->supplierRepository->find($supplierId);
        $telephone = $this->supplierRepository->addTelephone($supplier, $request->validated());

        return TelephoneResource::make($telephone)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $supplierId, string $telephoneId)
    {
        $this->supplierRepository->find($supplierId);
        $telephone = $this->repository->find($telephoneId);

        return TelephoneResource::make($telephone)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TelephoneRequest $request, string $supplierId, string $telephoneId)
    {
        $this->supplierRepository->find($supplierId);

        $telephone = $this->repository->update($telephoneId, $request->validated());

        return TelephoneResource::make($telephone)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $supplierId, string $telephoneId)
    {
        $this->supplierRepository->find($supplierId);
        $this->repository->delete($telephoneId);

        return response()->noContent();
    }
}
