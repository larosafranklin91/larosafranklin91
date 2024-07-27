<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fornecedores.index');
    }

    public function getFornecedores(DataTables $dataTables)
    {
        $query = Fornecedor::select([
            'id', 'razao_social', 'nome_fantasia', 'cnpj', 'logradouro',
            'numero', 'complemento', 'bairro', 'cidade', 'uf', 'cep',
            'contato', 'telefone', 'email', 'site', 'sede'
        ]);

        return $dataTables->eloquent($query)
            ->addColumn('actions', function($fornecedor) {
                return '
                    <a href="'.route('fornecedores.edit', $fornecedor->id).'" class="btn btn-sm btn-primary">Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="deleteFornecedor('.$fornecedor->id.')">Excluir</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string',
            'cnpj' => 'required|string|unique:fornecedores',
            'contato' => 'nullable|string',
            'cep' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email',
            'logradouro' => 'nullable|string',
        ]);

        $cnpj = $request->input('cnpj');
        $cnpjLimpo = preg_replace('/\D/', '', $cnpj);

        if (Fornecedor::where('cnpj', $cnpjLimpo)->exists()) {
            return redirect()->back()->withErrors(['cnpj' => 'CNPJ já cadastrado.']);
        }

        $data = $request->all();
        $keysToClean = ['cnpj', 'telefone'];
        $data = $this->removeSpecialCharsFromArray($data, $keysToClean);

       Fornecedor::create($data);

       return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor, $id)
    {
        return Fornecedor::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cnpj' => 'required|string',
            'razao_social' => 'required|string',
            'nome_fantasia' => 'required|string',
            'sede' => 'required|string',
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|integer',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'email' => 'required|email',
        ]);

        $fornecedor = Fornecedor::findOrFail($id);
        $data = $request->all();
        $keysToClean = ['cnpj', 'telefone'];
        $data = $this->removeSpecialCharsFromArray($data, $keysToClean);

        $fornecedor->update($data);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return response()->noContent();
    }

    function removeSpecialCharsFromArray(array $data, array $keys) {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $data[$key] = preg_replace('/[^0-9]/', '', $data[$key]);
            }
        }
        return $data;
    }
}
