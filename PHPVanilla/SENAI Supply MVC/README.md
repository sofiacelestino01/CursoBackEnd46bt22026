# SENAI Supply MVC

## Instalação

1. Configure o PostgreSQL e crie o banco `senai_supply`.
2. Execute o arquivo `database.sql` nesse banco.
3. Copie `.env.example` para `.env` e configure a senha do PostgreSQL.
4. Execute `composer install`.
5. Execute `composer dump-autoload`.
6. Cadastre um usuário administrador usando uma senha gerada com `password_hash()`.

## Executar

php -S localhost:8000 -t public public/index.php

Abra http://localhost:8000/login

Não publique o arquivo `.env`.
