# Mapa de Estudo: Como o Laravel Funciona Por Dentro

Objetivo: entender o Laravel **da mesma forma que a máquina o entende**, para corrigir erros com precisão, projetar aplicações bem estruturadas e competir na WorldSkills (Web Technologies).

> Este README é o mapa geral. Cada camada tem seu arquivo `.md` com foco detalhado, checklist, autoavaliação e exercícios.
>
> **Pré-requisito:** o mapa de PHP/back-end (principalmente as camadas 1, 2, 3, 4, 5 e 8). Laravel é PHP: se algo da linguagem, de HTTP ou de SQL estiver fraco, volte lá primeiro.

## Versões (confirme na documentação oficial)

- **Laravel 13** é a versão major atual (lançada em março de 2026) e exige **PHP 8.3 ou superior**.
- **Laravel 12** continua com suporte por um tempo (PHP 8.2+); muitos projetos e tutoriais ainda usam 11 e 12.
- Estrutura "enxuta" (desde o Laravel 11): sem `app/Http/Kernel.php` por padrão; middleware, rotas e exceções configurados em `bootstrap/app.php`; providers em `bootstrap/providers.php`; arquivos de config publicados sob demanda.
- Antes de estudar um detalhe de versão, confira em **laravel.com/docs** a versão que você usa, e o Technical Description da WorldSkills sobre qual versão/ferramentas são permitidas.

## Índice das camadas

| # | Arquivo | Tema |
|---|---|---|
| 0 | [00-pre-requisitos.md](00-pre-requisitos.md) | PHP moderno, Composer, HTTP, SQL, ferramentas |
| 1 | [01-estrutura-ciclo-de-vida.md](01-estrutura-ciclo-de-vida.md) | Pastas, `artisan`, `.env`, ciclo de vida da requisição |
| 2 | [02-container-providers-facades.md](02-container-providers-facades.md) | Service Container, Service Providers, Facades por dentro |
| 3 | [03-rotas-middleware-http.md](03-rotas-middleware-http.md) | Rotas, middleware, requests, validação, responses |
| 4 | [04-blade-e-frontend.md](04-blade-e-frontend.md) | Blade (compilador), componentes, Vite, Livewire, Inertia |
| 5 | [05-eloquent-banco.md](05-eloquent-banco.md) | Migrations, Eloquent, query builder, relacionamentos |
| 6 | [06-autenticacao-autorizacao.md](06-autenticacao-autorizacao.md) | Guards, sessão, Sanctum, gates, policies |
| 7 | [07-apis.md](07-apis.md) | API Resources, versionamento, erros, documentação |
| 8 | [08-recursos-ecossistema.md](08-recursos-ecossistema.md) | Filas, eventos, mail, scheduler, cache, storage |
| 9 | [09-testes-qualidade.md](09-testes-qualidade.md) | Pest/PHPUnit, feature tests, factories, Pint, Larastan |
| 10 | [10-seguranca.md](10-seguranca.md) | Proteções nativas, CSRF, mass assignment, IDOR, uploads |
| 11 | [11-depuracao.md](11-depuracao.md) | Depurar como a máquina lê (sintoma → quem falhou) |
| 12 | [12-performance-deploy.md](12-performance-deploy.md) | Caches do `artisan`, Octane, filas, Docker, deploy |
| 13 | [13-integracao-react-vite.md](13-integracao-react-vite.md) | Laravel + React/Vite: Inertia, Sanctum SPA, CORS |
| 14 | [14-laravel-por-dentro.md](14-laravel-por-dentro.md) | Ler o código-fonte e construir um mini-Laravel |
| 15 | [15-worldskills.md](15-worldskills.md) | Competição, tempo, simulados |
| 16 | [16-complementos.md](16-complementos.md) | Ecossistema, upgrades, hábitos, comparações |
| 17 | [17-fluxo-crud-migration-request-policy-service.md](17-fluxo-crud-migration-request-policy-service.md) | Migration + FormRequest + Policy + Service no mesmo fluxo |
| 18 | [18-regras-de-negocio-validacao-crud-laravel.md](18-regras-de-negocio-validacao-crud-laravel.md) | Validação avançada, regras de negócio, concorrência, CRUD completo |

---

## Um esclarecimento que organiza tudo

Laravel **não é uma linguagem nem um servidor**: é um framework em PHP, montado a partir de componentes (`Illuminate\*`) e de peças do Symfony (HttpFoundation, Routing, Console, etc.). Quase tudo que parece mágica é **PHP comum** (reflexão, métodos mágicos, closures, `array_reduce`).

Uma requisição passa por várias máquinas, e o Laravel é só uma delas:

| Máquina | Papel |
|---|---|
| **Navegador / cliente** | Monta a requisição HTTP |
| **Servidor web + PHP-FPM** | Entrega a requisição ao `public/index.php` |
| **Zend Engine + Composer autoload** | Compila e carrega o código |
| **Laravel** (container, kernel, router, middleware, controller) | Decide o que executar e monta a resposta |
| **Banco, cache, filas, storage** | Persistência e serviços externos |

Ao corrigir um erro, a primeira pergunta é: **em qual máquina ele aconteceu?** (Um 502 é servidor/FPM; "Class not found" costuma ser autoload; "Target class does not exist" é container/namespace; 419 é CSRF/sessão.)

### O "lexer/parser" do Laravel: ciclo de vida da requisição

O Laravel não tem lexer próprio como o PHP, mas tem **pipelines equivalentes**, e entendê-los é o seu objetivo de "pensar como a máquina":

```
public/index.php
  → vendor/autoload.php (Composer)
  → bootstrap/app.php  (cria a Application = o Service Container)
  → providers registrados e inicializados (register → boot)
  → middleware globais
  → Router casa a rota (rota compilada em regex)
  → middleware da rota
  → Controller resolvido pelo container (autowiring por reflexão)
  → Response
  → middleware de saída → envio → terminate()
```

E outros "compiladores" internos:
- **Blade** → compilado para PHP e cacheado em `storage/framework/views`
- **Query Builder/Eloquent** → *Grammar* compila para SQL
- **Rotas** → compiladas em expressões regulares (e cacheáveis com `route:cache`)
- **Container** → lê tipos dos construtores via `ReflectionClass` e monta o grafo de dependências
- **Middleware** → pipeline "cebola" feito com `array_reduce` de closures

---

## Resumo por camada

### Camada 0: Pré-requisitos
- PHP moderno (tipos, enums, closures, traits, namespaces, atributos), Composer e PSR-4
- HTTP (verbos, status, headers, cookies, CORS), sessões
- SQL e modelagem relacional; Git; terminal e Docker (noções)
- Ferramentas: Herd/Sail/Docker, Node/npm (para o Vite)

### Camada 1: Estrutura e ciclo de vida
- Pastas: `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `tests/`, `vendor/`
- `artisan` (Symfony Console), `.env` e `config()`, ambientes, `php artisan about`
- Ciclo completo da requisição, HTTP Kernel / `bootstrap/app.php`, `terminate`
- Estrutura enxuta do Laravel 11+ (o que mudou, o que `install:api` e `config:publish` fazem)

### Camada 2: Container, Providers e Facades
- **Service Container:** `bind`, `singleton`, `scoped`, `instance`, **autowiring por reflexão**, binding contextual, tags, resolução de métodos
- **Service Providers:** `register` vs `boot`, ordem, deferred, descoberta de pacotes
- **Facades:** `__callStatic` → `getFacadeRoot()` → container; `Facade::fake()`; real-time facades
- **Contracts** (interfaces) e inversão de dependência
- `Macroable`, helpers (`app()`, `config()`, `request()`)

### Camada 3: Rotas, middleware e HTTP
- Rotas: verbos, parâmetros, nomes, grupos, prefixos, `route:list`, **route model binding**
- Controllers: resource, invokable, injeção de dependências
- **Middleware:** pipeline, ordem, grupos, parâmetros, `terminate`
- `Request`: input, arquivos, `validate()`, **Form Requests**, regras e mensagens
- Responses: view, JSON, redirect, download, streaming; `abort()`, tratamento de exceções
- Rate limiting, URLs assinadas

### Camada 4: Blade e front-end
- **Blade por dentro:** compilação para PHP, diretivas, `{{ }}` (escape) vs `{!! !!}`, cache de views
- Layouts, componentes (`<x-...>`), slots, componentes de classe e anônimos
- **Vite no Laravel:** `laravel-vite-plugin`, `@vite`, `public/build`, `manifest.json`
- **Livewire** (componentes reativos em PHP) e **Inertia** (Laravel + React/Vue sem API separada)
- Starter kits (React, Vue, Livewire) e como cada um funciona

### Camada 5: Eloquent e banco
- **Migrations**, seeders, factories; `migrate`, `rollback`, `fresh`
- **Query Builder** e Eloquent: *Grammar* compila para SQL; `toSql()`, query log
- Relacionamentos (1:1, 1:N, N:N, polimórficos, through), **eager loading** e **N+1**
- Casts, accessors/mutators, scopes, soft deletes, observers, eventos de modelo
- **Mass assignment** (`$fillable`/`$guarded`), transações, locks, paginação, chunking
- A "mágica": `Model::__get`, `__call`, `__callStatic` → `Builder`

### Camada 6: Autenticação e autorização
- Guards e providers, sessão e cookies, `Auth` facade, `Hash`
- **Starter kits**, Fortify, Breeze/Jetstream (conceitos), verificação de e-mail, reset de senha
- **Sanctum** (SPA com cookie e tokens de API), Passport (noção), Socialite (OAuth)
- **Gates e Policies**, `authorize`, `can`, roles/permissões (pacotes)
- Rate limiting de login, 2FA

### Camada 7: APIs
- `routes/api.php` e `install:api`; prefixo `/api`, `stateless`
- **API Resources** e coleções, paginação, filtros, versionamento
- Formato de erros padronizado e `withExceptions`; 422, 401, 403, 404
- Autenticação por token (Sanctum), CORS (`config/cors.php`), rate limits
- Documentação (OpenAPI/Scramble) e testes de API

### Camada 8: Recursos do ecossistema
- **Filas e jobs** (drivers, workers, retries, `failed_jobs`, batches, Horizon)
- **Eventos e listeners**, observers, **notifications**, **mail** (Mailables, Markdown)
- **Scheduler** (`routes/console.php`, cron), **cache** (Redis), **storage** (`public`, S3), `storage:link`
- **Collections**, helpers `Str`/`Arr`, HTTP Client, localização (i18n)
- Broadcasting (Reverb/Echo), Pulse, Telescope (noção)

### Camada 9: Testes e qualidade
- **Pest** e/ou PHPUnit; **Feature** vs **Unit**; testes HTTP e de banco (`RefreshDatabase`)
- Factories, `actingAs`, fakes (`Mail::fake`, `Queue::fake`, `Http::fake`, `Event::fake`)
- **Pint** (estilo), **Larastan/PHPStan** (análise estática), Rector (noção)
- TDD, cobertura, CI (GitHub Actions)

### Camada 10: Segurança
- O que o Laravel faz por você: prepared statements, escape no Blade, CSRF, hashing, criptografia (`APP_KEY`), cookies assinados/criptografados
- O que **você** precisa fazer: autorização (policies/IDOR), mass assignment, validação, uploads, `APP_DEBUG=false`, segredos
- XSS (`{!! !!}`), SQLi (`DB::raw`, `whereRaw`), CSRF em APIs, CORS, rate limiting
- Dependências (`composer audit`) e atualização de versões

### Camada 11: Depurar como a máquina lê
- Método, logs (`storage/logs`), Ignition, `dd`/`dump`, `tinker`, Telescope, Debugbar, `route:list`, `about`, query log
- Tabela sintoma → quem falhou:

| Sintoma | Quem falhou |
|---|---|
| `Class "X" not found` | Autoload/namespace (`composer dump-autoload`) |
| `Target class [X] does not exist` | Container / namespace de controller |
| `Unresolvable dependency` / `Target [Interface] is not instantiable` | Binding ausente no container |
| `419 Page Expired` | CSRF/sessão/cookie |
| `405 Method Not Allowed` | Verbo da rota |
| `404` em rota que existe | Route cache, model binding, prefixo, servidor |
| `MassAssignmentException` / campo não salva | `$fillable`/`$guarded` |
| `No application encryption key has been specified` | Falta `APP_KEY` (`key:generate`) |
| `SQLSTATE[...]` | Banco (migration não rodada, credenciais, constraint) |
| Config/`.env` "não muda" | `config:cache` ativo |
| Mudança em Blade não aparece | View cache |
| `Vite manifest not found` | Assets não compilados (`npm run build`/`dev`) |
| Upload/imagem 404 | Falta `storage:link` ou permissões |
| 500 após deploy | Permissões de `storage/` e `bootstrap/cache`, `APP_KEY`, `.env` |
| Job não executa | Worker parado, driver da fila, `failed_jobs` |
| CORS error | `config/cors.php`, middleware, origens |
| N+1 / lentidão | Falta de eager loading, índices |

### Camada 12: Performance e deploy
- `config:cache`, `route:cache`, `view:cache`, `event:cache`, `optimize` (e os cuidados)
- OPcache, **Octane** (Swoole/RoadRunner/FrankenPHP), Redis, eager loading, índices
- Filas e Horizon, scheduler no cron, Pulse/Telescope
- Deploy: Docker/Sail, Nginx + PHP-FPM, Forge/Cloud (noção), permissões, `migrate --force`, zero downtime, modo de manutenção
- `.env` em produção, `APP_DEBUG=false`, logs e monitoramento

### Camada 13: Integração com React/Vite
- **Inertia + React:** páginas React servidas por controllers Laravel, props, formulários, shared data
- **SPA separada:** Laravel como API + React (Vite); **Sanctum SPA** com cookie e CSRF, CORS
- `laravel-vite-plugin`, proxy do Vite, `VITE_*`
- Build de produção, `public/build`, Docker Compose

### Camada 14: Laravel por dentro
- Ler `Illuminate\Container`, `Foundation\Application`, `Routing\Router`, `Pipeline`, `Database\Query\Grammars`, `View\Compilers\BladeCompiler`
- Facades, `Macroable`, Collections, Eloquent `Model`
- **Construir um mini-Laravel** (container + router + pipeline + facade + Blade simples)

### Camada 15: WorldSkills
- Technical Description e Test Projects; **confirmar se Laravel é permitido/necessário** e qual versão
- Velocidade com `artisan make:*`, esqueleto próprio, gestão de tempo, simulados

### Camada 16: Complementos
- Ecossistema (Livewire, Inertia, Filament, Spatie), upgrades, ler docs, comparar com Symfony/Slim/Node

### Camada 17: Fluxo CRUD completo (Migration, FormRequest, Policy, Service)
- Papel de cada peça e onde atua no ciclo: Migration (schema) → FormRequest (autoriza + valida) → Policy (permissão) → Service (regra de negócio) → Eloquent
- **Service não é recurso do Laravel** (é um padrão); a doc oficial cobre Migration, FormRequest e Policy
- Ordem de construção, exemplo de referência, o que vai onde, pegadinhas (ex.: `Controller` base sem `AuthorizesRequests` no Laravel 11+)
- Método para estudar pela documentação oficial e checklist de domínio

### Camada 18: Regras de negócio, validação e CRUD completo no Laravel
- Mapa regra → ferramenta (FormRequest, Policy, Service, exceções de domínio, constraints)
- Validação avançada: condicionais, aninhada, Rule objects, regras customizadas, hooks do FormRequest
- Máquina de estados com enums, casts/Value Objects, dinheiro e datas
- Transações, `lockForUpdate`, update atômico, concorrência otimista, idempotência, `afterCommit`
- Checklist de CRUD completo (index/show/store/update/destroy + extras) e testes

---

## Trilha por nível (do básico ao avançado)

| Nível | Foco | Camadas/tópicos | Está pronto quando consegue... |
|---|---|---|---|
| **Básico** | Fluxo do framework e CRUD | 0, 1, 3 (rotas, controller, validação simples), 4 (Blade), 5 (migrations e CRUD Eloquent), 17 | Desenhar o ciclo da requisição e fazer um CRUD completo com FormRequest, Policy e Service |
| **Intermediário** | Domínio, APIs e ecossistema | 5 (relações, N+1), 6, 7, 8, 9, 10, 11, 18 | Modelar regras de negócio, proteger com policies, expor API, testar e depurar pela tabela de erros |
| **Avançado** | Funcionamento interno e produção | 2 (container, providers, facades), 12, 13, 14 (ler o framework e construir o mini-Laravel), concorrência da 18 | Explicar `Cache::get()` e `User::where()` sem dizer "mágica", rastrear erros até o código do framework e fazer deploy otimizado |

> Pré-requisito de todos os níveis: o mapa de PHP (`estudo-php-backend`), principalmente as camadas 2, 15 e 16.

## Ordem de estudo sugerida

1. **Camada 0:** garanta o PHP moderno e HTTP (revisar o mapa de PHP)
2. **Camada 1:** instalar, explorar pastas e **ler o ciclo de vida** passo a passo
3. **Camada 2:** container, providers e facades (a chave da "mágica")
4. **Camadas 3 e 5:** rotas/middleware/validação e Eloquent (primeiro CRUD completo)
5. **Camada 4:** Blade (e Vite)
6. **Camadas 6 e 10:** autenticação, autorização e segurança **juntas**
7. **Camada 7:** API completa
8. **Camadas 8 e 9:** filas, eventos, mail e **testes**
9. **Camada 11:** depuração guiada pela tabela
10. **Camadas 12 e 13:** performance, deploy e integração com React
11. **Camada 14:** ler o framework e construir o mini-Laravel (fixa tudo)
12. **Camada 15:** simulados repetidos

## Projetos práticos que fixam o conhecimento
- [ ] Desenhar (em papel) e **seguir com `dd()`** o ciclo completo de uma requisição
- [ ] Container de DI com autowiring (`ReflectionClass`) e depois comparar com o do Laravel
- [ ] **Pipeline de middleware** com `array_reduce`
- [ ] Blade simplificado (compilador por regex → PHP)
- [ ] **Mini-Laravel** (container + router + pipeline + facade + view)
- [ ] CRUD completo (Eloquent, validação, policies, testes em Pest)
- [ ] API REST com Sanctum, Resources, paginação e documentação
- [ ] Fila + e-mail + scheduler funcionando de ponta a ponta
- [ ] Laravel + React (Inertia) **e** Laravel API + React (SPA com Sanctum)
- [ ] Repositório com 15 bugs plantados (um por linha da tabela)
- [ ] Deploy em Docker (Nginx + PHP-FPM + banco), com caches do `artisan`

## Referências
- **laravel.com/docs** (versão que você usa) e **laravel-news.com**
- **Laracasts** (cursos), **Laravel Daily**, **Spatie** (docs de pacotes)
- Código-fonte: github.com/laravel/framework (`src/Illuminate/*`)
- **PHP: The Right Way**, php.net/manual, php-fig.org (PSRs)
- **Inertia:** inertiajs.com · **Livewire:** livewire.laravel.com
- **Pest:** pestphp.com
- **OWASP** Cheat Sheet Series (PHP/Laravel)
- **WorldSkills / SENAI:** Technical Description e Test Projects da sua competição

## Glossário rápido
- **Service Container:** registro que cria e resolve objetos (dependências) automaticamente
- **Service Provider:** classe que registra serviços (`register`) e os inicializa (`boot`)
- **Facade:** proxy estático que delega para um objeto do container
- **Contract:** interface de um serviço do framework
- **Middleware:** camada que intercepta a requisição/resposta em pipeline
- **Eloquent:** ORM Active Record do Laravel
- **Migration:** versionamento do schema em código
- **Artisan:** CLI do Laravel
- **Policy/Gate:** regras de autorização
- **Job/Queue:** tarefa assíncrona executada por um worker
- **Inertia:** ponte entre controllers Laravel e páginas React/Vue
- **Sanctum:** autenticação leve (cookie para SPA, tokens para API)
- **N+1:** uma consulta + N consultas extras desnecessárias

> Lembrete: Laravel muda de major todo ano. Confirme na documentação oficial a versão que você usa, e para a WorldSkills o Technical Description da sua edição prevalece sobre este mapa.
