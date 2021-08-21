# desafio_vesti_alvaro_campos_merlotto
<p> Desafio técnico para a elaboração de uma API de cadastro de confecções pelo framework Laravel 8, no ambiente de desenvolvimento Docker(Laradock), pelo servidor web Nginx com autenticação feita com Sanctum através do Laravel Jetstream e Livewire.</p>

## Execução
<p>Primeiramente, copie o arquivo ".env.example" e em sua cópia faça a seguinte configuração na área do MySQL:</p>

DB_CONNECTION=mysql<br>
DB_HOST=mysql<br>
DB_PORT=3306<br>
DB_DATABASE=desafio_vesti_alvaro_campos_merlotto<br>
DB_USERNAME=root<br>
DB_PASSWORD=root<br>

<p>Na pasta raíz do projeto, clone o repositório Laradock:</p>
    > git@github.com:laradock/laradock.git

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


## Postman
Host: localhost:80/api

No Postman, crie uma variável chamada "AccessToken", mas sem valor

### Na request de login
Na aba Headers, insira em "Autorization" em "KEY" e "Bearer (tokenGeradoAoLogar)" em "VALUE"

### Nas requests
Na aba Autorization, selecione "Bearer Token" no tipo e insira {{AccessToken}} no campo de token.

Na aba "Tests" insira os comandos abaixo para que o token gerado com o login seja atribuído à variável criada acima:
var jsonData = pm.response.json();
pm.environment.set("AccessToken", jsonData.access_token);

## Registros de operações
Os registros das operações deste sistema, inclusive os relacionados a login/logout estão sendo salvos em "/storage/logs/logs_loja.log" e o recurso utilizado para isto é o Monolog, do próprio Laravel
