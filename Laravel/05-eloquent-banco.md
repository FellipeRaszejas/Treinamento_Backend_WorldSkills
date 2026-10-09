# Camada 5: Eloquent e Banco de Dados

**Foco:** persistência no Laravel, do schema ao SQL gerado. Entender o que o ORM faz por baixo evita lentidão e bugs.

## 1. Migrations
- [ ] `make:migration`, `Schema::create/table`, tipos de colunas, índices, chaves estrangeiras (`constrained`, `cascadeOnDelete`)
- [ ] `migrate`, `migrate:rollback`, `migrate:fresh --seed`, `migrate:status`
- [ ] Alterar tabelas com cuidado; migrations reversíveis; ordem
- [ ] Seeders e **factories**

## 2. Query Builder
- [ ] `DB::table()`, `select/where/orWhere/join/groupBy/orderBy/limit`
- [ ] **Por dentro:** o `Builder` acumula estado; a **Grammar** do driver compila em SQL + bindings
- [ ] `toSql()`, `dd()`, `DB::listen`, `DB::enableQueryLog`
- [ ] `DB::raw`, `whereRaw`: **perigo de SQL injection** se concatenar entrada
- [ ] Transações (`DB::transaction`), locks (`lockForUpdate`)

## 3. Eloquent
- [ ] Convenções: tabela, chave primária, timestamps, `$table`, `$primaryKey`
- [ ] CRUD: `create`, `find`, `findOrFail`, `firstOrCreate`, `updateOrCreate`, `save`, `delete`
- [ ] **Mass assignment:** `$fillable`/`$guarded` (e por que existe)
- [ ] **Casts** (`array`, `datetime`, `enum`, `encrypted`), accessors/mutators (`Attribute`)
- [ ] **Scopes** locais/globais, **soft deletes**, `withTrashed`
- [ ] **Observers** e eventos de modelo
- [ ] Coleções (`Collection`) vs `Builder`
- [ ] **A mágica:** `Model::__get/__set` (atributos e relações), `__call`/`__callStatic` → `Builder`

## 4. Relacionamentos
- [ ] `hasOne`, `hasMany`, `belongsTo`, `belongsToMany` (pivô), `hasManyThrough`
- [ ] Polimórficos (`morphTo`, `morphMany`)
- [ ] Tabela pivô e atributos extras (`withPivot`, `attach/sync/detach`)
- [ ] **Lazy vs eager loading** (`with()`, `load()`, `withCount`, `preventLazyLoading`)
- [ ] **Problema N+1**: como detectar e corrigir
- [ ] Consultas por relação (`whereHas`, `has`)

## 5. Paginação e grandes volumes
- [ ] `paginate`, `simplePaginate`, `cursorPaginate`
- [ ] `chunk`, `chunkById`, `lazy`, `cursor`

## 6. Performance e boas práticas
- [ ] Índices, `EXPLAIN`, evitar `select *` desnecessário
- [ ] Contagens e agregações no banco, não em PHP
- [ ] Quando usar SQL cru/Query Builder em vez de Eloquent
- [ ] Repository/Service: quando vale e quando é exagero no Laravel

## 7. Outros bancos e armazenamento
- [ ] MySQL/MariaDB, PostgreSQL, SQLite; configuração em `config/database.php`
- [ ] Redis (cache, sessão, filas)

## Autoavaliação
1. Como o Laravel transforma `User::where('age', '>', 18)->get()` em SQL?
2. Por que `User::create($request->all())` pode ser grave sem `$fillable`?
3. O que é N+1 e como `with()` resolve?
4. Diferença entre `belongsTo` e `hasOne`?
5. `firstOrCreate` vs `updateOrCreate`?

## Exercícios
- Modelar um sistema real (ex.: loja, biblioteca) com migrations, factories e seeders
- Criar N+1 de propósito, medir com `DB::listen` e corrigir com `with()`
- Ativar `Model::preventLazyLoading()` em ambiente local
- Imprimir o SQL de 10 consultas Eloquent com `toSql()`
- Ler `Illuminate\Database\Query\Grammars\Grammar` e `Eloquent\Model::__call`
