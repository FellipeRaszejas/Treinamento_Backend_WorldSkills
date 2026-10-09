# Camada 9: Qualidade e Testes

**Foco:** garantir que o código funciona, continua funcionando e é legível por outros.

## 1. Testes
- [ ] Pirâmide: unitário, integração, ponta a ponta
- [ ] **PHPUnit** (e/ou **Pest**): asserções, *data providers*, `setUp/tearDown`, exceções esperadas
- [ ] Mocks, stubs, spies e fakes (Mockery, PHPUnit mocks); quando **não** mockar
- [ ] Testes com banco: SQLite em memória, transações por teste, factories
- [ ] Testes de API/HTTP (requisições simuladas)
- [ ] **TDD** básico (red → green → refactor)
- [ ] Cobertura (Xdebug/PCOV) e o que ela não garante
- [ ] Testes de mutação (noção: Infection)

## 2. Análise estática
- [ ] **PHPStan** ou **Psalm**: níveis, baseline, tipos genéricos via docblock
- [ ] Declarações de tipo + `strict_types` como primeira linha de defesa
- [ ] **Rector** (refatoração automática, noção)

## 3. Estilo e padrão
- [ ] PSR-12 / PER Coding Style
- [ ] **PHP-CS-Fixer** ou **PHP_CodeSniffer**
- [ ] Nomes expressivos, funções pequenas, comentários que explicam *por quê*
- [ ] PHPDoc quando o tipo da linguagem não basta
- [ ] `.editorconfig`

## 4. Tratamento de erros e logs
- [ ] `set_error_handler`, `set_exception_handler`, `register_shutdown_function`
- [ ] Converter erros em exceções
- [ ] Páginas/respostas de erro amigáveis (sem vazar detalhes)
- [ ] **Monolog**: níveis (debug a emergency), canais, handlers, contexto estruturado
- [ ] O que logar (e o que **nunca** logar: senhas, tokens)

## 5. Git e fluxo
- [ ] `commit`, `branch`, `merge`, `rebase`, `stash`, `reset` vs `revert`, `cherry-pick`
- [ ] Resolver conflitos, `git bisect`, `.gitignore` (inclui `vendor/`, `.env`)
- [ ] Conventional Commits, Pull Requests, code review
- [ ] Mensagens de commit úteis

## 6. CI
- [ ] Pipeline: `composer install` → lint → PHPStan → testes → build
- [ ] GitHub Actions/GitLab CI, cache do Composer
- [ ] Bloquear merge se falhar

## Autoavaliação
1. Qual a diferença entre mock, stub e fake?
2. Por que cobertura de 100% não prova ausência de bugs?
3. O que o PHPStan encontra que o PHP não encontra?
4. Por que logar uma senha é grave, mesmo em debug?

## Exercícios
- Escrever testes unitários de uma classe de domínio via TDD
- Cobrir uma API com testes de integração e banco em memória
- Configurar PHPStan nível alto em um projeto e corrigir os apontamentos
- Montar um pipeline de CI com lint, análise e testes
- Fazer PR em um projeto próprio e revisá-lo como se fosse de outra pessoa
