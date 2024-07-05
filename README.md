## Inicializando o projeto

- Faça o clone do projeto utilizando o comando: git clone

- Apos baixar o projeto utilize o comando: composer update

- Depois de baixar as dependencias, utilize o comando: php artisan migrate --seed

- Após rodar as migrates voce deve rodar o comando: php artisan passport:install

- Para finalizar a inicializacao do server rode o comando: php artisan serve

- Voce ja esta pronto para utilzar a api.

## Utilizando as Api's

- Existem um crude de fornecedor, localizado no host http://127.0.0.1:8000

- Para ter acesso a api voce deve logar e obter um token, nesse momento voce deve abri seu postman ou outro software de sua preferencia para acessar a api.

- No host: http://127.0.0.1:8000/api/login acrescente ao body as credenciais que voce vai encontrar no no seeder NewUserSeeder.

- Apos logar e adiquirir seu token. copie o access_token e voce ja esta pronto para autenticar e seguir em frente.

## Apis disponiveis

- Get: http://127.0.0.1:8000/api/suppliers?page=1&per_page=10&order=asc
- Post: http://127.0.0.1:8000/api/suppliers
- Get: http://127.0.0.1:8000/api/suppliers/:supplier
- Delete: http://127.0.0.1:8000/api/suppliers/:supplier


