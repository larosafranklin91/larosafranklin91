@extends('layouts.app')

@section('title', 'Criar Fornecedores')

@section('content')
    <div class="container mt-5">
        <h1>Cadastrar Fornecedor</h1>

        <div id="overlay" style=" display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            font-size: 24px;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;">
            <div>Aguardando... <span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fornecedores.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" required>
            </div>

            <div class="form-group">
                <label for="razao_social">Razão Social</label>
                <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{ old('razao_social') }}" required>
            </div>

            <div class="form-group">
                <label for="nome_fantasia">Nome Fantasia</label>
                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia') }}" required>
            </div>

            <div class="form-group">
                <label for="sede">Sede</label>
                <select class="form-control" id="sede" name="sede" required>
                    <option value="">Selecione uma opção</option>
                    <option value="filial" {{ old('sede') == 'filial' ? 'selected' : '' }}>Filial</option>
                    <option value="matriz" {{ old('sede') == 'matriz' ? 'selected' : '' }}>Matriz</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep') }}" required pattern="\d{8}" title="O CEP deve ter 8 dígitos numéricos.">
            </div>

            <div class="form-group">
                <label for="logradouro">Logradouro</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ old('logradouro') }}" required>
            </div>

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="number" class="form-control" id="numero" name="numero" value="{{ old('numero') }}" required>
            </div>

            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento') }}">
            </div>

            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro') }}" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
            </div>

            <div class="form-group">
                <label for="uf">UF</label>
                <input type="text" class="form-control" id="uf" name="uf" value="{{ old('uf') }}" required pattern="[A-Z]{2}" title="UF deve conter 2 letras maiúsculas.">
            </div>

            <div class="form-group">
                <label for="contato">Contato</label>
                <input type="text" class="form-control" id="contato" name="contato" value="{{ old('contato') }}">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="site">Site</label>
                <input type="url" class="form-control" id="site" name="site" value="{{ old('site') }}">
            </div>
            <div class="col-md-12 text-right">
                <a href="{{ url()->previous() }}" class="btn btn-default">
                    <i class="fa fa-ban" aria-hidden="true"></i> {{'Cancel'}}
                </a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#overlay').hide();
            $('#cnpj').inputmask('99.999.999/9999-99');
            Inputmask("(99) 99999-9999").mask("#telefone");

            $('#cnpj').on('blur', function() {
                const cnpj = $(this).val().replace(/[^\d]+/g, '');
                if (cnpj.length === 14) {
                    $('#overlay').show();
                }
                $.ajax({
                    url: '/fetch-cnpj-data',
                    method: 'POST',
                    data: {
                        cnpj: cnpj,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response) {
                            $('#razao_social').val(response.razao_social || '');
                            $('#nome_fantasia').val(response.nome_fantasia || '');
                            $('#logradouro').val(response.logradouro || '');
                            $('#numero').val(response.numero || '');
                            $('#complemento').val(response.complemento || '');
                            $('#bairro').val(response.bairro || '');
                            $('#cidade').val(response.localidade || '');
                            $('#uf').val(response.uf || '');
                            $('#cep').val(response.cep || '');
                        } else {
                            console.warn('Nenhum dado encontrado para o CNPJ fornecido.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Erro ao buscar dados do CNPJ:', xhr);
                        setTimeout(function() {
                            $('#overlay').hide();
                        }, 500);
                    },
                    complete: function() {
                        setTimeout(function() {
                            $('#overlay').hide();
                        }, 500);
                    }
                });
            });
        });
    </script>

@endsection

