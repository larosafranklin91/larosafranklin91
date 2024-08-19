@extends('layouts.app')

@section('content')
<table id="fornecedores-table" class="display table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nome<input type="text" placeholder="Filtrar" /></th>
            <th>CPF / CNPJ<input type="text" placeholder="Filtrar" /></th>
            <th>Endereço<input type="text" placeholder="Filtrar" /></th>
            <th>Cidade<input type="text" placeholder="Filtrar" /></th>
            <th>UF<input type="text" placeholder="Filtrar" /></th>
            <th>Telefones<input type="text" placeholder="Filtrar" /></th>
            <th>E-mails<input type="text" placeholder="Filtrar" /></th>
            <th>Ações</th>
        </tr>
    </thead>
</table>
@endsection