# Nome do Projeto

Descrição breve do projeto, seus objetivos e funcionalidades.

## Pré-requisitos

Antes de começar, verifique se você tem os seguintes pré-requisitos instalados em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [PHP](https://www.php.net/downloads.php) (opcional, se você preferir rodar fora do Docker)
- [Composer](https://getcomposer.org/download/) (opcional, se você preferir rodar fora do Docker)

## Configuração do Projeto

Siga estas etapas para configurar o projeto localmente.

### 1. Clonar o Repositório

Clone o repositório em sua máquina local:

```bash
git clone git@github.com:luizsilvacaetano192/teste-dev-php.git
cd teste-dev-php

2. Configurar o .env
Copie o arquivo .env.example para um novo arquivo chamado .env e configure as variáveis de ambiente conforme necessário:

bash
Copiar código
cp .env.example .env
Edite o arquivo .env para definir as configurações do banco de dados e outras configurações do projeto.

3. Construir as Imagens do Docker
Se estiver usando Docker, você pode construir e iniciar os containers com o seguinte comando:

bash
Copiar código
docker-compose up -d --build
4. Instalar Dependências do PHP
Se preferir rodar fora do Docker, instale as dependências do PHP usando o Composer:

bash
Copiar código
composer install
5. Executar Migrações do Banco de Dados
Para criar as tabelas no banco de dados, execute as migrações:

bash
Copiar código
docker-compose exec php php artisan migrate
ou, se estiver rodando fora do Docker:

bash
Copiar código
php artisan migrate
6. Rodar os Testes
Para executar os testes do PHPUnit, você pode usar o seguinte comando:

bash

docker-compose exec php php artisan test
ou, se estiver rodando fora do Docker:

bash

php artisan test
Acessando o Aplicativo
Após iniciar os containers, você pode acessar o aplicativo no navegador em:

arduino

http://localhost:3000
Endpoints da API
GET /api/suppliers - Listar fornecedores
POST /api/suppliers - Criar um novo fornecedor
GET /api/suppliers/{id} - Obter um fornecedor específico
PUT /api/suppliers/{id} - Atualizar um fornecedor específico
DELETE /api/suppliers/{id} - Excluir um fornecedor específico


