
## prova de conhecimentos

Comandos importantes:

    1) clonar projeto github
    2) criar/ajustar .ENV file de acordo com env.example do projeto
    3) acessar pasta onde o projeto está clonado via CMD
    4) validar arquivo docker-compose.yml presente no projeto
    5) acessando a pasta / do projeto clonado, rode: docker-compose -f docker-compose.yml up -d
    6) se tudo der sucesso, via docker desktop acesse o container / webserver (open terminal)
    7) composer install -vvv
    8) chmod -R 777 storage/
    9) php artisan migrate
    9) se migrate falhar, rodar comando: /sbin/ip route|awk '/default/ { print $3 }'
    10) substituir se migrate falhar o ip do virtual host no valor DB_HOST do .env

Variáveis do .env de valores únicos dentro do DOCKER 

    DB_HOST
    DB_PORT
    DB_DATABASE
    WEBSERVER_HOST_PORT
    DB_HOST_PORT

PS:. Atenção ao arquivo: docker-compose.yml para o campo "ports" estar com mesmos valores do .env
    