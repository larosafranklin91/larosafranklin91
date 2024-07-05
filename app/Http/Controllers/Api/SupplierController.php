<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Supplier\StoreSupplierRequest;
use App\Http\Requests\Api\Supplier\UpdateSupplierRequest;
use App\Http\Resources\Supplier\SupplierCollection;
use App\Http\Resources\Supplier\SupplierResource;
use App\Http\Services\SearchCpfCnpjService;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function __construct(private SearchCpfCnpjService $searchCpfCnpjService)
    {
        $this->searchCpfCnpjService = $searchCpfCnpjService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'order' => 'in:asc,desc',
            'per_page' => 'integer|min:1',
            'page' => 'integer|min:1',
        ]);

        $suppliers = Supplier::orderBy('company_name', $request->order)
            ->paginate(page: $request->page ?? 1, perPage: $request->per_page ?? 10);
        return response()->json(new SupplierCollection($suppliers), 200);
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = new Supplier();
        $supplier->fill($request->all());
        if ($this->searchCpfCnpjService->validateCpfCnpj($request->cpf_cnpj)) {
            $supplier = $this->searchCpfCnpjService->setCnpj($supplier);
        }
        $supplier->save();
        return response()->json(new SupplierResource($supplier), 201);
    }

    public function show(Supplier $supplier)
    {
        return response()->json(new SupplierResource($supplier), 200);
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        return response()->json(new SupplierResource($supplier), 200);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(null, 204);
    }
}
