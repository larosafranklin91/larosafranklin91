## Teste para Desenvolvedor PHP/Laravel

Bem-vindo ao teste de desenvolvimento para a posição de Desenvolvedor PHP/Laravel. 

O objetivo deste teste é desenvolver uma API Rest para o cadastro de fornecedores, permitindo a busca por CNPJ ou CPF, utilizando Laravel no backend.

## Descrição do Projeto

### Backend (API Laravel):

#### CRUD de Fornecedores:
- **Criar Fornecedor:**
  - Permita o cadastro de fornecedores usando CNPJ ou CPF, incluindo informações como nome/nome da empresa, contato, endereço, etc.
  - Valide a integridade e o formato dos dados, como o formato correto de CNPJ/CPF e a obrigatoriedade de campos.

- **Editar Fornecedor:**
  - Facilite a atualização das informações de fornecedores, mantendo a validação dos dados.

- **Excluir Fornecedor:**
  - Possibilite a remoção segura de fornecedores.

- **Listar Fornecedores:**
  - Apresente uma lista paginada de fornecedores, com filtragem e ordenação.

#### Migrations:
- Utilize migrations do Laravel para definir a estrutura do banco de dados, garantindo uma boa organização e facilidade de manutenção.

## Requisitos

### Backend:
- Implementar busca por CNPJ na [BrasilAPI](https://brasilapi.com.br/docs#tag/CNPJ/paths/~1cnpj~1v1~1{cnpj}/get) ou qualquer outro endpoint público.

## Tecnologias a serem utilizadas
- Framework Laravel (PHP) 9.x ou superior
- MySQL ou Postgres

## Critérios de Avaliação
- Adesão aos requisitos funcionais e técnicos.
- Qualidade do código, incluindo organização, padrões de desenvolvimento e segurança.
- Documentação do projeto, incluindo um README detalhado com instruções de instalação e operação.

## Bônus
- Implementação de Repository Pattern.
- Implementação de testes automatizados.
- Dockerização do ambiente de desenvolvimento.
- Implementação de cache para otimizar o desempenho.

## Entrega
- Para iniciar o teste, faça um fork deste repositório; Se você apenas clonar o repositório não vai conseguir fazer push.
- Crie uma branch com o nome que desejar;
- Altere o arquivo README.md com as informações necessárias para executar o seu teste (comandos, migrations, seeds, etc);
- Depois de finalizado, envie-nos o pull request;



######


## Entrega


######



# Projeto de API Laravel

Este projeto é uma API construída com Laravel, projetada para gerenciar fornecedores. A API oferece diversas rotas para operações CRUD e testes.

## Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração do Ambiente](#configuração-do-ambiente)
- [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
- [Rotas da API](#rotas-da-api)
- [Testando as Rotas](#testando-as-rotas)
- [Contribuição](#contribuição)
- [Licença](#licença)

## Requisitos

Antes de começar, você precisará de:

- PHP 8.0 ou superior
- Composer
- Um servidor web (como Apache ou Nginx)
- SQLite (ou outro banco de dados configurado)

## Instalação

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/C1ph3rBR/teste_php.git
   cd teste_php
   ```

2. **Instale as dependências do Laravel**:
   ```bash
   composer install
   ```

3. **Crie o arquivo `.env`**:
   Copie o arquivo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Gere a chave da aplicação**:
   Execute o comando abaixo para gerar a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

5. **Crie o banco de dados SQLite** (se utilizar SQLite):
   Crie um arquivo vazio chamado `database.sqlite` em uma pasta selecionada:
   ```bash
   mkdir -p database
   touch database/database.sqlite
   ```

## Configuração do Ambiente

O arquivo `.env` já está configurado com as seguintes definições:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:Bv+Qx2BlVQHQkCIRG48DqPFn9fXJZKZCWhFgCcAdtY4=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE= #usar a pasta selecionda no topico 5 
```

Verifique se essas configurações atendem às suas necessidades.

## Configuração do Banco de Dados

### Usando SQLite

Para usar o SQLite, certifique-se de que o caminho do banco de dados está correto no arquivo `.env`. Você pode criar um arquivo SQLite vazio se ele ainda não existir:

```bash
mkdir -p database
touch database/database.sqlite
```

### Usando MySQL ou outro banco de dados

Se você preferir usar MySQL ou outro banco de dados, ajuste as seguintes configurações no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

Certifique-se de ter o driver do banco de dados correspondente instalado. Para MySQL, você pode instalar o driver executando:

```bash
composer require doctrine/dbal
```

### Dependências

Se você não tem o SQLite instalado, você pode instalá-lo usando:

- **Linux**: `sudo apt-get install sqlite3`
- **macOS**: `brew install sqlite`

## Rotas da API

As seguintes rotas estão disponíveis na API:

- `GET /api/fornecedores` - Lista todos os fornecedores.
- `GET /api/teste` - Rota de teste para verificar se a API está funcionando.
- `POST /api/fornecedores` - Cria um novo fornecedor.
- `PUT /api/fornecedores/{id}` - Atualiza um fornecedor existente.
- `DELETE /api/fornecedores/{id}` - Exclui um fornecedor.
- `GET /api/fornecedores/buscar-cnpj/{cnpj}` - Busca um fornecedor pelo CNPJ.

### Rotas de Teste

- `POST /api/fornecedores/teste-criar` - Testa a criação de um fornecedor.
- `PUT /api/fornecedores/teste-editar/{id}` - Testa a edição de um fornecedor.
- `DELETE /api/fornecedores/teste-excluir/{id}` - Testa a exclusão de um fornecedor.
- `GET /api/fornecedores/teste-buscar-cnpj/{cnpj}` - Testa a busca de um fornecedor pelo CNPJ.

## Testando as Rotas

Você pode usar ferramentas como Postman ou Insomnia para testar as rotas da API. Certifique-se de que o servidor esteja em execução. Você pode iniciar o servidor de desenvolvimento do Laravel com o comando:

```bash
php artisan serve
```

Depois, você poderá acessar a API em `http://localhost:8000/api/`.


