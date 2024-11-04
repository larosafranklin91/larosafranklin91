<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        try {
            $suppliers = Supplier::query()
                ->when($request->input('search'), function ($query, $search) {
                    return $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(10);
            
            return response()->json($suppliers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve suppliers.'], 500);
        }
    }

    public function store(SupplierRequest $request) // Usando SupplierRequest
    {
        try {
            $supplier = Supplier::create($request->validated());
            return response()->json($supplier, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create supplier. ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return response()->json($supplier);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve supplier.'], 500);
        }
    }

    public function update(SupplierRequest $request, $id) // Usando SupplierRequest
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->validated());
            return response()->json($supplier);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update supplier. ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete supplier.'], 500);
        }
    }
}
