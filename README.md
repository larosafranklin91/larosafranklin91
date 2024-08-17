# Projeto Fornecedores

Este é um projeto Laravel para gerenciar fornecedores com funcionalidades de CRUD e visualização em uma DataTable. 
Este README fornecerá informações sobre como configurar e executar o projeto.

## Tecnologias utilizadas

- Framework Laravel (PHP) 11.20.0
- MySQL

## Configuração

1. **Clone o repositório**

    ```bash
    git clone https://github.com/alluke96/teste-dev-php.git
    cd teste-dev-php
    ```

2. **Instale as dependências do PHP**

    ```bash
    composer install
    ```

3. **Crie o arquivo `.env`**

    Copie o arquivo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

4. **Configure o arquivo `.env`**

    Edite o arquivo `.env` para configurar o banco de dados e outras variáveis. Exemplo de configuração para MySQL:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco
    DB_USERNAME=usuario
    DB_PASSWORD=senha
    ```

5. **Gere a chave de aplicação**

    ```bash
    php artisan key:generate
    ```

## Migrations e Seeds

1. **Execute as migrations**

    As migrations criam as tabelas necessárias no banco de dados.

    ```bash
    php artisan migrate
    ```

2. **Popule o banco de dados com seeds (opcional)**

    Se você tiver interese em popular o banco de dados com dados iniciais, execute:

    ```bash
    php artisan db:seed
    ```

## Execução do Projeto

1. **Inicie o servidor local**

    ```bash
    php artisan serve
    ```

    O aplicativo estará acessível em `http://127.0.0.1:8000`.

## Execução de testes automatizados

1. **Execução dos testes**

    Para executar os testes automatizados, utilize o seguinte comando:

    ```bash
    php artisan test
    ```

    O Laravel executará todos os testes disponíveis na pasta `tests/`. Verifique os resultados para garantir que todas as funcionalidades estejam funcionando conforme esperado.

## Funcionalidades do Sistema

Este sistema permite que você gerencie fornecedores de forma eficiente. Abaixo, você encontrará um guia sobre como utilizar as principais funcionalidades do sistema.

### 1. **Filtrar e Ordenar Fornecedores**

Na página principal, você verá uma tabela listando todos os fornecedores cadastrados. Para facilitar a navegação e localização de fornecedores específicos, você pode:

- **Filtrar:** No topo de cada coluna, há um campo de entrada onde você pode digitar um termo de pesquisa para filtrar os resultados. Por exemplo, você pode digitar um nome, CPF/CNPJ, ou qualquer outra informação relevante.

- **Ordenar:** Clique no cabeçalho de uma coluna para ordenar os resultados. Um clique ordena em ordem ascendente, e outro clique ordena em ordem descendente.

### 2. **Adicionar um Novo Fornecedor**

Para adicionar um novo fornecedor:

- Clique no botão **Adicionar Fornecedor**, localizado no canto superior direito da página.
- Um modal será aberto, onde você poderá preencher as informações do fornecedor, como nome, CPF ou CNPJ, endereço e contatos.
- Você pode adicionar mais de um contato clicando no botão **Adicionar Contato** dentro do modal.
- Após preencher todas as informações, clique em **Salvar** para adicionar o novo fornecedor ao sistema.

### 3. **Editar um Fornecedor**

Para editar um fornecedor existente:

- Na tabela de fornecedores, localize o fornecedor que deseja editar.
- Clique no botão **Editar** ao lado do fornecedor.
- Um modal será aberto com os campos já preenchidos com as informações atuais do fornecedor.
- Faça as alterações desejadas, incluindo a possibilidade de adicionar ou remover contatos.
- Clique em **Salvar** para atualizar as informações do fornecedor.

### 4. **Excluir um Fornecedor**

Para excluir um fornecedor:

- Na tabela de fornecedores, localize o fornecedor que deseja excluir.
- Clique no botão **Excluir** ao lado do fornecedor.
- Uma caixa de confirmação será exibida, solicitando a confirmação da remoção.
- Confirme a exclusão para prosseguir.

**Nota sobre Remoção Segura:** Ao excluir um fornecedor, o sistema não remove o registro do banco de dados de forma permanente. Em vez disso, o campo **ativo** do fornecedor será definido como `false`, garantindo uma **remoção segura**. Isso significa que o fornecedor não aparecerá mais nas listagens ativas, mas suas informações ainda estarão disponíveis no banco de dados para referência futura, caso necessário.

### 5. **Pesquisar por CNPJ**

Na hora de cadastrar ou editar um fornecedor, você tem a opção de pesquisar as informações de um CNPJ diretamente usando a API BrasilAPI.

- No modal de adição ou edição de fornecedor, insira o CNPJ no campo correspondente.
- Clique no ícone de pesquisa ao lado do campo de CNPJ.
- O sistema buscará automaticamente as informações do CNPJ inserido e preencherá os campos de endereço com os dados retornados pela API.

Essa funcionalidade agiliza o processo de cadastro e garante que as informações sejam precisas e atualizadas.