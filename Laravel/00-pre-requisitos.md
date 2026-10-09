# Camada 0: Pré-requisitos

**Foco:** garantir a base para que o Laravel não pareça mágica. Se algo aqui estiver fraco, volte ao mapa de PHP/back-end.

## 1. PHP moderno (o Laravel usa tudo isso)
- [ ] Tipos, `strict_types`, union/nullable, `readonly`, enums, `match`
- [ ] Classes, interfaces, traits, abstract, `static` vs `self`, late static binding
- [ ] **Closures**, arrow functions, callables (base de rotas, middleware, collections)
- [ ] **Métodos mágicos:** `__call`, `__callStatic`, `__get`, `__set`, `__invoke` (base de Facades e Eloquent)
- [ ] **Reflection API** (`ReflectionClass`, `ReflectionMethod`, `ReflectionNamedType`): base do autowiring
- [ ] Atributos (`#[...]`), generators, `array_reduce`, `array_map`
- [ ] Namespaces, `use`, nomes completamente qualificados, `::class`
- [ ] Exceções (`Throwable`, `Exception`, `Error`)

## 2. Composer e autoload
- [ ] `composer.json`, `composer.lock`, `require` vs `require-dev`, scripts
- [ ] **PSR-4:** `App\Models\User` → `app/Models/User.php`
- [ ] `composer dump-autoload`, `composer create-project`
- [ ] Case-sensitivity em Linux

## 3. HTTP
- [ ] Métodos, status codes, headers, cookies, corpo (form/JSON/multipart)
- [ ] Sessões, CORS, CSRF (conceito), cache HTTP
- [ ] Servidor web + PHP-FPM, front controller (`public/index.php`)

## 4. Banco de dados
- [ ] SQL sólido (`JOIN`, `GROUP BY`, índices), modelagem relacional
- [ ] PDO e prepared statements (o Laravel usa por baixo)
- [ ] Transações

## 5. Ferramentas
- [ ] **Ambiente:** Laravel Herd, **Laravel Sail** (Docker) ou Docker próprio
- [ ] Node e npm (o Vite roda no Node)
- [ ] Git, terminal, editor com Intelephense/PhpStorm
- [ ] Postman/Insomnia/curl

## Autoavaliação
1. O que acontece quando chamo um método estático que não existe, usando `__callStatic`?
2. Como `ReflectionClass` lê o construtor de uma classe?
3. Como `App\Http\Controllers\UserController` vira caminho de arquivo?
4. Qual a diferença entre `$_SESSION` do PHP e a sessão do Laravel (conceitualmente)?

## Exercícios
- Implementar um `__callStatic` que delega para uma instância (mini-Facade)
- Escrever uma função que lista os tipos dos parâmetros do construtor de qualquer classe (Reflection)
- Instalar o Laravel e rodar `php artisan about`
- Revisar o mapa de PHP: camadas 1 a 5 e 8
