# Exceções

Este guia explica o que são exceções em PHP, como lançá-las com `throw` e tratá-las com `try`, `catch` e `finally`, com um exemplo prático de calculadora.

## Sumário

1. [O que é uma exceção](#1-o-que-é-uma-exceção)
2. [Exemplo cotidiano](#2-exemplo-cotidiano)
3. [Lançando exceções com `throw`](#3-lançando-exceções-com-throw)
4. [Tratando exceções com `try` e `catch`](#4-tratando-exceções-com-try-e-catch)
5. [O bloco `finally`](#5-o-bloco-finally)
   - [Para que ele serve](#51-para-que-ele-serve)
   - [Exemplo cotidiano do `finally`](#52-exemplo-cotidiano-do-finally)
6. [Exemplo prático em código](#6-exemplo-prático-em-código)
   - [Como o fluxo acontece](#61-como-o-fluxo-acontece)
7. [Resumo](#7-resumo)

## 1. O que é uma exceção

Exceção é um sinal de que algo inesperado aconteceu durante a execução do programa, como uma divisão por zero ou um arquivo que não existe. Em vez de deixar o programa quebrar, a linguagem permite interromper o fluxo normal, avisar o problema e tratá-lo no lugar certo.

## 2. Exemplo cotidiano

Imagine uma receita de bolo em que faltou um ovo no meio do preparo. Você não continua batendo a massa como se nada tivesse acontecido, e também não joga a cozinha inteira fora. Você para naquele ponto, avisa que falta um ingrediente e decide o que fazer: comprar o ovo, trocar por outro ingrediente ou desistir da receita. A exceção funciona assim: ela interrompe o passo com problema e leva o controle para quem sabe resolvê-lo.

## 3. Lançando exceções com `throw`

O `throw` é a palavra-chave que dispara uma exceção quando uma regra é violada. Ele é usado dentro de uma função ou de um método, geralmente em uma validação.

```php
throw new DivisionByZeroError("Erro: não é possível realizar divisão por zero.");
```

A mensagem entre parênteses descreve o problema, e ela é recuperada depois com `$e->getMessage()`.

## 4. Tratando exceções com `try` e `catch`

O código que pode gerar uma exceção fica dentro do bloco `try`. Se algo der errado, a execução para e o fluxo passa para o bloco `catch` correspondente ao tipo de erro.

| Bloco | Função |
|---|---|
| `try` | Delimita o código que pode gerar erro |
| `catch` | Trata a exceção para o programa continuar |

## 5. O bloco `finally`

O `finally` é um bloco opcional da estrutura `try-catch-finally`. O código dentro dele é sempre executado, ocorrendo uma exceção ou não, e mesmo que a exceção seja capturada ou não pelo `catch`.

### 5.1 Para que ele serve

O `finally` é usado para gerenciamento de recursos e limpeza de estado. Em aplicações reais, quando abrimos um arquivo, uma conexão com banco de dados ou um canal de rede, precisamos garantir que esses recursos sejam fechados ou liberados. Isso evita vazamentos de memória (*memory leaks*) e travamentos, independentemente do sucesso ou da falha da operação.

### 5.2 Exemplo cotidiano do `finally`

Pense em um caixa de banco que abre o caixa no início do expediente. Mesmo que um cliente cause um problema durante o atendimento, ao final do dia o caixa precisa ser fechado e conferido. O fechamento acontece sempre, seja o dia tranquilo ou cheio de imprevistos. O `finally` faz esse papel no código.

## 6. Exemplo prático em código

O exemplo a seguir simula uma calculadora que usa `throw`, `try`, `catch` e `finally`. Ele abre um recurso com `fopen` e o fecha com `fclose` no `finally`. O código completo e executável está no arquivo [`exemplo-finally.php`](exemplo-finally.php).

```php
<?php

function dividir(float $numerador, float $denominador): float
{
    // throw: lança uma exceção quando a regra de negócio é violada
    if ($denominador === 0.0) {
        throw new DivisionByZeroError("Erro: não é possível realizar divisão por zero.");
    }

    return $numerador / $denominador;
}

function executarCalculo(float $num1, float $num2): void
{
    $recurso = fopen('php://memory', 'r+'); // recurso aberto manualmente

    try {
        echo "Iniciando o processo de cálculo...\n";

        $resultado = dividir($num1, $num2);
        echo "O resultado é: {$resultado}\n";

    } catch (DivisionByZeroError $e) {
        // catch: trata o erro sem quebrar o programa
        echo "Exceção capturada no catch: " . $e->getMessage() . "\n";

    } finally {
        // finally: executa sempre, com ou sem exceção
        fclose($recurso);
        echo "[FINALLY]: Fechando recursos e finalizando a operação da calculadora.\n\n";
    }
}

executarCalculo(10.0, 0.0); // cai no catch
executarCalculo(10.0, 2.0); // executa normalmente

echo "O programa continua rodando normalmente após o tratamento.\n";
```

### 6.1 Como o fluxo acontece

1. **Tentativa (`try`):** a função tenta executar `dividir(10.0, 0.0)`.
2. **Lançamento (`throw`):** dentro de `dividir`, a validação identifica que o divisor é zero e dispara a exceção. A execução do `try` é interrompida ali.
3. **Captura (`catch`):** o fluxo desvia para o `catch`, que trata `DivisionByZeroError` e exibe a mensagem sem quebrar o programa.
4. **Finalização (`finally`):** o `finally` fecha o recurso com `fclose` e exibe a mensagem de limpeza. Isso acontece tanto no caso com erro quanto no caso de sucesso.
5. **Continuidade:** o programa segue e executa a segunda chamada, `executarCalculo(10.0, 2.0)`.

## 7. Resumo

| Situação | `try` | `catch` | `finally` |
|---|---|---|---|
| Operação dá certo | Executa até o fim | Não entra | Executa |
| Exceção é capturada | Interrompido no ponto do erro | Executa | Executa |
| Exceção não é capturada | Interrompido no ponto do erro | Não entra | Executa antes de propagar o erro |

| Conceito | Função |
|---|---|
| `throw` | Dispara uma exceção quando uma regra é violada |
| `try` | Delimita o código que pode gerar erro |
| `catch` | Trata o erro para o programa continuar |
| `finally` | Garante a limpeza de recursos, sempre |