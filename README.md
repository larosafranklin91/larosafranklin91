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

## Como rodar com docker

1. Execute o comando para rodar com o docker:
    ```bash
   docker-compose up -d --build

2. Atualize o .env com os dados do banco de dados configurados no docker
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=teste_php
    DB_USERNAME=root
    DB_PASSWORD=rootpassword

3. Para abrir o terminal do laravel no docker, execute o comando:
    ```bash
    docker exec -it laravel_app bash

4. Rode a migration para o projeto:
    ```bash
    php artisan migrate

5. Atualize o .env.testing com os dados do banco de dados configurados no docker para testes
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=teste_php_testing
    DB_USERNAME=root
    DB_PASSWORD=rootpassword

6. Para executar os testes automatizados, rode as migrations para testes:
    ```bash
    php artisan migrate --env=testing

7. Execute os testes do laravel:
    ```bash
    php artisan test