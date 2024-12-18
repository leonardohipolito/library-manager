<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Gerenciador de Biblioteca

Sistema simples de gerenciamento de biblioteca:

## Setup

- Clone o repositório
- Rode o comando `composer install`
- Rode o comando `cp .env.example .env`
- Rode o comando `php artisan key:generate`
- Crie um banco de dados e configure no arquivo `.env` ou deixe como está para usar o sqlite
- Rode o comando `php artisan migrate:fresh --seed` para criar as tabelas e popular o banco de dados
- Instale as dependências do frontend com `npm install && npm run build`
- Rode a aplicação com o comando `php artisan serve`

**Login padrão**:
- email: test@example.com
- senha: password

Para atualizar automaticamente os status dos emprestimos para atrasados basta rodar o comando `php artisan check:overdue` no terminal

## Testes

Os testes do sistema foram desenvolvidos com PestPHP, para rodar os testes basta executar o comando 
`php artisan test`
