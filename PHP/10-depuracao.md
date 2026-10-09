# Camada 10: Depurar Como a Máquina Lê

**Foco:** diagnosticar rápido. A habilidade-chave é descobrir **em qual máquina o erro aconteceu**: servidor, FPM, Zend, autoload, banco, rede ou código de negócio.

## Método
1. **Ler a mensagem inteira**: tipo de erro, arquivo, linha, *stack trace*
2. **Classificar** a máquina: parse (compilação), runtime (VM), servidor, banco, rede
3. **Olhar os logs certos** (PHP, FPM, Nginx/Apache, banco)
4. **Reproduzir** o problema de forma mínima (`curl`, script CLI)
5. **Formular uma hipótese** e testar uma coisa por vez
6. **Confirmar a causa** antes de corrigir; escrever um teste
7. Se travar: isolar, `git diff`, `git bisect`

## Ferramentas
- [ ] **Configuração de erros:** `display_errors`, `error_reporting`, `log_errors`, `error_log`
- [ ] **Logs:** PHP, PHP-FPM, Nginx/Apache (`access` e `error`), banco (slow log)
- [ ] `var_dump`, `print_r`, `error_log`, `dd` (Laravel), `debug_print_backtrace`
- [ ] **Xdebug:** breakpoints, *step into/over*, inspeção de variáveis, profiler
- [ ] `php -l` (lint), `phpdbg`, `php -a` (REPL)
- [ ] `curl -v`, aba Network do navegador (headers, payload, status)
- [ ] `EXPLAIN`, query log
- [ ] Ferramentas de erros: Whoops, Ignition, Sentry (noção)

## Tabela: sintoma → quem falhou
| Sintoma | Quem falhou | Onde olhar |
|---|---|---|
| `Parse error: syntax error` | Lexer/parser do PHP | Linha indicada e a anterior (`;`, chave, aspas) |
| `Fatal error: Uncaught Error/TypeError` | Zend VM (runtime) | Stack trace, tipos |
| `Class "X" not found` | Autoload/namespace | `use`, PSR-4, `dump-autoload`, maiúsculas |
| `Call to undefined function/method` | Extensão ausente ou código | `php -m`, nome, versão |
| Página em branco | Erro oculto | `display_errors` off → ver o log |
| `Headers already sent` | Saída antes de `header()`/`session_start()` | `echo`, espaço, BOM, `?>` final |
| `Undefined variable/array key` | Dados ausentes | `isset`, `??`, origem do dado |
| `Allowed memory size exhausted` | Memória | Loop, dataset grande, generators |
| `Maximum execution time exceeded` | Tempo | Consulta lenta, `max_execution_time` |
| `SQLSTATE[HY000]` / `PDOException` | Banco | Credenciais, host, SQL, schema, charset |
| 404 do servidor (não do app) | Config do servidor | `try_files`, rewrite, root |
| 403 Forbidden | Permissões/regras | `chmod/chown`, usuário do FPM |
| 500 sem mensagem | Erro PHP oculto | Log do FPM/Nginx |
| 502 Bad Gateway | PHP-FPM parado ou socket errado | Serviço FPM, `fastcgi_pass` |
| 504 Gateway Timeout | Script lento/timeout | `fastcgi_read_timeout`, consulta lenta |
| CORS error no front | Headers do back-end | `Access-Control-*`, preflight |
| Sessão "some" | Cookie/armazenamento | Domínio, `save_path`, `SameSite`, HTTPS |
| `Cannot modify header information` | Mesma causa de "headers already sent" | Saída prévia |
| Upload falha | Limites ou permissões | `upload_max_filesize`, `post_max_size`, destino |
| Mudança não aparece | OPcache ou cache do navegador/CDN | `validate_timestamps`, reiniciar FPM |
| Local funciona, produção quebra | Ambiente | Versão do PHP, extensões, `php.ini`, `.env`, permissões, case de arquivos |
| Caracteres quebrados (`Ã§`) | Charset | `utf8mb4`, `Content-Type`, `mbstring`, arquivo salvo em UTF-8 |
| Data/hora errada | Timezone | `date.timezone`, `DateTimeZone` |

## Tópicos
- [ ] Ler *stack traces* de baixo para cima e identificar o ponto do **seu** código
- [ ] Erro de compilação vs runtime (por que o parse error derruba o arquivo todo)
- [ ] Depurar requisições HTTP de ponta a ponta
- [ ] Depurar consultas SQL e N+1
- [ ] Depurar ambiente (versão, extensões, permissões)
- [ ] Ler código alheio rapidamente

## Exercícios
- Repositório com **15 bugs plantados** (um por linha da tabela) e resolver cronometrado
- Provocar cada erro de ambiente (502, 403, headers already sent, charset) e corrigir
- Praticar Xdebug em um fluxo completo (breakpoint → variável → causa)
- Praticar `git bisect` em uma regressão
- Após cada bug, registrar: **sintoma / quem falhou / causa / correção**
