# Api REST Cadastro Fornecedores Laravel

Este projeto é uma aplicação web desenvolvida usando Laravel para o para o desenvolvimento de uma api rest que permite o cadastro e a busca de fornecedores.

## Requisitos

- PHP 8.3
- MySQL 8
- Composer
- Laravel 11.x
- Docker & Docker Compose

## Estrutura do Projeto


- `/docker-compose.yml`: Contém o código para a composição dos serviços docker (Servidor Web e Banco).
- `/DOCKERFILE`: Contém o código para definição da Imagem do conteiner do Servidor Web.
- `/httpd.conf`: Arquivo de Configuração do Apache, que e injetado no container do Servidor durante o Build.
- `/supervisord.conf`: Arquivo de configuração do Supervisor, que é o gerenciador de inicializaçao que adotei para Linux Alpine (distro base da imagem).
  - `app/`: Contém o código backend do Laravel.
    - `Services/`: Contém as classes da camada de Serviço
    - `Repositories/`: Contém as classes da camada de Acesso aos Dados
    - `Dto/`: Contém as Classes de Mapeamento Negócio/Persistência
  - `database/seeders/`: Contém os seeders para popular o banco de dados.
- `database/`: É o diretório onde está mapeado o banco de dados, para garantir a persistência dos dados, caso o container do mysql caia.

## Funcionalidades

- Cadastro de Fornecedores
- Listagem de Fornecedores, com Ordenação e Filtragem
- Atualização de Cadastro de Fornecedores
- Remoção de Cadastro de Fornecedor

## Tecnologias Utilizadas

- Laravel 11.x
- Vue.js 3.x
- MySQL 8
- PHP 8.3

## Configuração do Projeto

### 1. Clone o Repositório

```bash
git clone https://github.com/JoseLucasAquino/teste-dev-php.git
```

### 2. Faça o Build do Ambiente Docker
```bash
docker compose up -d 
```

### 3. Instale as Dependências do PHP

```bash
docker compose exec supplier-server composer install
```

### 4. Configure o Banco de Dados

## Altere o arquivo /backend/.env conforme o exemplo

```makefile
DB_CONNECTION=mysql
DB_HOST=supplier-db
DB_PORT=3306
DB_DATABASE=supplier
DB_USERNAME=supplier
DB_PASSWORD=supplier
```

### 5. Execute as migrations do Banco de Dados

```bash
docker compose exec supplier-server php artisan migrate
```

### 6. Gere o Seed do Banco de Dados

```bash
docker compose exec supplier-server php artisan db:seed
```

### 7. Acesse a api

O sistema estará disponível em http://localhost:8250.

### 8. Documentação Api(Swagger)

A documentalção estará disponível em http://localhost:8250/api/documentation.

## 9. Gerar Assets da Documentação

Caso seja necessário, para gerar novamente os assets da documentação, execute:

```bash
docker compose exec supplier-server php artisan l5-swagger:generate
```