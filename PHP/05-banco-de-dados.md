# Camada 5: Banco de Dados

**Foco:** persistência correta, segura e performática. Em competição, SQL e modelagem pesam muito.

## 1. SQL
- [ ] `SELECT`, `WHERE`, `ORDER BY`, `LIMIT/OFFSET`, `DISTINCT`
- [ ] `JOIN` (INNER, LEFT, RIGHT), auto-join, N:N
- [ ] `GROUP BY`, `HAVING`, agregações
- [ ] Subqueries, CTEs, `UNION`
- [ ] `INSERT`, `UPDATE`, `DELETE`, `UPSERT`
- [ ] Índices, `EXPLAIN`, quando o banco **não** usa o índice
- [ ] Funções de data/string, `NULL` e lógica de três valores

## 2. Modelagem
- [ ] Entidade-relacionamento, cardinalidades, tabelas associativas
- [ ] Normalização (1FN, 2FN, 3FN) e quando desnormalizar
- [ ] Chaves primárias/estrangeiras, `ON DELETE`, constraints, `UNIQUE`
- [ ] Tipos de dados (dinheiro com `DECIMAL`, datas, texto, JSON)
- [ ] Soft delete, timestamps, auditoria

## 3. Transações e concorrência
- [ ] ACID, `BEGIN/COMMIT/ROLLBACK`
- [ ] Níveis de isolamento (noção), locks, deadlocks
- [ ] Idempotência e condições de corrida

## 4. PDO
- [ ] Conexão (DSN, charset `utf8mb4`), `ERRMODE_EXCEPTION`
- [ ] **Prepared statements** (`?` e nomeados), `bindValue`, **sempre**
- [ ] Modos de fetch (`FETCH_ASSOC`, `FETCH_CLASS`)
- [ ] Transações com PDO, `lastInsertId`
- [ ] Limitações: não parametriza nomes de tabela/coluna (whitelist)
- [ ] Conexões persistentes (cuidados)

## 5. Migrations e seeds
- [ ] Versionar o schema, aplicar e reverter, ambientes
- [ ] Seeds e dados de teste
- [ ] Ferramentas: Phinx, Doctrine Migrations, Laravel Migrations

## 6. ORM e query builders
- [ ] **Active Record** (Eloquent) vs **Data Mapper** (Doctrine)
- [ ] Relacionamentos, *eager* vs *lazy loading*, **problema N+1**
- [ ] Quando o ORM atrapalha e SQL cru é melhor
- [ ] Construir um mini query builder/ORM para entender

## 7. Outros
- [ ] MySQL/MariaDB vs PostgreSQL vs SQLite: diferenças práticas
- [ ] Redis (cache, sessão, filas), noções de NoSQL
- [ ] Backup, restore, dump, índices em produção

## Autoavaliação
1. Por que prepared statements impedem SQL injection?
2. Quando usar `LEFT JOIN` em vez de `INNER JOIN`?
3. O que é N+1 e como detectar?
4. Por que `utf8mb4` e não `utf8` no MySQL?
5. O que `EXPLAIN` mostra e como usar o resultado?

## Exercícios
- Modelar um sistema (ex.: biblioteca, loja) do diagrama às tabelas
- Escrever 20 consultas progressivas (de simples a CTE) sobre o mesmo schema
- Criar N+1 de propósito, medir e corrigir
- Implementar transferência entre contas com transação e simular falha
- Construir um mini query builder
