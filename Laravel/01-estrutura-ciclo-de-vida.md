# Camada 1: Estrutura e Ciclo de Vida da Requisição

**Foco:** saber **onde está cada coisa** e **o que acontece, em ordem**, do `public/index.php` até a resposta. Esta é a base do seu "pensar como a máquina" no Laravel.

## 1. Instalação e comandos iniciais
- [ ] `composer create-project laravel/laravel` ou `laravel new`
- [ ] `php artisan serve`, `php artisan about`, `php artisan list`
- [ ] `key:generate`, `migrate`, `tinker`, `route:list`
- [ ] Versão do Laravel e do PHP (`php artisan --version`)

## 2. Estrutura de pastas
- [ ] `app/` (Models, Http/Controllers, Providers, Policies...)
- [ ] `bootstrap/` (`app.php`, `providers.php`, `cache/`)
- [ ] `config/` (arquivos de configuração; no 11+ vários são publicados sob demanda)
- [ ] `database/` (migrations, factories, seeders)
- [ ] `public/` (único diretório exposto: `index.php`, assets)
- [ ] `resources/` (views, JS/CSS, lang)
- [ ] `routes/` (`web.php`, `api.php` após `install:api`, `console.php`)
- [ ] `storage/` (logs, cache, sessions, views compiladas, `app/public`)
- [ ] `tests/`, `vendor/`, `.env`, `artisan`

## 3. Configuração e ambientes
- [ ] `.env` → `config/*.php` → `config('chave')` (nunca use `env()` fora de `config/`)
- [ ] `APP_ENV`, `APP_DEBUG`, `APP_KEY`, `APP_URL`
- [ ] Por que `config:cache` quebra `env()` fora da config
- [ ] `.env.example` e segredos fora do Git

## 4. Artisan
- [ ] Construído sobre **Symfony Console**
- [ ] `make:model|controller|migration|request|policy|job|...`
- [ ] Criar comandos próprios (`make:command`), argumentos e opções
- [ ] `tinker` para experimentar código com o app carregado

## 5. Ciclo de vida da requisição (decorar e conseguir desenhar)
```
public/index.php
 → vendor/autoload.php
 → bootstrap/app.php          (Application::configure(...)->create(); é o Container)
 → $app->handleRequest(Request::capture())
 → providers: register() de todos, depois boot() de todos
 → middleware globais
 → Router: casa a rota → middleware da rota
 → Controller (dependências injetadas pelo container)
 → Response → middleware de saída → envio ao navegador
 → terminate() (tarefas pós-resposta)
```
- [ ] Quem cria o objeto `Request` (Symfony HttpFoundation) e o que ele contém
- [ ] Onde os providers são lidos (`bootstrap/providers.php` + descoberta de pacotes)
- [ ] Onde middleware, rotas e exceções são configurados (`bootstrap/app.php`: `withRouting`, `withMiddleware`, `withExceptions`)
- [ ] Console Kernel e o ciclo de vida do `artisan` (parecido, sem HTTP)
- [ ] Em versões antigas: `app/Http/Kernel.php` (você vai encontrá-lo em tutoriais e projetos legados)

## 6. Convenções
- [ ] Nomes (model singular, tabela plural), PSR-12, estrutura de rotas
- [ ] "Convenção sobre configuração": o que o Laravel assume sozinho

## Autoavaliação
1. Por que só `public/` fica exposto ao servidor?
2. Em que momento do ciclo o container é criado?
3. Qual a diferença entre `register()` e `boot()`?
4. Por que `env()` fora de `config/` retorna `null` após `config:cache`?
5. Onde eu registro um middleware global na versão que uso?

## Exercícios
- Colocar `dd('chegou aqui')` em `index.php`, `bootstrap/app.php`, num provider, num middleware e num controller, e **ver a ordem**
- Rodar `php artisan route:list` e relacionar cada linha ao código
- Criar um comando artisan próprio que imprime a versão do app
- Ler `public/index.php` e `bootstrap/app.php` linha por linha e explicar cada uma
