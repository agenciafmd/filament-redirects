# Filament – Redirects

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/filament-redirects.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/filament-redirects)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Adiciona ao Admix o cadastro de redirecionamentos 301 e 302, com suporte a URLs exatas e wildcards, aplicados no site por um middleware.

## Requisitos

- PHP ^8.4
- Laravel ^12.0 | ^13.0
- Filament ^5.0
- agenciafmd/filament-admix v1.x-dev | dev-master

## Instalação

1. Instale o pacote via Composer:

```bash
composer require agenciafmd/filament-redirects
```

2. Execute as migrações:

```bash
php artisan migrate
```

3. Populando o banco com dados de testes

Adicione o seeder no `database/seeders/DatabaseSeeder.php`:

```php
use Agenciafmd\Redirects\Database\Seeders\RedirectSeeder;

$this->call([
    RedirectSeeder::class,
]);
```

Ou rode o seeder manualmente:

```bash
php artisan db:seed --class="Agenciafmd\Redirects\Database\Seeders\RedirectSeeder"
```

## Ativando no painel

Adicione o plugin na config do admix `config/filament-admix.php`:

```php
use Agenciafmd\Redirects\RedirectsPlugin;

return [
    'plugins' => [
        RedirectsPlugin::class,
    ],
];
```

Após isso, o menu **Redirecionamentos** aparecerá no painel, com as páginas de Listar, Criar e Editar.

## Configuração

Arquivo: `config/filament-redirects.php`

```php
return [
    'name' => 'Redirects',
    'navigation_group' => null,
    'navigation_sort' => 1000,
];
```

| Chave              | Padrão      | Descrição                                                     |
|--------------------|-------------|---------------------------------------------------------------|
| `name`             | `Redirects` | Nome do pacote.                                               |
| `navigation_group` | `null`      | Grupo do menu em que o Resource aparece (`null` = sem grupo). |
| `navigation_sort`  | `1000`      | Posição do item no menu.                                      |

Redirecionamentos na lixeira há mais de 30 dias são removidos pelo `model:prune`, agendado diariamente às 03h (minuto definido em `filament-admix.schedule.minutes`).

## Uso

### Middleware

Para que os redirecionamentos funcionem no site, registre o middleware em `bootstrap/app.php`:

```php
use Agenciafmd\Redirects\Http\Middleware\UseRedirectPackage;

->withMiddleware(function (Middleware $middleware) {
    $middleware->append(UseRedirectPackage::class);
})
```

E adicione o fallback ao fim de `routes/web.php`:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::fallback(static fn() => abort(404));
```

### Tipos de redirecionamento

- **Permanente (301):** a página mudou permanentemente para um novo local.
- **Temporário (302):** a página mudou temporariamente.

### Origem exata e wildcards

O campo "De" é comparado com o caminho da requisição, sem as barras do início e do fim. Primeiro é buscada a origem exata; se não houver, as origens terminadas em `*` são testadas como wildcard. Por exemplo:

- De: `antigo-blog/*`
- Para: `https://novo-site.com.br/blog`

Qualquer URL que comece com `antigo-blog/` será redirecionada.

### Cache

Os redirecionamentos ativos ficam em cache (chave `use-redirect-package`), que é limpo automaticamente ao salvar, excluir, restaurar ou remover definitivamente um redirecionamento.

## Permissões

O `RedirectResource` entra automaticamente no controle de permissões por Grupos do Admix. Usuários sem grupo são administradores e têm acesso total.

## Auditoria

O `RedirectResource` inclui o relation manager `Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager`, exibindo o histórico de auditorias do registro.

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
