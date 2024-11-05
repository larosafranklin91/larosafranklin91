<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Repositories\Address\AddressRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Illuminate\Http\Request;

class SupplierAddressController extends Controller
{
    public function __construct(
        private AddressRepositoryInterface  $repository,
        private SupplierRepositoryInterface $supplierRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index($supplierId)
    {
        request()->query->set('include', 'addresses');

        $supplier = $this->supplierRepository->find($supplierId);

        return AddressResource::collection($supplier->addresses)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request, $supplierId)
    {
        $supplier = $this->supplierRepository->find($supplierId);
        $address = $this->supplierRepository->addAddress($supplier, $request->validated());

        return AddressResource::make($address)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $supplierId, string $addressId)
    {

        $this->supplierRepository->find($supplierId);
        $address = $this->repository->find($addressId);

        return AddressResource::make($address)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, string $supplierId, string $addressId)
    {
        $this->supplierRepository->find($supplierId);

        $address = $this->repository->update($addressId, $request->validated());

        return AddressResource::make($address)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $supplierId, string $addressId)
    {
        $this->supplierRepository->find($supplierId);
        $this->repository->delete($addressId);

        return response()->noContent();
    }
}
