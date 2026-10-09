# Camada 18: Regras de Negócio, Validação e CRUD Completo no Laravel

**Foco:** aplicar, **com as ferramentas do Laravel**, o que está em `16-regras-de-negocio-e-validacao.md` do mapa de PHP (leia aquele primeiro, é a teoria independente de framework). Nível: básico a avançado.

## 1. Mapa: regra → onde fica no Laravel
| Preciso garantir... | Ferramenta | Camada |
|---|---|---|
| Formato/tipo/tamanho | `rules()` do FormRequest | Entrada |
| Quem pode fazer | Policy/Gate (`authorize()`) | Entrada |
| Relação entre campos | Regras condicionais, `after()` do FormRequest | Entrada |
| Regra de negócio ("estoque suficiente") | Service/Action + exceção de domínio | Domínio |
| Unicidade/integridade real | `unique` na migration, FK, `CHECK` | Banco |
| Operação atômica | `DB::transaction` | Domínio |
| Consistência sob concorrência | `lockForUpdate`, update atômico, `version` | Domínio/banco |
| Efeito após salvar (e-mail, job) | Eventos/jobs com `afterCommit` | Domínio |

## 2. Validação em profundidade (Laravel)
- [ ] **Regras básicas:** `required`, `nullable`, `string`, `integer`, `numeric`, `email`, `min/max/between`, `in`, `confirmed`, `date`, `after`, `regex`, `file`, `image`, `mimes`
- [ ] **Condicionais:** `required_if`, `required_with`, `required_without`, `prohibited_if`, `sometimes`, `exclude_if`, `Rule::when()`, `Rule::requiredIf()`
- [ ] **Arrays e aninhados:** `items.*.qty`, `items` com `array|min:1`, validação de objetos aninhados
- [ ] **Rule objects:** `Rule::unique('users','email')->ignore($id)`, `Rule::exists(...)->where(...)`, `Rule::in`, `Rule::enum(Status::class)`, `Rule::dimensions`, `Password::min(8)->mixedCase()->uncompromised()`
- [ ] **Regras customizadas:** `make:rule`, closures de regra, mensagens traduzidas
- [ ] **Hooks do FormRequest:** `prepareForValidation()` (normalizar entrada), `after()`/`withValidator()` (regras entre campos), `passedValidation()`, `failedValidation()`
- [ ] **Dados validados:** `$request->validated()`, `safe()->only/except`, **nunca `all()`**
- [ ] **Mensagens e atributos:** `messages()`, `attributes()`, arquivos em `lang/`
- [ ] **Resposta de erro:** redirect com `$errors` (web) vs **422 JSON** (API); `stopOnFirstFailure`; bags de erro nomeados
- [ ] `Validator::make()` fora de requests (jobs, comandos, importações)

## 3. Regras de negócio no Service/Action
- [ ] Estrutura: `app/Services` ou `app/Actions` (uma ação por classe, método `handle`/`execute`)
- [ ] Recebe dados validados/DTO/models, **não** `Request`
- [ ] **Exceções de domínio** (`InsufficientStockException`) e como o Laravel as converte em resposta:
  - [ ] `render()`/`report()` na própria exceção, ou
  - [ ] `->withExceptions(...)` em `bootstrap/app.php` (renderizar 409/422 em JSON)
- [ ] **Máquina de estados** com `enum` + método `canTransitionTo()`; atualizar estado só via método do Service
- [ ] **Value Objects** e **casts customizados** (`Casts\Attribute`, `CastsAttributes`) para `Money`, `Email`
- [ ] **Dinheiro:** inteiros em centavos no banco; evitar `float`; helpers `Number`; arredondamento por regra
- [ ] **Datas:** `Carbon`/`CarbonImmutable`, UTC no banco, `app.timezone`, `startOfDay/endOfDay`
- [ ] Eventos de domínio (`OrderPaid`) disparados **após o commit**

## 4. Transações e concorrência no Laravel
- [ ] `DB::transaction(fn() => ..., attempts: 3)` (retry em deadlock)
- [ ] `lockForUpdate()` e `sharedLock()` dentro de transação
- [ ] **Update atômico:** `Product::where('id',$id)->where('stock','>=',$qty)->decrement('stock',$qty)` e checar linhas afetadas
- [ ] **Concorrência otimista:** coluna `version`, `where('version',$v)`, conflito → 409
- [ ] **Unicidade real:** índice `UNIQUE` + capturar `UniqueConstraintViolationException`
- [ ] **Idempotência:** chave de idempotência em tabela com `UNIQUE`; `firstOrCreate`/`upsert`
- [ ] **`afterCommit`:** em jobs, listeners, eventos e notificações (`ShouldDispatchAfterCommit`/`$afterCommit`; confirme na doc da sua versão)
- [ ] **Locks de aplicação:** `Cache::lock()` para seções críticas; `ShouldBeUnique` em jobs

## 5. CRUD completo no Laravel (checklist por operação)
**Index (listar)**
- [ ] `paginate()`/`cursorPaginate()`, filtros opcionais, busca, ordenação **com whitelist de colunas**
- [ ] `with()` para evitar N+1, `select` só dos campos necessários
- [ ] Resource/Blade/Inertia; query string preservada (`withQueryString()`)

**Show**
- [ ] Route model binding, `authorize('view')`, `load()` de relações, 404 correto

**Store**
- [ ] FormRequest, Policy, Service, transação, `201 Created` + `Location` (API) ou redirect + flash (web)
- [ ] Impedir duplicidade (constraint + tratamento de exceção)

**Update**
- [ ] `PUT` vs `PATCH` (`sometimes`), `unique` com `ignore`, checagem de estado permitido, concorrência otimista

**Destroy**
- [ ] `SoftDeletes`, `restore`, `forceDelete`, regras de cascata, impedir exclusão com dependências, `204 No Content`

**Extras**
- [ ] Operações em lote, importação/exportação CSV (com validação linha a linha), upload (`Storage`, validação de MIME, nome aleatório)
- [ ] Sincronizar N:N (`sync`, `syncWithoutDetaching`, pivô com atributos)
- [ ] Auditoria (observers/eventos ou pacote), `created_by/updated_by`
- [ ] Autorização em **todas** as ações (`Gate::authorize` / `authorizeResource` / FormRequest)

## 6. Testes das regras (Pest/PHPUnit)
- [ ] Um teste por regra: sucesso e violação
- [ ] **Valores-limite** (0, máximo, exatamente no limite)
- [ ] 422 (validação), 403 (policy), 409 (conflito de estado/concorrência), 401 (visitante)
- [ ] Transições de estado permitidas e proibidas
- [ ] `assertDatabaseHas/Missing`, `Event::fake`, `Queue::fake`
- [ ] Teste de concorrência (dois processos/`Concurrency`; confirme na doc) para regras críticas

## Autoavaliação
1. Quando uma regra vai no FormRequest e quando no Service?
2. Como garantir unicidade mesmo com dois cadastros simultâneos?
3. Como impedir vender estoque que não existe com muitos pedidos ao mesmo tempo?
4. Como transformar uma exceção de domínio em resposta 409 padronizada?
5. Por que e-mails e jobs devem rodar `afterCommit`?
6. Por que ordenar por coluna vinda da requisição exige whitelist?

## Exercícios
- Sistema de pedidos com estados (`rascunho → pago → enviado → cancelado`), estoque e cancelamento, com Service, exceções de domínio, transações e testes
- Reproduzir a venda duplicada do último item e corrigir com update atômico e com `lockForUpdate`
- Implementar concorrência otimista (`version`) e responder 409
- CRUD com filtros, ordenação segura, paginação, soft delete, restore e auditoria
- Importação de CSV com validação linha a linha e relatório de erros
- Escrever a **tabela de regras** do seu projeto (regra → onde é garantida → teste)
