# Camada 1: Linguagem PHP (moderno, 8.x)

**Foco:** dominar a linguagem, incluindo as armadilhas. Confirme na documentação oficial o que mudou nas versões mais recentes.

## 1. Base
- [ ] Variáveis, tipos escalares, `null`, coerção automática
- [ ] **Comparação:** `==` vs `===`, `<=>`, regras de conversão (`0 == "abc"`, `"1e3" == "1000"`), `??`, `?:`, `?->`
- [ ] Strings: aspas simples vs duplas, interpolação, heredoc/nowdoc, `sprintf`, funções de string
- [ ] Constantes, `define` vs `const`, constantes mágicas
- [ ] Escopo: `global`, `static`, funções e closures
- [ ] `include/require`, `_once`, caminhos relativos e `__DIR__`

## 2. Arrays
- [ ] São **tabelas hash ordenadas**: lista e mapa ao mesmo tempo
- [ ] Cópia por valor (copy-on-write) vs referências
- [ ] `array_map`, `array_filter`, `array_reduce`, `usort`, `array_column`, `array_merge` vs `+`
- [ ] Destructuring, spread (`...`), `list()`
- [ ] `isset` vs `empty` vs `array_key_exists`

## 3. Tipos modernos
- [ ] Tipos em parâmetros, retornos e propriedades
- [ ] `declare(strict_types=1)` e o que muda
- [ ] Union, intersection, nullable, `mixed`, `never`, `void`, `static`
- [ ] `readonly` (propriedades e classes), enums (puros e *backed*)

## 4. Orientação a objetos
- [ ] Classes, objetos, visibilidade, `static`, constantes de classe
- [ ] Interfaces, classes abstratas, **traits** (e seus riscos)
- [ ] `self` vs `static` (late static binding), `parent`
- [ ] Objetos são passados por **handle**; `clone` e `__clone`
- [ ] Magic methods: `__construct`, `__get/__set`, `__call/__callStatic`, `__invoke`, `__toString`
- [ ] Constructor promotion, named arguments, `match`, attributes, first-class callable syntax
- [ ] Namespaces e `use`, resolução de nomes

## 5. Funcional e iteração
- [ ] Closures, `use`, arrow functions (`fn`), callables, `Closure::bind`
- [ ] **Generators** (`yield`) para grandes volumes
- [ ] `Iterator`, `IteratorAggregate`, `Countable`, `ArrayAccess`, SPL

## 6. Erros e exceções
- [ ] `Throwable` → `Exception` e `Error`; `TypeError`, `ValueError`
- [ ] `try/catch/finally`, relançar, exceções customizadas, encadeamento (`previous`)
- [ ] Níveis de erro (`E_*`), `error_reporting`, `display_errors`, `log_errors`

## 7. Utilidades essenciais
- [ ] `DateTimeImmutable`, timezones, formatos
- [ ] PCRE (`preg_*`), `mbstring` e Unicode
- [ ] `json_encode/decode` (flags e erros), `serialize` (e perigos)
- [ ] Filesystem: `fopen`, `file_get_contents`, `SplFileObject`, locks
- [ ] Números: precisão de float, `bcmath`, dinheiro em inteiros

## Armadilhas clássicas
- Comparação frouxa, `switch` com `==`, `in_array` sem strict
- Referências em `foreach` (`&$x`) e efeitos colaterais
- `empty("0")` é `true`; `null` vs `isset`
- Ordem de avaliação e operadores (`and` vs `&&`)

## Autoavaliação
1. Por que `"abc" == 0` mudou de resultado no PHP 8?
2. Diferença entre `self` e `static`?
3. Quando um array é copiado de verdade?
4. Para que serve `strict_types` e onde ele vale?
5. `Exception` e `Error`: diferença e como capturar ambos?

## Exercícios
- Reescrever um script legado usando tipos, enums e `match`
- Implementar uma coleção (`Collection`) com `ArrayAccess`, `IteratorAggregate`, `Countable`
- Processar um CSV de milhões de linhas com generators sem estourar memória
- Lista própria de 20 "pegadinhas" e testá-las
