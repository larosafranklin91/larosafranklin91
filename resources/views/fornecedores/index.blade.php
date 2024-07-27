@extends('layouts.app')

@section('title', 'Lista de Fornecedores')

@section('content')
    <h1>Fornecedores</h1>
    <a href="{{ route('fornecedores.create') }}" class="btn btn-success mb-3">Adicionar Fornecedor</a>
    <table class="table table-bordered" id="fornecedores-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>
                <th>Sede</th>
                <th>Logradouro</th>
                <th>Número</th>
                <th>Complemento</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>CEP</th>
                <th>Contato</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Site</th>
                <th>Ações</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            table = $('#fornecedores-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('fornecedores.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'razao_social', name: 'razao_social' },
                    { data: 'nome_fantasia', name: 'nome_fantasia' },
                    { data: 'cnpj', name: 'cnpj' },
                    { data: 'sede', name: 'sede' },
                    { data: 'logradouro', name: 'logradouro', visible: false },
                    { data: 'numero', name: 'numero', visible: false },
                    { data: 'complemento', name: 'complemento', visible: false },
                    { data: 'bairro', name: 'bairro', visible: false },
                    { data: 'cidade', name: 'cidade' },
                    { data: 'uf', name: 'uf' },
                    { data: 'cep', name: 'cep', visible: false },
                    { data: 'contato', name: 'contato', visible: false },
                    { data: 'telefone', name: 'telefone', visible: false },
                    { data: 'email', name: 'email', visible: false },
                    { data: 'site', name: 'site', visible: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        });

        function deleteFornecedor(id) {
            swal.fire({
                title: 'Você tem certeza?',
                text: 'Esta ação não pode ser revertida.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, delete!',
                reverseButtons: true
            }).then(function(response) {
                if (response.value) {
                    var url = "{{ route('fornecedores.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() { },
                        success: function(data) {
                            table.draw();
                            swal.fire({
                                title: 'Deletado!',
                                text: 'Fornecedor foi deletado com sucesso.',
                                icon: 'success'
                            });
                        },
                        error: function(xhr) {
                            swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo deu erro, tente mais tarde.'
                            });
                        },
                        complete: function() {
                            $('.loading-screen').remove();
                        }
                    });
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Cancelada',
                        text: 'Ação cancelada pelo usuário!'
                    });
                }
            });
        }
    </script>
@endsection
