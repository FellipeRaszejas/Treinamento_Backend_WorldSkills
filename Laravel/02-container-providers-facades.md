# Camada 2: Service Container, Providers e Facades (por dentro)

**Foco:** entender a "mágica" central do Laravel. Container + Providers + Facades explicam como as peças se encontram.

## 1. Service Container
- [ ] **Problema:** criar objetos com dependências sem `new` espalhado
- [ ] `app()`, `resolve()`, `$this->app->make()`, `$app[...]`
- [ ] **Bindings:** `bind`, `singleton`, `scoped`, `instance`, `bindIf`
- [ ] **Autowiring:** o container lê os tipos do construtor (`ReflectionClass`) e resolve recursivamente
- [ ] Binding de interface → implementação (`Contracts`)
- [ ] **Binding contextual** (`when(...)->needs(...)->give(...)`)
- [ ] Tags, `extend`, `rebinding`, callbacks de resolução (`resolving`)
- [ ] Injeção em métodos (`app()->call`), em controllers, jobs, listeners, middleware
- [ ] Erros: `BindingResolutionException`, "Target [Interface] is not instantiable", "Unresolvable dependency"
- [ ] Ciclo de vida: singleton por processo vs por requisição (cuidado com Octane)

## 2. Service Providers
- [ ] **`register()`**: só registrar bindings (não use outros serviços aqui)
- [ ] **`boot()`**: tudo já está registrado; usar rotas, eventos, views, observers
- [ ] Ordem: todos os `register` → todos os `boot`
- [ ] Onde são listados: `bootstrap/providers.php` (e `config/app.php` em versões antigas)
- [ ] **Descoberta de pacotes** (`extra.laravel.providers` no `composer.json` do pacote)
- [ ] Providers **adiados** (`DeferrableProvider`)
- [ ] Providers do próprio framework (`Illuminate\*\*ServiceProvider`): o que cada um faz
- [ ] Criar um provider próprio e um pacote local

## 3. Facades
- [ ] São **proxies estáticos**, não classes estáticas de verdade
- [ ] Fluxo: `Cache::get()` → `Facade::__callStatic` → `getFacadeRoot()` → `getFacadeAccessor()` → container → objeto real
- [ ] Facades vs injeção de dependência vs helpers (`cache()`)
- [ ] **`Facade::fake()`/`shouldReceive()`** e por que facades podem facilitar testes
- [ ] Real-time facades (`Facades\...`), criar facade própria
- [ ] Críticas e trade-offs (acoplamento oculto)

## 4. Contracts
- [ ] `Illuminate\Contracts\*`: interfaces dos serviços do framework
- [ ] Trocar implementação via binding sem mudar o código cliente
- [ ] Quando tipar contra o contract em vez da classe concreta

## 5. Outras peças de "mágica" (todas PHP comum)
- [ ] `Macroable` (`macro()`) em Collection, Str, Request, etc.
- [ ] `Pipeline` (`array_reduce` de closures) e `Conditionable`/`Tappable`
- [ ] `__call` em Eloquent, Request, Response, Collection
- [ ] `Fluent`, `Stringable`, higher order messages em Collections

## Autoavaliação
1. O que o container faz quando o construtor pede uma interface sem binding?
2. Por que não se deve resolver serviços dentro de `register()`?
3. O que realmente acontece em `Cache::get('x')`?
4. Quando usar `singleton` e quando `bind`?
5. Como o `Facade::fake()` substitui o serviço real?

## Exercícios
- **Escrever um container** com `bind`, `singleton` e autowiring via `ReflectionClass`
- Criar um Service Provider que registra um serviço próprio e usá-lo em um controller
- Criar uma Facade própria (`Greeter::hello()`) apontando para esse serviço
- Fazer um binding contextual e provar que cada classe recebe uma implementação diferente
- Ler `Illuminate\Container\Container::build()` e `Illuminate\Support\Facades\Facade`
