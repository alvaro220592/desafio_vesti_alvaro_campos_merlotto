# desafio_vesti_alvaro_campos_merlotto
<p> Desafio técnico para a elaboração de uma API de cadastro de confecções pelo framework Laravel 8 no ambiente de desenvolvimento Docker(Laradock), pelo servidor web Nginx e autenticação feita com Sanctum através do Laravel Jetstream e Livewire.</p>

## Execução
- Primeiramente, copie o arquivo <strong>.env.example</strong> e em sua cópia faça a seguinte configuração na área do MySQL:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=desafio_vesti_alvaro_campos_merlotto
DB_USERNAME=root
DB_PASSWORD=root
```

- Pelo terminal, na pasta raíz do projeto, clone o repositório <strong>Laradock</strong> através do comando:<br>
```
git clone git@github.com:laradock/laradock.git
```

- Em <strong>/laradock</strong>, faça uma cópia do arquivo <strong>.env.example</strong> chamada <strong>.env</strong> e nela, faça as seguintes alterações:</p>
<strong>Versão do PHP:</strong> 7.4<br>
<strong>Versão do MySQL:</strong> 5.7<br>
<strong>Porta do MySQL:</strong> 3306(padrão)<br>
<strong>Porta do Nginx:</strong> 80(padrão)<br>
<strong>Banco de dados:</strong> desafio_vesti_alvaro_campos_merlotto<br>

- Ainda no diretório <strong>/laradock</strong>, insira o seguinte comando pelo terminal, para que a versão escolhida do PHP seja persistida:
```
docker-compose build php-fpm workspace
```

- Finalmente, execute as imagens:
```
docker-compose up -d nginx mysql
```

- Acesse o diretório raíz do projeto pelo workspace. Se estiver usando Windows é possível que tenha que inserir ```winpty``` no início do comando abaixo:
```
docker-compose exec workspace bash
```

- Dentro do workspace, atualize as dependências e em seguida, gere a chave de criptorgafia com os seguintes comandos:<br>
```
composer update
php artisan key:generate
```
 > <em>Obs: Sempre acesse o projeto pelo Workspace bash</em>

- Crie um usuário para fazer a autenticação. Há uma factory pronta e para executá-la, insira os seguintes comandos pelo workspace bash na pasta raíz do projeto:
```
php artisan tinker
\App\Models\User::factory()->create();
```

## Utilizando o Postman para as requisições
```
Url base: localhost:80/api
```

- Crie uma variável chamada "AccessToken", cujo valor será definido posteriormente

### Request de login
- Em body, insira um email e senha válidos ou os dados gerados pela factory acima para essa requisição do tipo POST pela url: `localhost:80/api/login`

### Nas demais requests
- Na aba <strong>Tests</strong> insira os comandos abaixo para que a variável <strong>AccessToken</strong>, criada acima, receba o valor do token gerado com o login:
```
var jsonData = pm.response.json();
pm.environment.set("AccessToken", jsonData.access_token);
```
<p>Isso poupará o trabalho de inserir <strong>Accept</strong> e <strong>application/json</strong> no </strong>Header</strong> a cada requisição feita.

- Com o usuário já autenticado, para cada requisição a ser feita, é necessário que na aba <strong>Autorization</strong>, você selecione "Bearer Token" no tipo e que insira <strong>{{AccessToken}}</strong> no campo de token para que a requisição em questão receba as credenciais do usuário.

## Registros de operações
Os registros das operações deste sistema, inclusive os relacionados a login/logout são salvos em "/storage/logs/logs_loja.log" e o recurso utilizado para isto é o Monolog, do próprio Laravel

## Documentação da API
https://documenter.getpostman.com/view/14434438/TzzDJEvU

