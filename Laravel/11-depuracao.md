# Camada 11: Depurar Como a Máquina Lê

**Foco:** diagnosticar rápido. A pergunta-chave é: **em qual máquina falhou?** (servidor, PHP, autoload, container, rota, middleware, Eloquent, banco, front/Vite.)

## Método
1. **Ler a mensagem inteira** (Ignition mostra o trecho de código e a stack)
2. **Identificar a camada:** servidor → autoload → container → rota/middleware → controller → banco → view
3. **Ver os logs** (`storage/logs/laravel.log`, Nginx/FPM)
4. **Reproduzir** de forma mínima (`tinker`, teste, `curl`)
5. **Hipótese → teste → confirmar**, uma coisa por vez
6. Escrever um teste que reproduz o bug antes de corrigir

## Ferramentas
- [ ] **Ignition** (página de erro em dev), `dd()`, `dump()`, `ddd`/`ray` (opcional)
- [ ] **`php artisan tinker`**: executar código com o app carregado
- [ ] **`php artisan route:list`**, `about`, `config:show`, `event:list`, `schedule:list`
- [ ] **Query log:** `DB::listen`, `DB::enableQueryLog()`, `->toSql()`
- [ ] **Telescope** (requisições, consultas, jobs, exceções), **Debugbar** (barra de debug)
- [ ] **Logs:** `Log::debug/info/error`, canais, `laravel.log`, `php artisan pail` (log em tempo real; confirme na sua versão)
- [ ] **Xdebug** com breakpoints
- [ ] DevTools do navegador (Network), `curl -v`
- [ ] Limpar caches: `optimize:clear`, `config:clear`, `route:clear`, `view:clear`, `cache:clear`

## Tabela: sintoma → quem falhou
| Sintoma | Quem falhou | Onde olhar |
|---|---|---|
| `Class "X" not found` | Autoload/namespace | `use`, PSR-4, `composer dump-autoload`, maiúsculas |
| `Target class [X] does not exist` | Container / controller não encontrado | Namespace/`use` na rota, nome do arquivo |
| `Target [Interface] is not instantiable` | Binding ausente | Provider, `bind()` |
| `Unresolvable dependency resolving [...]` | Parâmetro sem tipo/valor | Construtor, binding contextual |
| `Route [x] not defined` | Nome de rota | `route:list`, nome ou cache de rotas |
| `404` em rota existente | Cache de rotas, binding, prefixo, servidor | `route:clear`, `route:list`, `try_files` |
| `405 Method Not Allowed` | Verbo errado | `route:list`, `@method('PUT')` |
| `419 Page Expired` | CSRF/sessão | `@csrf`, cookie, `SESSION_DOMAIN`, domínio/HTTPS |
| `403` | Policy/gate/middleware ou permissão de arquivo | Policy, `authorize`, permissões do servidor |
| `401` em API | Token/sessão ausente | Header `Authorization`, Sanctum, `Accept` |
| `422` | Validação | Corpo da resposta (`errors`) |
| Campo não salva | Mass assignment | `$fillable`/`$guarded` |
| `MassAssignmentException` | `shouldBeStrict`/atributo não permitido | `$fillable` |
| `Add [x] to fillable property` | Mass assignment | Modelo |
| `SQLSTATE[42S02] Base table not found` | Migration não rodada | `migrate:status` |
| `SQLSTATE[HY000] [2002]` | Conexão com o banco | Host (`localhost` vs nome do container), porta, `.env` |
| `Integrity constraint violation` | Constraint (FK/unique/not null) | Dados e migration |
| `No application encryption key has been specified` | Falta `APP_KEY` | `php artisan key:generate` |
| `.env` "não muda" | `config:cache` ativo | `config:clear` |
| Blade "não atualiza" | View cache | `view:clear` |
| `Vite manifest not found` | Assets não compilados | `npm run dev/build` |
| Imagem/arquivo 404 | `storage:link` ou permissão | `storage:link`, disk `public` |
| 500 após deploy | Permissões, `APP_KEY`, `.env`, cache de config | Log, `storage/`, `bootstrap/cache` |
| Job não executa | Worker parado, driver, fila | `queue:work`, `QUEUE_CONNECTION`, `failed_jobs` |
| E-mail não sai | Driver/credenciais/fila | `MAIL_*`, worker |
| Lentidão | N+1, falta de índice | `DB::listen`, Telescope, `with()` |
| CORS error | Config de CORS/origem | `config/cors.php`, `Accept`, preflight |
| Data/hora errada | Timezone | `config/app.php`, Carbon |

## Tópicos
- [ ] Ler stack traces (frames do **seu** código vs do framework)
- [ ] Diferenciar erros de compilação PHP, de container, de roteamento, de SQL e de front
- [ ] Depurar middleware e ordem de execução
- [ ] Depurar filas, eventos e scheduler (processos fora da requisição)
- [ ] Ler código alheio rapidamente

## Exercícios
- Repositório com **15 bugs plantados** (um por linha da tabela) e resolver cronometrado
- Provocar cada erro de ambiente (419, 403, Vite manifest, `storage:link`, config cache) e corrigir
- Usar Telescope para achar um N+1 e uma exceção escondida
- Para cada bug: registrar **sintoma / quem falhou / causa / correção**
