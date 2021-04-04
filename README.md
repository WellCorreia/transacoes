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
 └───composer.json              # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───docker-compose.yml         # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───docker-entrypoint.sh       # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───Dockerfile                 # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───LICENSE                    # Licensa do projeto (MIT)
 └───phpunit.xml                # Arquivo de configuração do phpunit.
 └───server.php                 # Server
 └───sonar-project.properties   # Arquivo de configuração do sonarqube.
 └───webpack.mix.js             # Webpack
```

Packages:

[validator-cpf-cnpj](https://packagist.org/packages/bissolli/validador-cpf-cnpj)
