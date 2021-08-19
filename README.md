# desafio_vesti_alvaro_campos_merlotto
Desafio técnico para a elaboração de uma API de cadastro de confecções pelo framework Laravel 8, no ambiente de desenvolvimento Docker(Laradock), pelo servidor web Nginx com autenticação feita com Sanctum através do Laravel Jetstream e Livewire.

# Execução
Na pasta raíz do projeto, clone o repositório Laradock:
git@github.com:laradock/laradock.git

Em /laradock, faça uma cópia do arquivo .env.example chamada ".env".
Faça as seguintes alterações:
Versão do PHP: 7.4
Versão do MySQL: 5.7
Porta do MySQL: 3306(padrão)
Porta do Nginx: 80(padrão)
Banco de dados: desafio_vesti_alvaro_campos_merlotto

Ainda no diretório /laradock, insira o comando pelo terminal:
docker-compose build php-fpm workspace

Assim a versão escolhida  do php será persistida

Finalmente, execute as imagens:
docker-compose up -d nginx mysql

Host: localhost:80
