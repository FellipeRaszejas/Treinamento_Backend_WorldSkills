# Hierarquia de Exceções no PHP

Este guia mostra como o PHP organiza os erros e exceções em uma hierarquia de classes, a partir da interface `Throwable`, e quando usar cada categoria no seu código.

## Sumário

1. [Visão geral da hierarquia](#1-visão-geral-da-hierarquia)
2. [O topo: `Throwable`](#2-o-topo-throwable)
3. [Os dois ramos principais: `Error` e `Exception`](#3-os-dois-ramos-principais-error-e-exception)
4. [Subcategorias de `Exception`](#4-subcategorias-de-exception)
   - [`RuntimeException`: erros de tempo de execução](#41-runtimeexception-erros-de-tempo-de-execução)
   - [`LogicException`: erros de lógica de programação](#42-logicexception-erros-de-lógica-de-programação)
5. [Exemplo cotidiano](#5-exemplo-cotidiano)
6. [Exemplo prático em código](#6-exemplo-prático-em-código)
7. [Resumo](#7-resumo)

## 1. Visão geral da hierarquia

```
Throwable (interface)
├── Error                        → erros internos do PHP
│   ├── TypeError
│   ├── ValueError
│   ├── ArithmeticError
│   │   └── DivisionByZeroError
│   └── ...
└── Exception                    → exceções da aplicação
    ├── RuntimeException         → erros em tempo de execução
    │   ├── UnexpectedValueException
    │   ├── UnderflowException
    │   ├── OverflowException
    │   ├── RangeException
    │   └── OutOfBoundsException
    └── LogicException           → erros de lógica do código
        ├── BadFunctionCallException
        │   └── BadMethodCallException
        ├── DomainException
        ├── InvalidArgumentException
        ├── LengthException
        └── OutOfRangeException
```

Cada nível especializa o anterior. Quanto mais abaixo uma classe está, mais específica ela é.

## 2. O topo: `Throwable`

`Throwable` é a interface raiz do PHP para qualquer objeto que pode ser lançado com a palavra-chave `throw`. Isso vale tanto para exceções criadas por você (`throw new ...`) quanto para erros gerados pelo próprio motor do PHP.

Como `Error` e `Exception` implementam `Throwable`, todo erro que pode ser capturado em um `try/catch` implementa essa interface. Por isso, `catch (Throwable $e)` captura qualquer um deles.

## 3. Os dois ramos principais: `Error` e `Exception`

A partir de `Throwable`, o PHP separa os problemas em duas categorias.

**`Error` (erros internos do motor):** representa falhas do próprio PHP, como passar um tipo errado para uma função (`TypeError`) ou dividir por zero (`DivisionByZeroError`). Em geral, ele indica bug no código ou problema no ambiente, e não um evento esperado. Por isso, você normalmente não deve capturá-lo de forma rotineira. Alguns erros, como o esgotamento de memória, são *Fatal errors* e não podem ser capturados.

**`Exception` (exceções da aplicação):** é a classe base das exceções da aplicação. São os problemas que o programador captura e trata no dia a dia, como falha de conexão com o banco de dados ou dados inválidos enviados por um usuário.

| Categoria | Origem | Deve ser capturada? | Exemplo |
|---|---|---|---|
| `Error` | Motor do PHP ou bug | Normalmente não | `TypeError`, `DivisionByZeroError` |
| `Exception` | Aplicação | Sim, para tratar | `InvalidArgumentException`, `RuntimeException` |

## 4. Subcategorias de `Exception`

A classe `Exception` se divide em dois ramos que diferenciam **quando** e **por que** o erro aconteceu.

### 4.1 `RuntimeException`: erros de tempo de execução

**Conceito:** erros que só podem ser detectados durante a execução do código, geralmente causados por fatores externos, como falhas de rede, arquivos inexistentes ou dados corrompidos. O código pode estar correto, mas a situação real não é a esperada.

| Classe | Quando é lançada |
|---|---|
| `UnexpectedValueException` | O valor não pertence ao conjunto de valores esperado |
| `UnderflowException` | Tenta-se remover um elemento de uma estrutura de dados vazia |
| `OverflowException` | Tenta-se adicionar um elemento a uma estrutura que já está cheia |
| `RangeException` | Um cálculo ou valor de tempo de execução fica fora do intervalo aceitável |
| `OutOfBoundsException` | Tenta-se acessar uma chave ou índice que não existe |

### 4.2 `LogicException`: erros de lógica de programação

**Conceito:** bugs no código. O programador escreveu algo incorreto, como passar um argumento inválido para uma função. Esses erros devem ser corrigidos no código-fonte antes de o sistema ir para produção, e não tratados em tempo de execução.

| Classe | Quando é lançada |
|---|---|
| `BadFunctionCallException` | Uma função chamada não existe ou o callback é inválido |
| `BadMethodCallException` | Tenta-se chamar um método que não existe ou não é acessível |
| `DomainException` | O valor viola uma regra de domínio, como um número negativo onde só se aceita positivo |
| `InvalidArgumentException` | O argumento passado tem tipo ou valor incorreto |
| `LengthException` | Um comprimento (de string, array etc.) excede o limite permitido |
| `OutOfRangeException` | Um índice está fora da faixa válida, indicando erro na lógica do código |

**Atenção:** `OutOfBoundsException` (runtime) e `OutOfRangeException` (lógica) são parecidas, mas pertencem a ramos diferentes. A diferença está na origem do erro: a primeira ocorre com dados reais em execução, e a segunda indica um erro na lógica do código.

## 5. Exemplo cotidiano

Pense em um restaurante. Os problemas que podem acontecer se dividem em tipos diferentes:

* **Problema estrutural da cozinha** (o fogão quebrou, faltou energia): é o equivalente a um `Error`. Não é algo que o atendente resolve sozinho, e indica um problema grave no ambiente.
* **Problema que o atendente resolve** (o cliente pediu um prato que acabou, o cartão foi recusado): é o equivalente a uma `Exception`. O atendente sabe o que fazer e segue o atendimento.
* **Dentro das exceções**, há os imprevistos do dia a dia (a conexão da máquina de cartão caiu, um ingrediente acabou no meio do preparo), que são `RuntimeException`, e os erros de procedimento, como anotar um pedido sem informar o prato, que são `LogicException`.

## 6. Exemplo prático em código

O exemplo a seguir mostra por que a ordem dos `catch` importa. Como o PHP testa os blocos de cima para baixo, as classes mais específicas devem vir antes das mais genéricas.

```php
<?php

function validarIdade(int $idade): void
{
    if ($idade < 0) {
        // LogicException: argumento inválido, erro de lógica ao chamar a função
        throw new InvalidArgumentException("A idade não pode ser negativa.");
    }

    if ($idade > 150) {
        // RuntimeException: valor fora do intervalo aceitável em tempo de execução
        throw new RangeException("Idade acima do limite aceitável.");
    }
}

try {
    validarIdade(-5);
} catch (InvalidArgumentException $e) {
    // Classe mais específica primeiro
    echo "Argumento inválido: " . $e->getMessage() . "\n";
} catch (LogicException $e) {
    // Classe pai, pega outros erros de lógica
    echo "Erro de lógica: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    // Qualquer exceção da aplicação que não caiu nos blocos acima
    echo "Exceção da aplicação: " . $e->getMessage() . "\n";
} catch (Throwable $e) {
    // Último recurso: inclui também os objetos do tipo Error
    echo "Erro geral: " . $e->getMessage() . "\n";
}
```

Se o bloco `catch (InvalidArgumentException $e)` ficasse depois de `catch (LogicException $e)`, ele nunca seria executado, porque `LogicException` já captura tudo o que ele captura.

## 7. Resumo

| Classe | Ramo | Tipo de problema | Deve capturar? |
|---|---|---|---|
| `Throwable` | Interface raiz | Qualquer coisa que pode ser lançada | É o tipo do `catch` mais amplo |
| `Error` | Motor do PHP | Falha interna ou bug | Normalmente não |
| `Exception` | Aplicação | Problema tratável | Sim |
| `RuntimeException` | `Exception` | Ocorre durante a execução | Sim |
| `LogicException` | `Exception` | Bug no código | Corrigir o código |