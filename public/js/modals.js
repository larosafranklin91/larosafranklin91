function buscarCNPJ() {
    var cnpj = $('#cnpj').val().replace(/\D/g, '');

    if (cnpj.length !== 14) {
        alert('CNPJ inválido.');
        return;
    }

    $.ajax({
        url: '/buscar-cnpj',
        method: 'GET',
        data: { cnpj: cnpj },
        success: function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                // Preencha os campos do formulário com os dados retornados
                $('#nome').val(data.nome_fantasia || data.razao_social);
                $('#logradouro').val(data.logradouro);
                $('#numero').val(data.numero);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.municipio);
                $('#uf').val(data.uf);
                $('#cep').val(data.cep);
            }
        },
        error: function(xhr) {
            console.error('Erro ao buscar CNPJ:', xhr.responseText);
            alert('Erro ao buscar CNPJ.');
        }
    });
}

function toggleDocumentInputs(modalId) {
    var tipo = $(`#${modalId} #documentoTipo`).val();
    $(`#${modalId} #cpf`).prop('required', false);
    $(`#${modalId} #cnpj`).prop('required', false);

    if (tipo === 'cpf') {
        $(`#${modalId} #cpfGroup`).show();
        $(`#${modalId} #cnpjGroup`).hide();
        $(`#${modalId} #cnpj`).val('');
        $(`#${modalId} #cpf`).prop('required', true);
    } else if (tipo === 'cnpj') {
        $(`#${modalId} #cnpjGroup`).show();
        $(`#${modalId} #cpfGroup`).hide();
        $(`#${modalId} #cpf`).val('');
        $(`#${modalId} #cnpj`).prop('required', true);
    } else {
        $(`#${modalId} #cpfGroup`).hide();
        $(`#${modalId} #cnpjGroup`).hide();
    }
}

function editFornecedor(id) {
    $.ajax({
        url: `/fornecedores/${id}/edit`,
        method: 'GET',
        success: function(data) {
            // Preenche os campos do modal com os dados do fornecedor
            $('#editFornecedorModal #nome').val(data.nome);
            $('#editFornecedorModal #documentoTipo').val(data.cpf ? 'cpf' : 'cnpj').trigger('change');
            $('#editFornecedorModal #cpf').val(data.cpf);
            $('#editFornecedorModal #cnpj').val(data.cnpj);
            $('#editFornecedorModal #cep').val(data.endereco.cep);
            $('#editFornecedorModal #logradouro').val(data.endereco.logradouro);
            $('#editFornecedorModal #numero').val(data.endereco.numero);
            $('#editFornecedorModal #bairro').val(data.endereco.bairro);
            $('#editFornecedorModal #complemento').val(data.endereco.complemento);
            $('#editFornecedorModal #cidade').val(data.endereco.cidade);
            $('#editFornecedorModal #uf').val(data.endereco.uf);

            // Limpar os contatos anteriores
            $('#edit-contacts-container').empty();

            // Adicionar os contatos existentes
            data.contatos.forEach(contato => {
                addContactField('editFornecedorModal');
                $('#editFornecedorModal .contact-entry:last .telefone').val(contato.telefone);
                $('#editFornecedorModal .contact-entry:last .email').val(contato.email);
            });

            // Define a action do formulário para o URL de update
            $('#editFornecedorForm').attr('action', `/fornecedores/${id}`);
        }
    });
}

function handleFormSubmit(event, modalId, formSelector) {
    event.preventDefault(); // Impede o envio normal do formulário

    // Remover máscaras de CPF, CNPJ e CEP
    let cpf = $(`#${modalId} #cpf`).val().replace(/\D/g, '');
    let cnpj = $(`#${modalId} #cnpj`).val().replace(/\D/g, '');
    let cep = $(`#${modalId} #cep`).val().replace(/\D/g, '');

    // Processar todos os telefones e remover as máscaras
    let telefones = [];
    $(`#${modalId} .telefone`).each(function() {
        let telefone = $(this).val().replace(/\D/g, ''); // Remove a máscara
        console.log("🦊 ~ $ ~ telefone:", telefone)
        if (telefone) { // Adiciona ao array apenas se o telefone não estiver vazio
            telefones.push(telefone);
        }
    });

    // Processar todos os e-mails
    let emails = [];
    $(`#${modalId} .email`).each(function() {
        let email = $(this).val();
        console.log("🦊 ~ $ ~ email:", email)
        if (email) { // Adiciona ao array apenas se o e-mail não estiver vazio
            emails.push(email);
        }
    });

    // UF sempre maiúscula
    $(`#${modalId} #uf`).val($(`#${modalId} #uf`).val().toUpperCase());

    // Criar um novo FormData e adicionar os valores processados
    const formData = new FormData($(formSelector)[0]);

    // Setar os campos CPF, CNPJ e CEP
    formData.set('cpf', cpf);
    formData.set('cnpj', cnpj);
    formData.set('cep', cep);

    // Remover dados antigos do FormData e adicionar os arrays de telefones e emails
    formData.delete('telefone[]');
    formData.delete('email[]');
    telefones.forEach(function(telefone) {
        formData.append('telefone[]', telefone);
    });
    emails.forEach(function(email) {
        formData.append('email[]', email);
    });

    for (var pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]); 
    }

    $.ajax({
        url: $(formSelector).attr('action'),
        method: $(formSelector).attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(data) {
            if (data.errors) {
                let errorMessages = '';

                $.each(data.errors, function(key, messages) {
                    if (Array.isArray(messages)) {
                        errorMessages += `<div>${messages.join('<br>')}</div>`;
                    } else {
                        errorMessages += `<div>${messages}</div>`;
                    }
                });

                $(`#${modalId} #formAlert`).html(errorMessages).removeClass('d-none');
            } else {
                $(`#${modalId}`).modal('hide');
                window.location.reload();
            }
        },
        error: function(xhr) {
            console.error('Erro:', xhr.responseText);

            const errors = xhr.responseJSON.errors;
            let errorMessages = '';

            $.each(errors, function(key, messages) {
                if (Array.isArray(messages)) {
                    errorMessages += `<div>${messages.join('<br>')}</div>`;
                } else {
                    errorMessages += `<div>${messages}</div>`;
                }
            });

            $(`#${modalId} #formAlert`).html(errorMessages).removeClass('d-none');
        }
    });
}

function initializeModal(modalId) {
    // Inicializa os eventos para CPF/CNPJ
    $(`#${modalId} #documentoTipo`).change(function() {
        toggleDocumentInputs(modalId);
    });
    toggleDocumentInputs(modalId);

    // Máscaras
    initializeMasks(modalId);

    // Adicionar contato
    $(`#${modalId} #add-contact-btn, #${modalId} #edit-add-contact-btn`).click(function() {
        addContactField(modalId);
    });
}

function initializeMasks(modalId) {
    $(`#${modalId} #cpf`).mask('000.000.000-00');
    $(`#${modalId} #cnpj`).mask('00.000.000/0000-00');
    $(`#${modalId} #cep`).mask('00000-000');
    $(`#${modalId} #numero`).mask('00000');
    $(`#${modalId} #uf`).mask('AA');
    $(`#${modalId} .telefone`).mask('(00) 0000-00009');
    $(`#${modalId} .telefone`).blur(function() {
        if ($(this).val().length == 15) {
            $(this).mask('(00) 00000-0009');
        } else {
            $(this).mask('(00) 0000-00009');
        }
    });
}

function addContactField(modalId) {
    let contactEntry = `
        <div class="form-row contact-entry">
            <div class="form-group col-md-6">
                <label for="telefone" class="required">Telefone</label>
                <input type="text" class="form-control telefone" name="telefone[]" required>
            </div>
            <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control email" name="email[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-contact">Remover</button>
            </div>
        </div>`;
    let isEdit = modalId.includes('edit');
    if (isEdit) {
        $(`#${modalId} #edit-contacts-container`).append(contactEntry);
    } else {
        $(`#${modalId} #contacts-container`).append(contactEntry);
    }
    initializeMasks(modalId);
}

function resetModalOnClose(modalId) {
    $(`#${modalId}`).on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(`#${modalId} #contacts-container`).empty();
        addContactField(modalId);
        $(`#${modalId} #documentoTipo`).val('cpf').trigger('change');
        $(`#${modalId} #formAlert`).html('').addClass('d-none');
    });
}

$(document).ready(function() {
    // Inicializa os modais
    initializeModal('editFornecedorModal');
    initializeModal('addFornecedorModal');

    // Botão para buscar o CNPJ
    $('#buscarCNPJBtn').click(buscarCNPJ);

    // Evento de fechar o modal
    resetModalOnClose('addFornecedorModal');
    resetModalOnClose('editFornecedorModal');

    // Evento de remover contato
    $(document).on('click', '.btn-remove-contact', function() {
        let modalId = $(this).closest('.modal').attr('id');
        if ($(`#${modalId} .contact-entry`).length > 1) {
            $(this).closest('.contact-entry').remove();
        } else {
            alert('Você não pode remover o último contato.');
        }
    });

    // Funções de envio de formulário com AJAX
    $('#editFornecedorForm').on('submit', function(event) {
        handleFormSubmit(event, 'editFornecedorModal', '#editFornecedorForm');
    });
    $('#fornecedorForm').on('submit', function(event) {
        handleFormSubmit(event, 'addFornecedorModal', '#fornecedorForm');
    });
});
