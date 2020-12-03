# Simple Api Rest using Symfony 5, FOSRestBundle and secured with OAuthServerBundle

## Install dependencies

```bash
  composer install
```

## Launch the php server and the mysql and phpmyadmin containers

```bash
  symfony serve -d --no-tls
  docker-compose up -d
```
**Note: -d for mode detach, -d --no-tls for disable TLS encryption**

## Configure and setup database

Create file ".env.local" and inform the DATABASE_URL (check the docker-compose file)

**Example:** DATABASE_URL=mysql://root:**db_password**@127.0.0.1:6603/**db_name**

Create the database and lauch the migrations

```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
```

## Create user with console commands

```bash
  php bin/console user:create "my_email@gmail.com" "my_password"
```
## Create client with postman

Use the endpoint: POST /client

**Note: Import the postman collection located in the docs folder**

## Authenticate with postman

Use the endpoint: POST /oauth/v2/token

The response return and acceess_token and refresh_token.
You must then use this bearer token in the authorization header for the other endpoints

**Note: Inform the client_id, client_secret previously generated and inform the username and password previously created **

