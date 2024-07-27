@extends('layouts.app')

@section('title', 'Editar Fornecedor')

@section('content')
    <div class="container mt-5">
        <h1>Editar Fornecedor</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fornecedores.update', $fornecedor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $fornecedor->cnpj) }}" required readonly>
            </div>

            <div class="form-group">
                <label for="razao_social">Razão Social</label>
                <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{ old('razao_social', $fornecedor->razao_social) }}" required>
            </div>

            <div class="form-group">
                <label for="nome_fantasia">Nome Fantasia</label>
                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia', $fornecedor->nome_fantasia) }}" required>
            </div>

            <div class="form-group">
                <label for="sede">Sede</label>
                <select class="form-control" id="sede" name="sede" required>
                    <option value="">Selecione uma opção</option>
                    <option value="filial" {{ old('sede', $fornecedor->sede) == 'filial' ? 'selected' : '' }}>Filial</option>
                    <option value="matriz" {{ old('sede', $fornecedor->sede) == 'matriz' ? 'selected' : '' }}>Matriz</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', $fornecedor->cep) }}" required pattern="\d{8}" title="O CEP deve ter 8 dígitos numéricos.">
            </div>

            <div class="form-group">
                <label for="logradouro">Logradouro</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ old('logradouro', $fornecedor->logradouro) }}" required>
            </div>

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="number" class="form-control" id="numero" name="numero" value="{{ old('numero', $fornecedor->numero) }}" required>
            </div>

            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento', $fornecedor->complemento) }}">
            </div>

            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro', $fornecedor->bairro) }}" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', $fornecedor->cidade) }}" required>
            </div>

            <div class="form-group">
                <label for="uf">UF</label>
                <input type="text" class="form-control" id="uf" name="uf" value="{{ old('uf', $fornecedor->uf) }}" required pattern="[A-Z]{2}" title="UF deve conter 2 letras maiúsculas.">
            </div>

            <div class="form-group">
                <label for="contato">Contato</label>
                <input type="text" class="form-control" id="contato" name="contato" value="{{ old('contato', $fornecedor->contato) }}">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $fornecedor->telefone) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $fornecedor->email) }}" required>
            </div>

            <div class="form-group">
                <label for="site">Site</label>
                <input type="url" class="form-control" id="site" name="site" value="{{ old('site', $fornecedor->site) }}">
            </div>
            <div class="col-md-12 text-right">
                <a href="{{ url()->previous() }}" class="btn btn-default">
                    <i class="fa fa-ban" aria-hidden="true"></i> {{'Cancel'}}
                </a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#cnpj').inputmask('99.999.999/9999-99');
            Inputmask("(99) 99999-9999").mask("#telefone");
        });
    </script>
@endsection
