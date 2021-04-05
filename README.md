## Estrutura do Projeto

```
api
 └───
 └───app                        # App
      └───Console               # Contem arquivos de commands
      └───Excptions             # Contem os exceptions criados ao decorrer do projeto
      └───Http                  # Contem controllers, middlewares, requests e resources
           └───Controllers      # Responsável por fazer o controle de requisições
           └───Middleware       # Responsável por fazer o controle intermediario entre o client e o controller
           └───Requests         # Responsável por controlar e validar os dados recebidos em cada método do controller
           └───Resources        # Responsável por formatar os dados de retorno do método do controller
      └───Jobs                  # Serviços automatizados
      └───Models                # Entidades
      └───Providers             # Serviços de controle e configuração
      └───Respositories         # Camada responsável por acesso com o banco de dados
      └───Rules                 # Camada de validação de dados
      └───Services              # Camada responsável pela regra de negócio
 └───bootstrap                  # Contem arquivo de configuração de utilização de funcionalidades do projeto (middleware, eloquent e etc.)
 └───config                     # Contem arquivos de configuração do projeto (app, cache, cors, database e etc.)
 └───database                   # Contem as migrations, seeders e factories
 └───public                     # Public
 └───resources                  # Contem arquivos de "frontend" (css, js, views(blade) e etc)
 └───routes                     # Contem o arquivos que armazena os end-points
 └───storage                    # Storage
 └───tests                      # Contem os tests unitários e de integração do projeto.
       └───Feature              # Contem os testes de integração
       └───Unit                 # Contem os testes unitários.
 └───vendor                     # Vendor (contem bibliotecas necessárias para o projeto funcionar)
 └───.env.examplo               # Exemplo do arquivos de configuração de acesso a serviços
 └───.env.testing.examplo       # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───.gitignore                 # Arquivo de configuração para evitar commitar arquivos desnecessários
 └───composer.json              # Arquivo de configuração do projeto, definindo quais libs devem ser instaladas
 └───docker-compose.yml         # Arquivo de definição dos containers docker
 └───docker-entrypoint.sh       # Arquivo para execução dentro do container do php
 └───Dockerfile                 # Arquivo de definição dos serviços necessário para o container php
 └───LICENSE                    # Licensa do projeto (MIT)
 └───phpunit.xml                # Arquivo de configuração do phpunit.
 └───server.php                 # Server
 └───sonar-project.properties   # Arquivo de configuração do sonarqube.
 └───webpack.mix.js             # Webpack
```

### Stacks Utilizadas:

PHP 7.4.16

Laravel Framework 8.35.1

[RabbitMQ 3.8.14-management (imagem docker)](https://hub.docker.com/r/amd64/rabbitmq/)

[MySQL 5.7 (imagem docker)](https://hub.docker.com/r/mysql/mysql-server/)

### Libs Utilizadas:

[validator-cpf-cnpj](https://packagist.org/packages/bissolli/validador-cpf-cnpj)

[laravel-queue-rabbitmq](https://github.com/vyuldashev/laravel-queue-rabbitmq)

### Preparando a base do projeto

Necessário primeiramente criar os .ENVs correspondente a aplicação e ao teste. Para isso é necessário executar esses dois comandos via terminal:

```bash
$ cp .env.example .env
```
```bash
$ cp .env.testing.example .env.testing
```

### Configuração .ENV

```
DB_CONNECTION=mysql
DB_HOST=[HOST] - Ex: 192.168.1.111
DB_PORT=3306
DB_DATABASE=[name_bd]
DB_USERNAME=[name_user]
DB_PASSWORD=[password]

RABBITMQ_HOST=[HOST] - Ex: 192.168.1.111
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/

EXTERNAL_AUTORIZATOR_SERVICE=https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6
EXTERNAL_NOTIFICATION_SERVICE=https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04
```

### Configuração .ENV.TESTING

```
DB_CONNECTION=sqlite

EXTERNAL_AUTORIZATOR_SERVICE=https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6
EXTERNAL_NOTIFICATION_SERVICE=https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04
```

Após criar o .ENVs, já é possível preparar o ambiente docker. Primeiramente iniciando o docker e após isso executando um dos seguintes comandos:

(Liberando o terminal após execução)
```bash
$ docker-compose up --build -d
```

(Sem liberar o terminal após execução)
```bash
$ docker-compose up --build
```

### Testes

Os testes foram feitos utilizados o banco de dados sqlite como base para as pesistências dos dados. É necessário executa-los localmente e para executar deve-se executar esse comando na raiz do projeto:

```bash
$ sh ./tests.sh
```
Esse comando automatiza a execução dos comandos `php artisan migrate --env=testing`, `php artisan tests --env=testing`, `php artisan migrate:rollback --env=testing`
. Correspontes a criar as tabelas, executar os testes e "deletar" as tabelas.

#### Retorno dos testes
```bash
$ sh tests.sh 
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (22.33ms)
Migrating: 2021_03_31_000705_wallet
Migrated:  2021_03_31_000705_wallet (7.45ms)
Migrating: 2021_04_01_194348_transaction
Migrated:  2021_04_01_194348_transaction (7.26ms)
Migrating: 2021_04_03_131645_notifications
Migrated:  2021_04_03_131645_notifications (6.60ms)
Warning: TTY mode is not supported on Windows platform.

   PASS  Tests\Unit\NotificationTest
  ✓ should create notification

   PASS  Tests\Unit\TransactionTest
  ✓ should external authorizing service
  ✓ not should validate requerid datas transaction payer shopkeeper
  ✓ not should validate requerid datas transaction can not transfer to yourself
  ✓ not should validate requerid datas transaction payer or payee invalid

   PASS  Tests\Unit\WalletTest
  ✓ should create wallet
  ✓ should updated wallet with debit value
  ✓ not should updated wallet with debit value wallet not found
  ✓ not should updated wallet with debit value because value equal zero
  ✓ should updated wallet with value
  ✓ not should updated wallet with value wallet not found
  ✓ not should updated wallet with value because value equal zero

   PASS  Tests\Feature\NotificationTest
  ✓ should return all notifications
  ✓ should return a notification
  ✓ not should return a notification

   PASS  Tests\Feature\TransactionTest
  ✓ should return all transactions    
  ✓ should return a transaction
  ✓ not should return a transaction
  ✓ a transaction should must be carried out
  ✓ a transaction not should must be carried out payer without balance
  ✓ a transaction not should must be carried out payer is shopkeeper
  ✓ should delete transaction
  ✓ not should delete transaction

   PASS  Tests\Feature\UserTest
  ✓ should return all users
  ✓ should return user
  ✓ not found user return
  ✓ should create user with wallet
  ✓ not should create user with wallet
  ✓ should update user
  ✓ not should update user
  ✓ should delete user
  ✓ not should delete user

   PASS  Tests\Feature\WalletTest
  ✓ should return all wallets
  ✓ should return wallet
  ✓ not found wallet return
  ✓ should delete wallet
  ✓ not should delete wallet

  Tests:  37 passed
  Time:   5.92s

Rolling back: 2021_04_03_131645_notifications
Rolled back:  2021_04_03_131645_notifications (12.91ms)
Rolling back: 2021_04_01_194348_transaction
Rolled back:  2021_04_01_194348_transaction (7.40ms)
Rolling back: 2021_03_31_000705_wallet
Rolled back:  2021_03_31_000705_wallet (7.55ms)
Rolling back: 2014_10_12_000000_create_users_table
Rolled back:  2014_10_12_000000_create_users_table (7.47ms)
```
### Diagrama Entidade Relacional

As tabelas e suas relações correspondem a esse DER
![image](https://user-images.githubusercontent.com/17796246/113519119-aa360c80-9560-11eb-9311-06de69d974c8.png)

### EndPoints

A API possui end-point para serviços de todas as suas entidades! Para vizualiza-los [clique aqui](https://documenter.getpostman.com/view/7148072/TzCQaRU2#8f82b651-52b0-43f7-b1d8-e2f3b323990f)