<div class="modal fade" id="addFornecedorModal" tabindex="-1" role="dialog" aria-labelledby="addFornecedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFornecedorModalLabel">Adicionar Fornecedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="fornecedorForm" method="POST" action="{{ route('fornecedores.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- Alert container -->
                    <div id="formAlert" class="alert alert-danger d-none" role="alert"></div>

                    <!-- Tipo de Documento -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="documentoTipo" class="required">Tipo de Documento</label>
                            <select class="form-control" id="documentoTipo" name="documentoTipo" required>
                                <option value="cpf" selected>CPF</option>
                                <option value="cnpj">CNPJ</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <div id="cpfGroup" style="display: none;">
                                <label for="cpf" class="required">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf">
                            </div>
                            <div id="cnpjGroup" style="display: none;">
                                <label for="cnpj" class="required">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="buscarCNPJBtn">Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-5">
                            <label for="nome" class="required">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>

                    <h5 class="mt-4">Endereço</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="cep" class="required">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="logradouro" class="required">Logradouro</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numero" class="required">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="bairro" class="required">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="cidade" class="required">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado" class="required">UF</label>
                            <input type="text" class="form-control" id="uf" name="uf" required>
                        </div>
                    </div>
                    <h5 class="mt-4">Contatos</h5>
                    <div id="contacts-container">
                        <div class="form-row contact-entry">
                            <div class="form-group col-md-6">
                                <label for="telefone" class="required">Telefone</label>
                                <input type="text" class="form-control telefone" name="telefone[]" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control email" name="email[]">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-contact-btn">Adicionar Contato</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>