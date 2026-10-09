# Mapa de Estudo: Como o PHP e o Back-end Funcionam Por Dentro

Objetivo: entender o back-end **da mesma forma que a máquina o entende**, para corrigir erros com precisão, projetar sistemas bem estruturados e competir na WorldSkills (Web Technologies).

> Este README é o mapa geral. Cada camada tem seu arquivo `.md` com foco detalhado, checklist, autoavaliação e exercícios.

## Índice das camadas

| # | Arquivo | Tema |
|---|---|---|
| 0 | [00-fundamentos-servidor.md](00-fundamentos-servidor.md) | Linux, HTTP, servidores web, CGI/FastCGI, SQL básico |
| 1 | [01-linguagem-php.md](01-linguagem-php.md) | Sintaxe, tipos, OOP, PHP 8.x moderno |
| 2 | [02-zend-engine.md](02-zend-engine.md) | Lexer, parser, AST, opcodes, Zend VM, OPcache, ciclo de requisição |
| 3 | [03-composer-ecossistema.md](03-composer-ecossistema.md) | Composer, autoload PSR-4, PSRs, pacotes |
| 4 | [04-http-em-php.md](04-http-em-php.md) | Request/response, sessões, cookies, roteamento, middleware |
| 5 | [05-banco-de-dados.md](05-banco-de-dados.md) | PDO, SQL, modelagem, transações, migrations |
| 6 | [06-arquitetura-padroes.md](06-arquitetura-padroes.md) | MVC, DI, SOLID, padrões, frameworks, mini-framework |
| 7 | [07-apis-rest-auth.md](07-apis-rest-auth.md) | REST, JSON, validação, autenticação, CORS, OpenAPI |
| 8 | [08-seguranca.md](08-seguranca.md) | OWASP, SQLi, XSS, CSRF, senhas, uploads, hardening |
| 9 | [09-qualidade-testes.md](09-qualidade-testes.md) | PHPUnit/Pest, PHPStan, padrões de código, logging, Git, CI |
| 10 | [10-depuracao.md](10-depuracao.md) | Depurar como a máquina lê (tabela sintoma → quem falhou) |
| 11 | [11-performance-deploy.md](11-performance-deploy.md) | OPcache, FPM, cache, profiling, Docker, Nginx, filas |
| 12 | [12-integracao-fullstack.md](12-integracao-fullstack.md) | Back-end ↔ React/Vite, CORS, proxy, Docker Compose |
| 13 | [13-worldskills.md](13-worldskills.md) | Competição, tempo, simulados |
| 14 | [14-complementos.md](14-complementos.md) | Lógica, engenharia de software, editor/terminal, inglês técnico |
| 15 | [15-como-o-computador-executa.md](15-como-o-computador-executa.md) | Bytes, memória, processos, arquivos, rede; `strace` |
| 16 | [16-regras-de-negocio-e-validacao.md](16-regras-de-negocio-e-validacao.md) | Regras de negócio, validação em níveis, CRUD completo, concorrência |

---

## Um esclarecimento que organiza tudo

PHP não é "o servidor" e o servidor não é o PHP. Uma requisição passa por **várias máquinas** em sequência:

| Máquina | Papel | Quando age |
|---|---|---|
| **Navegador / cliente HTTP** | Monta e envia a requisição | Início |
| **Servidor web** (Nginx, Apache, servidor embutido do PHP) | Recebe HTTP, serve estáticos, decide o que entregar ao PHP | Antes do PHP |
| **SAPI** (PHP-FPM, mod_php, CLI) | Ponte entre o servidor e o interpretador | Entre servidor e PHP |
| **Zend Engine** (lexer, parser, compilador, VM) + **OPcache** | Lê, compila e executa seu código | Execução do script |
| **Composer + autoloader** | Localiza e carrega classes sob demanda | Durante a execução |
| **Banco de dados / cache / filas** | Persistem e retornam dados | Durante a execução |
| **Sistema operacional** | Arquivos, permissões, processos, rede | Sempre |

Ao corrigir um erro, a primeira pergunta é: **em qual máquina ele aconteceu?** (um 502 não é um bug de PHP; um `Class not found` quase nunca é falha do servidor.)

### O pipeline que você já conhece, agora completo

```
Fonte .php → LEXER (re2c) → tokens → PARSER (Bison, LALR) → AST
           → COMPILADOR → opcodes → ZEND VM executa
           (OPcache guarda os opcodes em memória para não repetir o trabalho)
```

- Desde o PHP 7 existe uma **AST** explícita entre parser e compilador.
- O PHP segue o modelo **share-nothing**: a cada requisição o estado é criado e destruído (diferente de Node/Swoole, que mantêm o processo vivo).
- Você consegue **ver** esse pipeline: `token_get_all()`, a biblioteca `nikic/php-parser` (AST) e a extensão VLD ou `php -d opcache.opt_debug_level` (opcodes).

---

## Resumo por camada

### Camada 0: Fundamentos do servidor
- **Linux e terminal:** navegação, permissões e donos (`chmod`/`chown`), processos, pipes, `grep`, `tail -f`, `curl`, `ssh`
- **HTTP em profundidade:** métodos, status, headers, MIME, cache, cookies, CORS, corpo (form, JSON, multipart), HTTPS/TLS
- **Servidores web:** Nginx vs Apache; virtual hosts, `document root`, `try_files`, `.htaccess`, reescrita de URL
- **CGI → FastCGI → PHP-FPM:** como o servidor conversa com o PHP, pools de workers
- **SAPIs:** CLI, FPM, servidor embutido (`php -S`), `php.ini` e `php --ini`
- **SQL básico e rede:** DNS, portas, sockets, noções de TCP
- **Ambiente de dev:** PHP local, Docker, Composer, extensões

### Camada 1: Linguagem PHP (moderno, 8.x)
- **Base:** variáveis, tipos, coerção, comparação (`==` vs `===`, `<=>`, `??`, `?->`), strings, heredoc, funções, escopo, `static`, constantes
- **Arrays:** (na verdade tabelas hash ordenadas), funções de array, `array_map/filter/reduce`, destructuring, spread, cópia por valor
- **Tipos modernos:** declarações de tipo, `strict_types`, union/intersection types, `nullable`, `never`, `mixed`, `readonly`
- **OOP:** classes, interfaces, traits, abstract, `static` vs `self`, late static binding, visibilidade, magic methods (`__construct`, `__get`, `__call`, `__invoke`, `__toString`), imutabilidade
- **Recursos 8.x:** `match`, enums, constructor promotion, named arguments, attributes, first-class callable syntax, `readonly` classes, fibers (noção)
- **Funcional:** closures, `use`, arrow functions, callables, generators (`yield`)
- **Erros:** `Throwable`, `Exception` vs `Error`, `try/catch/finally`, exceções customizadas, níveis de erro, `error_reporting`
- **Utilidades:** `DateTimeImmutable` e timezones, PCRE (regex), `mbstring` e Unicode, JSON, SPL (estruturas e iteradores), filesystem, `include/require`
- **Armadilhas clássicas:** comparação frouxa, referências, `empty()/isset()`, `0 == "abc"`, ordem de avaliação
- **Confirme na doc oficial** o que mudou nas versões recentes do PHP.

### Camada 2: Zend Engine (seu "lexer/parser" do PHP)
- **Pipeline:** lexer (`token_get_all`), parser, AST, compilação, opcodes, execução
- **Zend VM:** instruções (opcodes), handlers, stack frames, operandos
- **Valores:** `zval`, tipos internos, **contagem de referências**, copy-on-write, coletor de ciclos (GC)
- **Memória:** gerenciador de memória do Zend, `memory_limit`, vazamentos em scripts longos
- **Ciclo de vida:** MINIT → RINIT → execução → RSHUTDOWN → MSHUTDOWN; share-nothing
- **OPcache:** cache de opcodes, `validate_timestamps`, preloading, invalidação no deploy
- **JIT:** o que faz, quando ajuda (e quando quase não ajuda em apps web típicas)
- **Extensões:** como PDO, mbstring, curl etc. se encaixam; `php -m`
- **Ferramentas:** `nikic/php-parser`, VLD/opcache debug, `phpdbg`, `php -r`
- **Ler código do PHP em C** (opcional, avançado): `Zend/zend_language_scanner.l`, `zend_language_parser.y`

### Camada 3: Composer e ecossistema
- **`composer.json` / `composer.lock`**, semver, `require` vs `require-dev`, `composer install` vs `update`
- **Autoload:** `spl_autoload_register`, **PSR-4**, classmap, `vendor/autoload.php`, o que acontece em `new Classe()`
- **PSRs:** 1 e 12 (estilo), 3 (logger), 4 (autoload), 7/17 (HTTP messages), 11 (container), 15 (middleware), 18 (client)
- Packagist, scripts do Composer, versionamento próprio, pacotes privados
- Pacotes essenciais: Monolog, Guzzle, Symfony components, vlucas/phpdotenv, Carbon, Twig/Blade
- **Supply chain:** `composer audit`, lockfile versionado, revisar dependências

### Camada 4: HTTP em PHP
- **Superglobais:** `$_GET`, `$_POST`, `$_SERVER`, `$_COOKIE`, `$_FILES`, `$_SESSION`; `php://input`
- **Resposta:** `header()`, `http_response_code()`, "headers already sent", output buffering
- **Sessões e cookies:** como funcionam, armazenamento, regeneração de id, flags de cookie
- **Uploads:** `$_FILES`, limites do `php.ini`, validação de MIME e destino
- **Front controller** (`index.php` único), reescrita de URL, **roteamento** (feito à mão e com bibliotecas)
- **Middleware**, PSR-7/PSR-15, pipeline request → resposta
- **Templates:** PHP puro, Twig, Blade; escape de saída
- **Formulários, redirects, flash messages, paginação, negociação de conteúdo**
- E-mail (SMTP, PHPMailer/Symfony Mailer), geração de PDF/CSV

### Camada 5: Banco de dados
- **SQL sólido:** `JOIN`, `GROUP BY`, subqueries, CTEs, índices, `EXPLAIN`, transações e níveis de isolamento
- **Modelagem:** relacional, normalização, chaves, integridade referencial, N:N
- **PDO:** conexão, **prepared statements**, modos de fetch, transações, tratamento de erros, charset
- **Migrations e seeds**, versionamento do schema
- **ORM e query builders:** Eloquent, Doctrine, conceitos (Active Record vs Data Mapper), **problema N+1**
- MySQL/MariaDB vs PostgreSQL vs SQLite; NoSQL e Redis (quando faz sentido)
- Concorrência, locks, soft delete, auditoria

### Camada 6: Arquitetura e padrões
- **MVC** e suas variações; front controller; separação de camadas
- **SOLID**, DRY, KISS, coesão e acoplamento
- **Injeção de dependência** e **container**; inversão de controle
- **Padrões:** Repository, Service, Factory, Strategy, Observer, Singleton (e seus problemas), Adapter, Decorator
- **Arquitetura:** camadas, Clean/Hexagonal, noções de DDD; DTOs e Value Objects
- **Eventos, filas e jobs**
- **Frameworks:** Laravel, Symfony, Slim; o que cada um resolve; ler o ciclo de vida de uma requisição no framework
- **Projeto-chave:** construir um **mini-framework** (router, container, request/response)

### Camada 7: APIs REST e autenticação
- **REST:** recursos, verbos, status corretos, idempotência, paginação, filtros, versionamento, HATEOAS (noção)
- **JSON:** entrada/saída, `json_encode/decode`, tratamento de erros, formato padronizado de erro
- **Validação** de entrada, sanitização e DTOs
- **Autenticação:** sessão vs **JWT**, refresh token, OAuth2 (noção); **autorização** (RBAC, policies)
- **CORS** no servidor, preflight, rate limiting, throttling
- **Documentação:** OpenAPI/Swagger; testar com curl, Postman, Insomnia
- Uploads e downloads via API, WebSocket/SSE (noções)

### Camada 8: Segurança
- **OWASP Top 10** aplicado a PHP
- **SQL Injection:** prepared statements sempre; nunca concatenar
- **XSS:** `htmlspecialchars` com contexto correto, CSP
- **CSRF:** tokens, `SameSite`
- **Senhas:** `password_hash` / `password_verify` (bcrypt/argon2), nunca MD5/SHA1
- **Sessões:** fixation, hijacking, `HttpOnly`, `Secure`, regeneração
- **Uploads:** validar tipo e conteúdo, nome aleatório, fora do document root
- **Path traversal, LFI/RFI, command injection** (`exec`, `shell_exec`), **desserialização insegura** (`unserialize`)
- **Autorização quebrada** (IDOR), validação só no front, exposição de dados
- **Segredos:** `.env` fora do repositório e do web root, `display_errors` desligado em produção
- **Hardening:** `php.ini` (`expose_php`, `disable_functions`, `open_basedir`), permissões, HTTPS, headers de segurança
- **Auditoria:** `composer audit`, atualização de dependências

### Camada 9: Qualidade e testes
- **Testes:** PHPUnit e/ou Pest; unitário, integração, e2e; mocks e stubs; testes de API e de banco; TDD
- **Análise estática:** PHPStan ou Psalm (níveis), tipos genéricos em docblocks
- **Estilo:** PSR-12, PHP-CS-Fixer ou PHP_CodeSniffer
- **Logging:** Monolog, níveis, logs estruturados
- **Tratamento de erros** global (`set_error_handler`, `set_exception_handler`), páginas de erro amigáveis
- **Git** e fluxo de trabalho: branches, rebase, bisect, PRs, Conventional Commits
- **CI:** rodar lint, análise estática e testes automaticamente

### Camada 10: Depurar como a máquina lê
- **Método:** ler tudo → classificar a máquina → reproduzir → hipótese → confirmar
- **Ferramentas:** logs (`error_log`, logs do PHP-FPM e do Nginx/Apache), `var_dump`/`dd`, **Xdebug** (breakpoints, step), `phpdbg`, `curl -v`, aba Network, `EXPLAIN`
- **Tabela sintoma → quem falhou:**

| Sintoma | Quem falhou |
|---|---|
| `Parse error: syntax error` | Lexer/parser do PHP (sintaxe) |
| `Fatal error: Uncaught Error` | Zend VM (erro de runtime) |
| `Class "X" not found` | Autoload / namespace / `composer dump-autoload` |
| Página em branco | Erro com `display_errors` off → ver o log |
| `Headers already sent` | Saída antes de `header()`/`session_start()` (BOM, espaço, `echo`) |
| `Undefined variable/index/array key` | Lógica / dados ausentes |
| `Allowed memory size exhausted` | Memória (`memory_limit`, loop, dataset grande) |
| `Maximum execution time exceeded` | Tempo (`max_execution_time`, consulta lenta) |
| `SQLSTATE[...]` / `PDOException` | Banco (SQL, credenciais, schema) |
| 404 do servidor (não do app) | Config do servidor (`try_files`, rewrite) |
| 403 Forbidden | Permissões de arquivo ou regra do servidor |
| 500 sem mensagem | Erro PHP oculto → log |
| 502 Bad Gateway / 504 | PHP-FPM parado, socket errado ou timeout |
| CORS error | Headers/preflight do back-end |
| Sessão "some" | Cookie, domínio, `session.save_path`, regeneração |
| Funciona local, quebra em produção | Versão do PHP, extensão ausente, `php.ini`, permissões, case de arquivo, `.env` |
| Upload falha | `upload_max_filesize`, `post_max_size`, permissão do destino |
| Mudança não aparece | OPcache ou cache do navegador/CDN |

### Camada 11: Performance e deploy
- **OPcache** configurado corretamente; preloading; JIT (avaliar)
- **PHP-FPM:** `pm`, `max_children`, dimensionamento por memória
- **Cache:** APCu, Redis, cache de queries/respostas, HTTP caching (`ETag`, `Cache-Control`)
- **Banco:** índices, N+1, paginação eficiente, `EXPLAIN`
- **Profiling:** Xdebug profiler, XHProf/Blackfire, medir antes de otimizar
- **Filas e jobs assíncronos**; cron
- **Deploy:** Nginx + FPM, Docker multi-stage, variáveis de ambiente, migrations no deploy, rollback, permissões
- **CI/CD**; HTTPS; monitoramento e logs em produção
- Servidores long-running (Swoole/RoadRunner/FrankenPHP) como noção

### Camada 12: Integração full-stack
- Back-end PHP + front React (Vite): portas diferentes, **proxy do Vite vs CORS**
- Contrato de API compartilhado (OpenAPI), tratamento de erros padronizado
- Autenticação ponta a ponta (cookie vs token), rotas protegidas
- **Docker Compose** (PHP-FPM + Nginx + banco + front)
- `.env` por ambiente, seeds, dados de teste
- Estados de UI correspondentes (loading, erro, vazio) e códigos HTTP

### Camada 13: WorldSkills
- Ler o **Technical Description** e os **Test Projects** anteriores; entender o **marking scheme**
- Módulos típicos: back-end, correção de bugs, integração, segurança básica, banco
- Código limpo, validação de requisitos, tratamento de erros e segurança como pontos de avaliação
- Gestão de tempo: ler tudo antes, priorizar por peso, funcionar primeiro, commits frequentes
- Simulados cronometrados, templates próprios (se as regras permitirem), caderno de bugs

### Camada 14: Complementos
- **Lógica e estruturas de dados:** arrays, mapas, filas, pilhas, recursão, complexidade
- **Engenharia de software:** clean code, refatoração, documentação (README, PHPDoc)
- **Editor e terminal:** VS Code/PhpStorm, depurador integrado, snippets, atalhos
- **Inglês técnico:** documentação, erros, enunciados
- **Outras linguagens/stack para comparar:** Node (Express), Laravel vs puro; entender o que é do PHP e o que é do framework

### Camada 15: Como o computador executa (novo)
- Dados em bytes: inteiros, **float (IEEE 754)**, strings como bytes, UTF-8, datas
- Memória: stack/heap, `zval`, refcount, copy-on-write, arrays como hash tables
- Processos: modelo do PHP-FPM, usuários, limites do SO
- Arquivos e rede: file descriptors, sockets, TCP, bytes do HTTP
- Observar a máquina: `strace`, `/proc`, `lsof`, `ss`, `xxd`

### Camada 16: Regras de negócio, validação e CRUD completo (novo)
- Regra de negócio vs regra técnica; **invariantes**
- Validação em 4 níveis: sintática, semântica, de negócio, de integridade (banco)
- CRUD completo (filtros, paginação, soft delete, auditoria, concorrência otimista)
- Máquina de estados, Value Objects, dinheiro e datas
- Transações, condições de corrida, idempotência, `afterCommit`

---

## Trilha por nível (do básico ao avançado)

| Nível | Foco | Camadas/tópicos | Está pronto quando consegue... |
|---|---|---|---|
| **Básico** | Linguagem, HTTP e CRUD simples | 0, 1 (base), 3 (Composer/autoload), 4, 5 (SQL e PDO), 8 (SQLi, XSS, senhas), 10 (método), 15 (seções 1 e 2) | Fazer um CRUD seguro sem framework e explicar o caminho de uma requisição |
| **Intermediário** | Arquitetura, APIs e regras de negócio | 1 (OOP/traits/generators), 6, 7, 9, 16, 15 (seções 3 e 4), 11 (básico) | Separar camadas, validar em níveis, tratar concorrência e testar regras |
| **Avançado** | Funcionamento interno e desempenho | 2 (Zend Engine), 15 (seções 5 e 6), 11, 12, ler código-fonte do PHP | Explicar tokens → AST → opcodes, usar `strace`/profiler e justificar decisões de arquitetura |

## Ordem de estudo sugerida

1. **Camadas 0 e 1:** servidor, HTTP e a linguagem (base de tudo)
2. **Camada 2:** Zend Engine; olhe tokens, AST e opcodes de um script seu
3. **Camada 3:** Composer e autoload
4. **Camadas 4 e 5:** HTTP em PHP e banco de dados (primeiro projeto sem framework)
5. **Camada 8 (segurança)** desde cedo, aplicada ao projeto, não só no fim
6. **Camada 6:** arquitetura e mini-framework
7. **Camada 7:** API REST com autenticação
8. **Camadas 9 e 10:** testes e depuração guiada
9. **Camadas 11 e 12:** performance, deploy e integração com o front
10. **Camadas 13 e 14:** simulados e complementos, repetidamente

## Projetos práticos que fixam o conhecimento
- [ ] Imprimir tokens (`token_get_all`) e a AST (`nikic/php-parser`) de um script e ler os opcodes
- [ ] **Mini-framework:** front controller, router, container de DI, request/response
- [ ] **Autoloader PSR-4 escrito à mão**, antes de usar o do Composer
- [ ] CRUD sem framework com PDO, sessões, validação e escape
- [ ] **API REST** com JWT, paginação, validação e OpenAPI
- [ ] Repositório com 15 bugs plantados (um por linha da tabela de erros)
- [ ] Atacar a própria aplicação (SQLi, XSS, CSRF, upload malicioso) e corrigir
- [ ] Subir tudo com Docker Compose (Nginx + PHP-FPM + banco + React)
- [ ] Mini ORM / query builder simples

## Referências
- **Manual oficial:** php.net/manual (e *PHP: The Right Way* — phptherightway.com)
- **PHP Internals Book** (phpinternalsbook.com), código-fonte do PHP no GitHub
- **nikic/php-parser** (AST) e o blog do Nikita Popov sobre internals
- **PSRs:** php-fig.org
- **Composer:** getcomposer.org/doc
- **OWASP:** Top 10 e Cheat Sheet Series; *PHP Security Cheat Sheet*
- **Laravel/Symfony docs**, para ver arquitetura aplicada
- **Use The Index, Luke** (índices SQL) e documentação do MySQL/PostgreSQL
- ***Crafting Interpreters*** (para reforçar lexer/parser)
- **WorldSkills / SENAI:** Technical Description e Test Projects da sua competição

## Glossário rápido
- **SAPI:** interface entre o PHP e o ambiente que o executa (CLI, FPM...)
- **PHP-FPM:** gerenciador de processos FastCGI que roda o PHP atrás do Nginx/Apache
- **Opcode:** instrução de baixo nível executada pela Zend VM
- **AST:** árvore que representa a estrutura do código
- **OPcache:** cache em memória de opcodes compilados
- **Share-nothing:** estado destruído a cada requisição
- **Autoload:** carregamento de classes sob demanda (PSR-4)
- **Front controller:** ponto único de entrada (`index.php`)
- **Prepared statement:** consulta com parâmetros separados do SQL (previne SQLi)
- **Middleware:** camada que intercepta request/response em pipeline
- **DI (Injeção de Dependência):** passar dependências em vez de criá-las dentro da classe
- **N+1:** uma consulta inicial + N consultas extras desnecessárias

> Lembrete: versões mudam (PHP 8.x, Laravel, Composer, PHPUnit). Antes de estudar um detalhe dependente de versão, confirme na documentação oficial atual. Para a WorldSkills, o Technical Description da sua edição prevalece sobre este mapa.
