<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Http\Requests\SuplierByCnpjRequest;
use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    protected $supplierService;
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request){
            return response()->json($this->supplierService->getAllSuppliers($request));
        }); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request){
            return response()->json($this->supplierService->createSupplier($request), 201);
        }); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Int $id)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request, $id){
            return response()->json($this->supplierService->findSupplier($request, $id));
        }); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Int $id)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request, $id){
            return response()->json($this->supplierService->updateSupplier($request, $id));
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Int $id)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request, $id){
            return response()->json($this->supplierService->deleteSupplier($request, $id));
        });
    }

    public function fetchAndStoreByCnpj(SuplierByCnpjRequest $request)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request){
            return response()->json($this->supplierService->fetchAndStoreByCnpj($request), 201);
        });
    }
}
