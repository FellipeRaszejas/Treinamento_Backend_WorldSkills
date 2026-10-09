# Camada 3: Rotas, Middleware e HTTP

**Foco:** como uma URL vira código executado, e tudo que acontece no caminho (middleware, validação, resposta).

## 1. Rotas
- [ ] `routes/web.php` (sessão, CSRF) vs `routes/api.php` (stateless, prefixo `/api`; criado via `install:api`)
- [ ] Verbos (`get`, `post`, `put`, `patch`, `delete`, `match`, `any`), `Route::view`, `redirect`
- [ ] Parâmetros, opcionais, restrições (`where`, `whereNumber`), `fallback`
- [ ] Nomes de rota e `route('nome')`, `url()`
- [ ] Grupos, prefixos, `name`, `middleware`, `controller`, `domain`
- [ ] `Route::resource` e `apiResource`, `only/except`
- [ ] **Route Model Binding** implícito (por tipo) e explícito; chaves customizadas; `withTrashed`
- [ ] `php artisan route:list`, `route:cache`
- [ ] **Por dentro:** rotas compiladas em regex (Symfony `RouteCompiler`), `RouteCollection`

## 2. Controllers
- [ ] Controllers de recurso, *invokable*, enxutos
- [ ] Injeção de dependência por construtor e por método
- [ ] Onde colocar lógica (Services/Actions) para não inflar o controller

## 3. Middleware
- [ ] **Conceito de pipeline/cebola:** passa por entrada → controller → saída
- [ ] `handle($request, Closure $next)`, antes e depois do `$next`, `terminate()`
- [ ] Global, de grupo (`web`, `api`) e de rota; aliases; parâmetros (`role:admin`)
- [ ] Onde configurar (`bootstrap/app.php` → `withMiddleware`)
- [ ] Middleware nativos: sessão, cookies, CSRF, `auth`, `throttle`, `SubstituteBindings`
- [ ] Ordem de execução e prioridade

## 4. Request
- [ ] `$request->input()`, `query()`, `only()`, `all()`, `file()`, `json()`, `user()`, `ip()`, `header()`
- [ ] `old()` e flash de sessão; `session()`
- [ ] `$request->validate([...])`
- [ ] **Form Requests** (`rules()`, `authorize()`, `messages()`, `prepareForValidation()`)
- [ ] Regras (`required`, `string`, `unique`, `exists`, `Rule::`), regras customizadas
- [ ] Erros de validação: redirect com `$errors` (web) vs **422 JSON** (API)

## 5. Response
- [ ] Retornos: string, array/JSON, view, `response()`, `redirect()`, `back()`
- [ ] Headers e cookies, `download`, `streamDownload`, `stream`
- [ ] `abort(404)`, `abort_if`, páginas de erro em `resources/views/errors`
- [ ] **Exceções:** `withExceptions`, `report` e `render`, exceções customizadas

## 6. Extras
- [ ] **Rate limiting** (`RateLimiter::for`, `throttle`)
- [ ] URLs assinadas, sessões e flash messages
- [ ] Redirecionamentos nomeados, `intended`
- [ ] Manutenção (`php artisan down`)

## Autoavaliação
1. O que acontece, em ordem, quando a requisição chega e há 3 middleware?
2. Como `Route::get('/users/{user}', ...)` com `User $user` encontra o modelo?
3. Diferença entre `validate()` e Form Request?
4. Por que formulários POST em `web.php` falham com 419 se faltar `@csrf`?
5. Por que rotas de API não usam sessão por padrão?

## Exercícios
- Escrever um middleware que mede e registra o tempo da requisição (usando `terminate`)
- Criar um middleware com parâmetro (`role:admin`)
- Implementar um CRUD com `Route::resource`, Form Requests e mensagens em português
- Criar uma regra de validação customizada
- Ler `Illuminate\Routing\Router` e `Illuminate\Pipeline\Pipeline`
