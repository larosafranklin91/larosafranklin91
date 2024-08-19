<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fornecedores</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- CSS local -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="m-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h1 class="mb-4">Lista de Fornecedores</h1>
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addFornecedorModal">
                Adicionar Fornecedor
            </button>
        </div>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @include('modals.add_fornecedor')
    @include('modals.edit_fornecedor')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- Inclusão de JavaScript local -->
    <script src="{{ asset('js/fornecedores.js') }}"></script>
    <script src="{{ asset('js/modals.js') }}"></script>
</body>
</html>
