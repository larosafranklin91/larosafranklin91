# Teste Api PHP

Este projeto tem como objetivo apresentar uma API para cadastro de fornecedores.
A API conta com rotas para cadastro do usuário, login e CRUD para os fornecedores.


## Como Executar o projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/matheushro/teste-dev-php

2. Navegue até o diretório do projeto
   ```bash
   cd [diretório do projeto]
   
3. Instale as dependências:
   ```bash
   composer install

4. Duplique o .env.example alterando o arquivo para apenas .env e atualize as configurações do banco de dados

5. Para rodar o projeto, execute:
   ```bash
   php artisan serve
   
6. Para atualizar o banco de dados, execute:
   ```bash
   php artisan migrate


## Autenticação

Para autenticação na API, é necessário utilizar o token retornado após LOGIN e enviar como Bearer Token.


## POSTMAN

Se desejar utilizar POSTMAN para os testes, na pasta /docs existe uma coleção do POSTMAN em formato JSON, importe no POSTMAN para realizar os testes por la.

1. Ao utilizar o POSTMAN, após o LOGIN é necessário atualizar a váriavel {{AUTHENTICATION_TOKEN}} da coleção com o TOKEN retornado da API.

## Testes automatizados

Para realizar os testes, siga o passo a passo:

1. Crie um arquivo .env.testing duplicando o .env

2. No .env.testing, atualize o nome do banco de dados adicionando _testing no final do nome

3. Utilize o comando:
    ```bash
   php artisan migrate --env=testing

4. Para rodar os testes, utilize o comando:
    ```bash
   php artisan test