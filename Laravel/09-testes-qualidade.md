# Camada 9: Testes e Qualidade

**Foco:** garantir que o código funciona hoje e continua funcionando amanhã. No Laravel, testar é parte do fluxo normal.

## 1. Fundamentos
- [ ] Pirâmide: Unit, Feature (HTTP/integração), Browser/E2E
- [ ] **Pest** e/ou **PHPUnit** (o Laravel suporta ambos; confirme o padrão da sua versão)
- [ ] `php artisan test`, `--filter`, `--parallel`, `--coverage`
- [ ] `phpunit.xml`/`pest` config, ambiente de teste (`.env.testing`, SQLite em memória)

## 2. Testes de Feature (HTTP)
- [ ] `$this->get/post/put/delete`, `getJson/postJson`
- [ ] Asserções: `assertStatus`, `assertOk`, `assertRedirect`, `assertJson`, `assertJsonValidationErrors`, `assertSee`, `assertViewIs`
- [ ] `actingAs($user)`, `withHeaders`, `withoutMiddleware` (com cuidado)

## 3. Banco de dados
- [ ] `RefreshDatabase`, `LazilyRefreshDatabase`, `DatabaseTransactions`
- [ ] **Factories** (states, sequences, relações), seeders em testes
- [ ] `assertDatabaseHas/Missing/Count`, `assertSoftDeleted`

## 4. Fakes e mocks
- [ ] `Mail::fake`, `Queue::fake`, `Event::fake`, `Notification::fake`, `Storage::fake`, `Http::fake`, `Bus::fake`
- [ ] Mockery e `Facade::shouldReceive`
- [ ] Quando **não** mockar (preferir banco real em teste)

## 5. Testes de comportamento
- [ ] Autenticação e autorização (policies): usuário certo, usuário errado, visitante
- [ ] Validação: cada regra, mensagens, 422
- [ ] Jobs, listeners, comandos artisan (`artisan()->expectsOutput`)
- [ ] **Browser tests** (Dusk/Pest Browser/Playwright), noção

## 6. Qualidade de código
- [ ] **Laravel Pint** (estilo, baseado no PHP-CS-Fixer), `pint --test` no CI
- [ ] **Larastan/PHPStan** (níveis, baseline) com tipos dos modelos
- [ ] Rector (refatoração automática, noção)
- [ ] PSR-12, nomes claros, PHPDoc onde o tipo não basta
- [ ] `Model::shouldBeStrict()` em dev (lazy loading, atributos ausentes, mass assignment)

## 7. TDD e CI
- [ ] Red → green → refactor
- [ ] Pipeline: `composer install` → Pint → PHPStan → `php artisan test` → build do front
- [ ] GitHub Actions/GitLab CI; cobertura como indicador (não meta)

## Autoavaliação
1. Qual a diferença entre teste de Feature e Unit no Laravel?
2. Por que `RefreshDatabase` e SQLite em memória aceleram testes?
3. Quando usar `Mail::fake()` e o que ele garante?
4. O que o Larastan encontra que o PHP não encontra?

## Exercícios
- Escrever testes para um CRUD completo (sucesso, validação, não autorizado)
- Usar **TDD** para uma regra de negócio nova
- Cobrir fila, e-mail e evento com fakes
- Configurar Pint + Larastan + CI e quebrar o build de propósito
- Testar uma Policy com 3 tipos de usuário
