Esse repositório Hospeda o código back_end desafio Worklab CRUD

Esses passos é necessário que o usuário tenhas seguintes ferramentas para gerenciar & executar os arquivos:
1. Servidor XAMP, WAMP ou semelhantes.
2. Banco de dados MY SQL WorkBanch.

Passos para executar o projeto:
1. Ir até -> C:\xampp\htdocs -> anexar dentro da pasta htdocs.

   ![image](https://github.com/Guilherme-Santt/CRUD-PHP-Sist.-Laboratorial/assets/133061692/c05caf50-0747-4154-a1a5-bca59e6dbc3f)

3. No phpmyadmin, Criar banco de dados "crud_clientes", importar o anexo de tabelas, disponível nos arquivos deste repositório(crud_clientes.sql)
   
   ![image](https://github.com/Guilherme-Santt/CRUD-PHP-Sist.-Laboratorial/assets/133061692/05676a16-5ccb-4068-97a4-9d64a1bf16b2)

5. Caso optar por outro nome no banco de dados no phpmyadmin, é necessário alterar o nome do mesmo na variavel $db_nome-> arquivo conexao.php, na pasta Arquivos PHP.
   
   ![image](https://github.com/Guilherme-Santt/CRUD-PHP-Sist.-Laboratorial/assets/133061692/ef68fd44-038c-454a-9388-1ecd2d90b7e5)


Após feito os pasos para acessar o index do arquivo, digitar URL http://localhost ou http://127.0.0.1/CRUD_Laboratório/Arquivos%20PHP/, com o servidor(xampp ou semelhante) online 

![image](https://github.com/Guilherme-Santt/CRUD-PHP-Sist.-Laboratorial/assets/133061692/cda7ee79-cd82-481b-82a9-ce63b7f4cb4d)

Login: admin@admin.com
senha: 123
Caso optar por criar um usuário, acessar http://127.0.0.1/CRUD_Laboratório/Arquivos%20PHP/usuario.php
Deixei a session comentada (sem verificação) para conseguir criar usuário, caso necessário.
