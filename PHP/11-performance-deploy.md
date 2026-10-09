# Camada 11: Performance e Deploy

**Foco:** medir antes de otimizar, e entender o caminho do código até o servidor de produção.

## 1. Medir
- [ ] Onde está o tempo: PHP, banco, rede, disco ou serviço externo?
- [ ] **Profiling:** Xdebug profiler, XHProf, Blackfire, Tideways
- [ ] Logs de consulta lenta, `EXPLAIN`
- [ ] Teste de carga: `ab`, `wrk`, `k6`, `hey`
- [ ] Métricas: latência (p50/p95/p99), vazão, taxa de erro

## 2. PHP em si
- [ ] **OPcache** bem configurado (`memory_consumption`, `max_accelerated_files`, `validate_timestamps=0` em produção com deploy que reinicia/invalida)
- [ ] **Preloading** (avaliar)
- [ ] **JIT** (avaliar; ajuda em CPU-bound, pouco em apps web típicas)
- [ ] Autoloader otimizado (`composer dump-autoload -o` / `--classmap-authoritative`)
- [ ] Evitar trabalho repetido em loop; generators para grandes volumes

## 3. PHP-FPM
- [ ] `pm` (static, dynamic, ondemand), `pm.max_children`
- [ ] Dimensionar: memória por worker × quantidade de workers
- [ ] Timeouts (`request_terminate_timeout`), slow log
- [ ] Relação com Nginx (`fastcgi_*`)

## 4. Banco
- [ ] Índices corretos, evitar `SELECT *`, resolver **N+1**
- [ ] Paginação eficiente (cursor/keyset em vez de offset enorme)
- [ ] Pool/limites de conexão, réplicas de leitura (noção)
- [ ] Cache de consultas caras

## 5. Cache
- [ ] **APCu** (cache local), **Redis/Memcached** (compartilhado)
- [ ] Cache de aplicação, de view e de resposta HTTP
- [ ] `Cache-Control`, `ETag`, `Last-Modified`, CDN
- [ ] Estratégias de invalidação (TTL, eventos), *cache stampede* (noção)

## 6. Assíncrono
- [ ] Filas (Redis, RabbitMQ, SQS), workers, retries, *dead letter*
- [ ] Cron e agendadores
- [ ] Processos longos (cuidado com memória e conexões)
- [ ] Servidores long-running: **Swoole, RoadRunner, FrankenPHP** (noção e riscos de estado compartilhado)

## 7. Deploy
- [ ] Fluxo: build → testes → artefato → servidor
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] **Docker:** imagem multi-stage, `php-fpm` + `nginx`, não rodar como root, `.dockerignore`
- [ ] **Docker Compose** para dev e staging
- [ ] Variáveis de ambiente e segredos
- [ ] **Migrations no deploy**, rollback, deploy sem downtime (noção)
- [ ] Permissões (`storage/`, `cache/`), usuário do processo
- [ ] HTTPS (Let's Encrypt), domínios, redirects
- [ ] CI/CD

## 8. Operação
- [ ] Logs centralizados, rotação de logs
- [ ] Monitoramento e alertas, *health checks*
- [ ] Backups e testes de restore
- [ ] Atualização de PHP e dependências

## Autoavaliação
1. Por que `validate_timestamps=0` exige um passo no deploy?
2. Como dimensionar `pm.max_children`?
3. O que o profiler mostra que `microtime()` não mostra?
4. Quando cache atrapalha mais do que ajuda?
5. Por que migrations e deploy precisam ser coordenados?

## Exercícios
- Perfilar uma rota lenta, achar o gargalo e comparar antes e depois
- Adicionar Redis como cache e medir ganho
- Fazer teste de carga e ajustar o FPM até estabilizar
- Criar uma imagem Docker de produção e outra de desenvolvimento
- Simular deploy com migration e rollback
