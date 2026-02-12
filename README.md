# Agenciafmd – Filament Redirects

Pacote de redirecionamentos (301 e 302) para o painel administrativo (Admix), com suporte a redirecionamentos exatos e wildcards.

## Requisitos

- PHP ^8.4
- Laravel ^12.0
- Filament ^4.0
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

## Ativando no painel Filament

Este pacote inclui um Plugin Filament que registra o `RedirectResource` automaticamente. Adicione o plugin na config do admix `config/filament-admix.php`:

```php
use Agenciafmd\Redirects\RedirectsPlugin;

return [
    'plugins' => [
        RedirectsPlugin::class,
    ],
];
```

Após isso, o menu "Redirecionamentos" aparecerá no painel, com as páginas de Listar, Criar e Editar.

### Middleware

Para que os redirecionamentos funcionem no frontend, você deve registrar o middleware no arquivo `bootstrap/app.php`:

```php
use Agenciafmd\Redirects\Http\Middleware\UseRedirectPackage;

->withMiddleware(function (Middleware $middleware) {
    $middleware->append(UseRedirectPackage::class);
})
```

Adicione o fallback ao fim de `routes/web.php`:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::fallback(static fn() => abort(404));
```

## Funcionalidades

### Tipos de Redirecionamento
- **301 (Permanente):** Indica que a página mudou permanentemente para um novo local.
- **302 (Temporário):** Indica que a página mudou temporariamente.

### Suporte a Wildcards
O pacote suporta o uso de `*` no campo "De" (from).
Por exemplo:
- Origem: `antigo-blog/*`
- Destino: `https://novo-site.com.br/blog`

Qualquer URL que comece com `antigo-blog/` será redirecionada.

## Auditoria

O `RedirectResource` inclui o relation manager `Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager`, exibindo o histórico de auditorias quando o pacote `tapp/filament-auditing` for utilizado pelo projeto via `filament-admix`.

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
