# Camada 14: Laravel por Dentro (ler e reconstruir o framework)

**Foco:** ler o código-fonte do framework e **reconstruir versões mínimas** das peças centrais. É o equivalente ao seu "lexer/parser": quando você consegue reescrever a mágica, entende o erro.

## 1. Como ler o código do Laravel
- [ ] Repositório: `laravel/framework`, pasta `src/Illuminate/*` (cada pasta é um componente)
- [ ] Ler **de fora para dentro**: do ponto de entrada (`public/index.php`) para o componente
- [ ] Usar o IDE (ir para definição) e `dd()` no `vendor/` (temporariamente) para seguir o fluxo
- [ ] Ler **testes** do framework para ver o uso esperado
- [ ] Contratos (`Illuminate\Contracts`) primeiro, implementações depois

## 2. Roteiro de leitura
- [ ] **`Foundation\Application`** e `Configuration\ApplicationBuilder` (como `bootstrap/app.php` monta o app)
- [ ] **`Container\Container`**: `make`, `resolve`, `build`, `resolveDependencies` (reflexão)
- [ ] **`Foundation\Bootstrap\*`**: carga de `.env`, config, exceções, providers
- [ ] **`Support\ServiceProvider`** e `Foundation\ProviderRepository`
- [ ] **`Support\Facades\Facade`**
- [ ] **`Pipeline\Pipeline`** (`array_reduce` de closures)
- [ ] **`Routing\Router`, `Route`, `RouteCollection`, `RouteCompiler`**
- [ ] **`Http\Request`** (sobre Symfony) e `Http\Response`
- [ ] **`Database\Query\Builder`** e `Query\Grammars\*` (compilação para SQL)
- [ ] **`Database\Eloquent\Model`** (`__get`, `__call`, `newQuery`) e `Eloquent\Builder`
- [ ] **`View\Compilers\BladeCompiler`** e `ComponentTagCompiler`
- [ ] **`Support\Collection`** e `Macroable`
- [ ] **`Console\Application`** (artisan sobre Symfony Console)
- [ ] **`Validation\Validator`** e `Factory`
- [ ] **`Queue\Worker`**

## 3. Reconstruir peças (mini-Laravel)
- [ ] **Container** com `bind`, `singleton` e autowiring por `ReflectionClass`
- [ ] **Pipeline** de middleware com `array_reduce`
- [ ] **Router** simples (método + padrão → closure/controller), parâmetros de rota, grupos
- [ ] **Facade** (`__callStatic` → container)
- [ ] **Request/Response** mínimos
- [ ] **View/Blade** simplificado (compilar `{{ }}`, `@if`, `@foreach` para PHP e cachear)
- [ ] **Query Builder** com Grammar simples gerando SQL e bindings (PDO)
- [ ] **Model** com `__get/__call` e `save/find`
- [ ] **Service Provider** (register/boot) e carregador de providers
- [ ] **Kernel/Application** que costura tudo e roda um front controller

## 4. O que entender ao final
- [ ] Por que `Target class does not exist` e `Unresolvable dependency` acontecem (container)
- [ ] Por que rotas em closure não são cacheáveis (serialização)
- [ ] Por que Octane quebra singletons com estado
- [ ] Por que `register` e `boot` têm papéis diferentes
- [ ] Por que `User::where(...)` funciona sem método estático `where`
- [ ] Como o Blade vira PHP e por que o cache importa

## Autoavaliação
1. Posso desenhar de memória o caminho de `public/index.php` até o controller?
2. Posso explicar `Cache::get()` sem dizer "mágica"?
3. Sei onde, no código, é decidida a ordem dos middleware?
4. Sei como o Query Builder transforma encadeamentos em SQL?

## Exercícios
- Construir o **mini-Laravel** em etapas e rodar um app de exemplo sobre ele
- Escrever por escrito o ciclo de vida de uma requisição com nomes reais das classes
- Escolher um bug do tipo "Target class..." e rastreá-lo até a linha do container que lança o erro
- Contribuir (mentalmente ou de fato) com uma correção de documentação
