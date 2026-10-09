# Camada 12: Performance e Deploy

**Foco:** medir antes de otimizar, e colocar o Laravel em produção com segurança e previsibilidade.

## 1. Medir
- [ ] Onde está o tempo: PHP, banco, rede, serviço externo?
- [ ] **Telescope** (dev), **Pulse** (produção), logs de consulta lenta, `EXPLAIN`
- [ ] Profiling (Xdebug, Blackfire, XHProf), testes de carga (`k6`, `wrk`, `ab`)
- [ ] Métricas: p50/p95/p99, vazão, taxa de erro, memória

## 2. Caches do Artisan (produção)
- [ ] `config:cache` (junta toda a config; `env()` fora de `config/` deixa de funcionar)
- [ ] `route:cache` (rotas com closures não podem ser cacheadas)
- [ ] `view:cache` (compila todas as views Blade antes)
- [ ] `event:cache`
- [ ] **`php artisan optimize`** (agrupa os caches) e **`optimize:clear`**
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] Cuidado: rodar os caches **no deploy**, nunca editar `.env` depois sem limpar

## 3. PHP e servidor
- [ ] **OPcache** ligado e configurado, `validate_timestamps` em produção
- [ ] PHP-FPM dimensionado (`pm.max_children`)
- [ ] **Laravel Octane** (Swoole/RoadRunner/FrankenPHP): app mantido em memória; riscos de **estado compartilhado** entre requisições (singletons, estáticos)
- [ ] Nginx: `try_files` para `public/index.php`, servir assets estáticos, gzip/brotli

## 4. Banco e aplicação
- [ ] **N+1** eliminado (`with()`), `preventLazyLoading` em dev
- [ ] Índices, paginação (`cursorPaginate`), evitar `select *`
- [ ] Cache de consultas caras (`Cache::remember`), Redis para cache e sessão
- [ ] Mover tarefas lentas para **filas**
- [ ] Respostas HTTP com `Cache-Control`/`ETag` quando fizer sentido

## 5. Filas e agendamento em produção
- [ ] Workers supervisionados (Supervisor/systemd) ou **Horizon**
- [ ] `queue:restart` após cada deploy
- [ ] Cron com `schedule:run` (uma entrada por minuto)
- [ ] Monitorar `failed_jobs`

## 6. Deploy
- [ ] Fluxo: build → testes → artefato → servidor
- [ ] **Sequência típica:** `git pull`/artefato → `composer install --no-dev` → `npm ci && npm run build` → `php artisan migrate --force` → `php artisan optimize` → `queue:restart`
- [ ] **Permissões** de `storage/` e `bootstrap/cache` (usuário do FPM, **não 777**)
- [ ] `php artisan storage:link`
- [ ] `.env` de produção: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY`, banco, cache, filas, e-mail
- [ ] **Docker:** imagem multi-stage (PHP-FPM + Nginx), Sail para dev, `.dockerignore`
- [ ] Hospedagem: Forge/Cloud/Vapor (noção), VPS, hospedagem compartilhada (`public/` como root)
- [ ] HTTPS (Let's Encrypt), domínios, `TrustProxies`
- [ ] **Migrations no deploy**, rollback, deploy sem downtime, `php artisan down`/`up`
- [ ] CI/CD (GitHub Actions)

## 7. Operação
- [ ] Logs centralizados e rotação (`daily`), alertas
- [ ] Backups do banco e do storage; teste de restore
- [ ] Atualizações de PHP/Laravel e política de upgrade
- [ ] Health checks (`/up`)

## Autoavaliação
1. Por que `config:cache` quebra `env()` espalhado pelo código?
2. Por que `route:cache` falha com rotas em closure?
3. O que muda no ciclo de vida com Octane e quais bugs isso traz?
4. Por que os workers precisam reiniciar após o deploy?
5. Por que `storage/` não deve ter permissão 777?

## Exercícios
- Medir uma rota lenta, achar o gargalo e comparar antes/depois
- Rodar `optimize` e depois mudar o `.env` para ver o efeito; corrigir
- Criar imagem Docker de produção e subir com Nginx + PHP-FPM + banco
- Fazer deploy com migration e simular rollback
- Provocar um bug de estado compartilhado em Octane (singleton mutável) e corrigi-lo
