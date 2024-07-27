<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CnpjInterface;

class CnpjController extends Controller
{
    protected $cnpjRepository;

    public function __construct(CnpjInterface $cnpjRepository)
    {
        $this->cnpjRepository = $cnpjRepository;
    }

    public function showForm()
    {
        return view('cnpj-form');
    }

    public function fetchCnpjData(Request $request)
    {
        $cnpj = $request->input('cnpj');
        $data = $this->cnpjRepository->getCnpjData($cnpj);

        return response()->json($data);
    }
}
