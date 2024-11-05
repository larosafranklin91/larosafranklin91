## Resposta ao Teste para Desenvolvedor PHP/Laravel

### Requisitos

- Docker

### Instalação do Projeto

1. Clone o repositório
2. Acesse a pasta do projeto
3. Rode o seguinte comando Docker para subir o projeto:
```bash
docker rm -f $(docker ps -a -q) && docker-compose up -d
```
Observação: o comando acima irá parar e remover todos os containers ativos, e em seguida subirá o container do projeto.

4. Acesse o container do projeto:
```bash
docker exec -it larabel.test bash
```

5. Rode o comando para instalar as dependências do projeto:
```bash
composer install
```

6. Rode o comando para criar a chave do projeto:
```bash
php artisan key:generate
```

7. Rode o comando para criar a estrutura do banco de dados e subir os dados de teste:
```bash
php artisan migrate --seed
```

8. Rode todos os testes do projeto:
```bash
php artisan test
```

9. Acesse o link da nossa coleção de requisições do Postman:
   https://documenter.getpostman.com/view/28757925/2sAY4yeLU7


### Observações
Para fins de produtividade, escolhi trabalhar com Laravel Sail, que já entrega um abiente de desenvolvimento adequado para trablahar com Laravel.
O banco de dados que fis uso durante o desenvolvimento foi o PostGres, mas nada impede que seja feito uso do sqlite, maria db ou mysql, visto que o laravel possui drivers que resolvem isso muito bem.
