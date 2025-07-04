# 📦 Backend - Gerador de CNAB

Este é o projeto backend do Gerador de CNAB, desenvolvido com **Laravel 12**, **PHP 8.2**, e utilizando **MySQL** como banco de dados, além de **RabbitMQ**, **Redis** e **Docker** com Laravel Sail.

---

## 🚀 Tecnologias

- PHP 8.2
- Laravel 12
- MySQL 8.0
- Redis
- RabbitMQ
- Laravel Sail
- JWT Auth (`php-open-source-saver/jwt-auth`)
- Spatie Permissions
- Laravel Excel (`maatwebsite/excel`)

---

## 📦 Instalação e Execução

### 1. Clonar o repositório

```bash
git clone <REPOSITORIO_URL>
cd nome-do-projeto
```

### 2. Copiar e configurar o .env

```bash
cp .env.example .env
```

Ajuste as variáveis conforme necessário.

### 3. Instalar as dependências

```bash
composer install
```

### 4. Subir os containers com Sail

```bash
./vendor/bin/sail up -d
```

### 5. Rodar as migrations com seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

## 🐳 Serviços no Docker

O projeto utiliza os seguintes serviços:

- Laravel App (porta 80)
- MySQL 8 (porta 3306)
- Redis (porta 6379)
- RabbitMQ + painel (portas 5672 e 15672)

O `docker-compose.yml` já está configurado para usar as imagens e volumes necessários.

## 📚 Bibliotecas utilizadas

### Produção

- `laravel/framework` ^12.0
- `maatwebsite/excel` ^3.1
- `php-open-source-saver/jwt-auth` ^2.8
- `spatie/laravel-permission` ^6.20
- `vladimir-yuldashev/laravel-queue-rabbitmq` ^14.2
- `laravel/sanctum` ^4.0

### Desenvolvimento

- `laravel/sail` ^1.43
- `laravel/pint` ^1.13
- `fakerphp/faker` ^1.23
- `phpunit/phpunit` ^11.5.3

## 🔐 Autenticação

O sistema usa **JWT** para autenticação via Sanctum e JWT Auth.

### Rotas públicas:

- `POST /login` - Realiza login (retorna token)
- `POST /logout` - Realiza logout (requer token)

### Rotas protegidas (auth:api)

- `GET /user` - Retorna usuário autenticado
- `GET /funds` - Lista de fundos

### CNAB

- `GET /cnab` - Lista os CNABs
- `GET /cnab/{processing}/download/{type}` - Download do arquivo (type: `excel` ou `cnab`)

### Área Admin (somente usuários com perfil ADMIN)

- `POST /admin/cnab/upload` - Upload de arquivos CNAB
- `apiResource /admin/users` - CRUD de usuários

## 📥 Exemplo de Requisição Autenticada

```http
POST /login
Content-Type: application/json

{
  "email": "usuario@teste.com",
  "password": "senha123"
}
```

Resposta:

```json
{
  "access_token": "eyJ0eXAiOiJK...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

Use o token retornado nas próximas requisições:

```http
Authorization: Bearer <access_token>
```



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---
