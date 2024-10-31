# 🛠️ Documentação API RevendaMais

Esta API foi construída usando **Laravel 11**, **PHP 8.2** e **MySQL 5.7**. Siga as instruções abaixo para configurar e executar o projeto em seu ambiente local. 🚀

Ambiente de desenvolvimento: **MacBook M1**

## 📋 Pré-requisitos

Antes de começar, você precisará ter o seguinte instalado em sua máquina:

- **Docker** 🐳
- **MySQL** (5.7 ou superior) 📦

## ⚙️ Configuração do Ambiente

Siga os passos abaixo para configurar o projeto:

1. **Clone o repositório:**

   `git clone https://github.com/gumaath/teste-dev-php.git`

2. **Navegue até o diretório do projeto:**

   `cd teste-dev-php`

3. **Crie um arquivo `.env`:**

   Copie o arquivo `.env.example` para `.env`:

   `cp .env.example .env`

4. **Configure as variáveis de ambiente no `.env`:**

   Adicione as configurações do banco de dados.

   ```
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
   
   Adicione a variável da documentação do swagger.

   ```
   L5_SWAGGER_CONST_HOST=http://localhost/api/
   ```

5. **Inicie o Docker:**

   Execute o seguinte comando para construir e iniciar os contêineres:

   `docker-compose up --build`
   
   Execute o seguinte comando dentro do container web do docker:
   `php artisan db:migrate --seed`
   
   Execute o seguinte para rodar os testes:
   `php artisan test`

   Isso iniciará o servidor (porta 3306) e os serviços necessários para o projeto.

## 🌐 Acessando a Aplicação

Após a inicialização, você pode acessar a aplicação no seguinte link:

- [http://localhost:8000](http://localhost:8000) 🌍

## 📖 Documentação da API

Para acessar a documentação da API, visite:

- [Documentação da API](http://127.0.0.1:8000/api/documentation) 📚

🎊 **Espero que o teste supra as expectativas! Agradeço a oportunidade desde já** 🎊