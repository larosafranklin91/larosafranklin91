function deleteFornecedor(id) {
    if (confirm('Tem certeza que deseja excluir este fornecedor?')) {
        $.ajax({
            url: `/fornecedores/${id}`,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#fornecedores-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                console.error('Erro ao excluir fornecedor:', xhr.responseText);
                alert('Erro ao excluir fornecedor.');
            }
        });
    }
}

$(document).ready(function() {
    // Inicializar DataTable
    $('#fornecedores-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/fornecedores/data',
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        columns: [
            { data: 'nome', name: 'nome', width: '20%', orderable: true, searchable: true },
            { 
                data: 'cpf_cnpj', 
                name: 'cpf_cnpj', 
                width: '10%', 
                orderable: false, 
                searchable: true,
                render: function (data, type, row) {
                    if (data.length === 11) { // CPF
                        return data.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                    } else if (data.length === 14) { // CNPJ
                        return data.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
                    }
                    return data;
                }
             },
            { data: 'logradouro_completo', name: 'logradouro_completo', width: '30%', orderable: false, searchable: true },
            { data: 'endereco.cidade', name: 'endereco.cidade', width: '10%', orderable: true, searchable: true },
            { data: 'endereco.uf', name: 'endereco.uf', width: '5%', orderable: true, searchable: true },
            { 
                data: 'contatos.telefone',
                name: 'contatos.telefone',
                width: '10%',
                render: function (data, type, row) {
                    return data.split(', ').map(function(phone) {
                        return phone.replace(/(\d{2})(\d{4,5})(\d{4})/, "($1) $2-$3");
                    }).join(', ');
                }
            },
            { data: 'contatos.email', name: 'contatos.email', width: '10%', orderable: false, searchable: true },
            {
                data: 'id',
                name: 'actions',
                width: '5%',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${data}" data-toggle="modal" data-target="#editFornecedorModal">Editar</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Excluir</button>
                    `;
                }
            }
        ],
        order: [[0, 'asc']],
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            },
            "select": {
                "rows": {
                    "_": "Selecionado %d linhas",
                    "0": "Nenhuma linha selecionada",
                    "1": "Selecionado 1 linha"
                }
            }
        }
    });
    
    // Ocultar a barra de pesquisa global usando CSS
    $('#fornecedores-table_filter').hide();

    $('#fornecedores-table thead th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if ($('#fornecedores-table').DataTable().column(i).search() !== this.value) {
                $('#fornecedores-table').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    // Eventos dos botões de ação
    $('#fornecedores-table').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        editFornecedor(id);
    });

    $('#fornecedores-table').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        deleteFornecedor(id);
    });
});