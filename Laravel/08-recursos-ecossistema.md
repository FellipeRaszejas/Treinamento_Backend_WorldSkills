# Camada 8: Recursos do Ecossistema

**Foco:** ferramentas nativas que transformam um CRUD em uma aplicação de verdade: trabalho assíncrono, comunicação, arquivos e agendamento.

## 1. Filas e jobs
- [ ] Conceito: tirar trabalho lento da requisição
- [ ] Drivers: `database`, `redis`, `sqs`, `sync`; `config/queue.php`
- [ ] `make:job`, `dispatch`, `afterCommit`, filas nomeadas, atrasos
- [ ] **Workers:** `queue:work`, `queue:listen`, reiniciar após deploy (`queue:restart`)
- [ ] Retries, `tries`, `backoff`, `timeout`, `failed_jobs`, `queue:retry`
- [ ] Batches, chains, `ShouldBeUnique`, middleware de job
- [ ] **Horizon** (Redis), supervisão de workers (Supervisor/systemd)

## 2. Eventos e listeners
- [ ] Event → Listener(s); descoberta automática; listeners em fila
- [ ] Observers de modelo vs eventos de domínio
- [ ] Subscribers, `Event::fake()` em testes

## 3. Notificações e e-mail
- [ ] **Mailables**, views Blade/Markdown, anexos, filas (`ShouldQueue`)
- [ ] Drivers (SMTP, Mailgun, SES...), `Mail::fake`, preview de mail
- [ ] **Notifications** multicanal (mail, database, broadcast, SMS/Slack)

## 4. Scheduler
- [ ] Definir tarefas em `routes/console.php` (`Schedule::command(...)->daily()`)
- [ ] Uma única entrada no cron: `* * * * * php artisan schedule:run`
- [ ] `withoutOverlapping`, `onOneServer`, `schedule:list`

## 5. Cache
- [ ] `Cache::get/put/remember/forget`, tags, locks atômicos
- [ ] Drivers: `file`, `database`, `redis`, `memcached`
- [ ] Estratégias e invalidação

## 6. Arquivos e storage
- [ ] Disks (`local`, `public`, `s3`), `Storage::put/get/url/delete`
- [ ] **`php artisan storage:link`**, uploads seguros, nomes aleatórios, validação de MIME
- [ ] Links temporários (S3 signed URLs)

## 7. Utilidades
- [ ] **Collections** (`map`, `filter`, `groupBy`, `pluck`, `reduce`...), `LazyCollection`
- [ ] `Str`, `Arr`, `Number`, helpers, `Carbon` (datas)
- [ ] **HTTP Client** (`Http::get/post`, `retry`, `timeout`, `fake`)
- [ ] Localização (`lang/`, `__()`), validação em outros idiomas

## 8. Tempo real e monitoramento
- [ ] Broadcasting (Reverb/Pusher, Laravel Echo), canais privados
- [ ] **Telescope** (dev), **Pulse** (produção), **Horizon**, logs (Monolog, canais, `Log::`)
- [ ] `Context` para correlacionar logs (noção)

## Autoavaliação
1. Por que o worker precisa ser reiniciado após deploy?
2. Qual a diferença entre `queue:work` e `queue:listen`?
3. Como o scheduler roda com apenas uma linha no cron?
4. O que acontece com um job que falha após todas as tentativas?
5. Por que `storage:link` é necessário?

## Exercícios
- Fila + e-mail: cadastro dispara e-mail de boas-vindas em job
- Scheduler que gera um relatório diário e o grava no storage
- Job com retry, backoff e tratamento de falha
- Evento `OrderPlaced` com 3 listeners (e-mail, estoque, log)
- Cache de uma consulta pesada com invalidação ao atualizar o modelo
