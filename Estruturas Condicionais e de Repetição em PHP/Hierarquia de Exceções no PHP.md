# Hierarquia de Exceções no PHP

Este guia mostra como o PHP organiza os erros e as exceções em uma hierarquia de classes, a partir da interface `Throwable`, e apresenta cada classe do diagrama com seu conceito e um exemplo de uso.

## Sumário

1. [Visão geral da hierarquia](#1-visão-geral-da-hierarquia)
2. [O topo: `Throwable`](#2-o-topo-throwable)
3. [Os ramos principais: `Error` e `Exception`](#3-os-ramos-principais-error-e-exception)
4. [Ramo de tempo de execução: `RuntimeException`](#4-ramo-de-tempo-de-execução-runtimeexception)
   - [`UnexpectedValueException`](#41-unexpectedvalueexception)
   - [`UnderflowException`](#42-underflowexception)
   - [`RangeException`](#43-rangeexception)
   - [`OverflowException`](#44-overflowexception)
   - [`OutOfBoundsException`](#45-outofboundsexception)
5. [Ramo de lógica: `LogicException`](#5-ramo-de-lógica-logicexception)
   - [`BadFunctionCallException`](#51-badfunctioncallexception)
   - [`BadMethodCallException`](#52-badmethodcallexception)
   - [`DomainException`](#53-domainexception)
   - [`InvalidArgumentException`](#54-invalidargumentexception)
   - [`LengthException`](#55-lengthexception)
   - [`OutOfRangeException`](#56-outofrangeexception)
6. [Exemplo cotidiano](#6-exemplo-cotidiano)
7. [Exemplo prático em código](#7-exemplo-prático-em-código)
8. [Resumo](#8-resumo)

## 1. Visão geral da hierarquia

![Diagrama da hierarquia de exceções do PHP, com Throwable no topo, Error e Exception logo abaixo, e as subclasses de RuntimeException e LogicException](imagens/hierarquia-excecoes.png)

*Diagrama da hierarquia de exceções. As setas apontam da classe filha para a classe pai.*

Cada nível especializa o anterior. Quanto mais abaixo uma classe está, mais específica ela é.

## 2. O topo: `Throwable`

`Throwable` é a interface raiz do PHP para qualquer objeto que pode ser lançado com a palavra-chave `throw`. Isso vale tanto para exceções criadas por você (`throw new ...`) quanto para erros gerados pelo próprio motor do PHP.

Como `Error` e `Exception` implementam `Throwable`, todo erro que pode ser capturado em um `try/catch` implementa essa interface. Por isso, `catch (Throwable $e)` captura qualquer um deles.

## 3. Os ramos principais: `Error` e `Exception`

**`Error` (erros internos do motor):** representa falhas do próprio PHP, como passar um tipo errado para uma função (`TypeError`) ou dividir por zero (`DivisionByZeroError`). Em geral, indica bug no código ou problema no ambiente, e não um evento esperado. Por isso, normalmente não se captura `Error` de forma rotineira. Alguns erros, como o esgotamento de memória, são *Fatal errors* e não podem ser capturados.

**`Exception` (exceções da aplicação):** é a classe base das exceções da aplicação. São os problemas que o programador captura e trata no dia a dia, como falha de conexão com o banco de dados ou dados inválidos enviados por um usuário. Ela se divide em dois ramos: `RuntimeException` e `LogicException`.

| Categoria | Origem | Deve ser capturada? | Exemplo |
|---|---|---|---|
| `Error` | Motor do PHP ou bug | Normalmente não | `TypeError`, `DivisionByZeroError` |
| `Exception` | Aplicação | Sim, para tratar | `RuntimeException`, `LogicException` |

## 4. Ramo de tempo de execução: `RuntimeException`

**Conceito:** erros que só podem ser detectados durante a execução do código, geralmente causados por fatores externos, como falhas de rede, arquivos inexistentes ou dados corrompidos. O código pode estar correto, mas a situação real não é a esperada.

### 4.1 `UnexpectedValueException`

**Conceito:** o valor recebido não pertence ao conjunto de valores esperado.

**Exemplo:** uma função que retorna o status de um pedido e recebe um código que o sistema não conhece.

```php
throw new UnexpectedValueException("Status de pedido desconhecido: {$status}");
```

### 4.2 `UnderflowException`

**Conceito:** tentativa de remover um elemento de uma estrutura de dados que está vazia. É o oposto de *overflow*.

**Exemplo:** retirar um item de uma pilha ou fila sem elementos.

```php
throw new UnderflowException("Não é possível remover: a pilha está vazia.");
```

### 4.3 `RangeException`

**Conceito:** um valor calculado durante a execução fica fora do intervalo aceitável.

**Exemplo:** uma nota calculada que ultrapassa o intervalo de 0 a 10.

```php
throw new RangeException("A nota deve estar entre 0 e 10.");
```

### 4.4 `OverflowException`

**Conceito:** tentativa de adicionar um elemento a uma estrutura de dados que já atingiu a capacidade máxima.

**Exemplo:** colocar um pedido em uma fila que já tem o número máximo de vagas.

```php
throw new OverflowException("A fila está cheia: limite de 10 pedidos.");
```

### 4.5 `OutOfBoundsException`

**Conceito:** tentativa de acessar uma chave ou um índice que não existe no array ou na coleção durante a execução.

**Exemplo:** buscar um item pelo código em um cadastro, e o código não existe.

```php
throw new OutOfBoundsException("Produto com código {$codigo} não encontrado.");
```

## 5. Ramo de lógica: `LogicException`

**Conceito:** bugs no código. O programador escreveu algo incorreto, como passar um argumento inválido para uma função. Esses erros devem ser corrigidos no código-fonte antes de o sistema ir para produção, e não tratados em tempo de execução.

### 5.1 `BadFunctionCallException`

**Conceito:** uma função ou um *callback* chamado não existe ou não é válido.

**Exemplo:** uma função que recebe o nome de uma ação e a executa, mas recebe um nome que não corresponde a nenhuma função.

```php
throw new BadFunctionCallException("O callback informado não é uma função válida.");
```

### 5.2 `BadMethodCallException`

**Conceito:** tentativa de chamar um método que não existe ou que não pode ser chamado naquele momento.

**Exemplo:** chamar `salvar()` em um objeto que ainda não foi configurado com a conexão.

```php
throw new BadMethodCallException("Não é possível salvar sem uma conexão configurada.");
```

**Observação:** no PHP, `BadMethodCallException` herda de `BadFunctionCallException`. O diagrama da imagem mostra essa classe ao lado das outras de `LogicException`, mas a relação de herança correta é a que foi indicada aqui.

### 5.3 `DomainException`

**Conceito:** o valor viola uma regra de domínio do negócio, ou seja, está fora do conjunto de valores que faz sentido para aquela regra.

**Exemplo:** aplicar um desconto de 120% em um produto.

```php
throw new DomainException("O desconto não pode ser maior que 100%.");
```

### 5.4 `InvalidArgumentException`

**Conceito:** um argumento passado para uma função tem tipo ou valor incorreto.

**Exemplo:** cadastrar um e-mail sem o caractere `@`.

```php
throw new InvalidArgumentException("E-mail inválido: falta o caractere @.");
```

### 5.5 `LengthException`

**Conceito:** um comprimento (de string, array ou outra estrutura) excede o limite permitido pela lógica do código.

**Exemplo:** uma senha com mais caracteres do que a regra permite.

```php
throw new LengthException("A senha pode ter no máximo 20 caracteres.");
```

### 5.6 `OutOfRangeException`

**Conceito:** um índice está fora da faixa válida, e o erro está na lógica do código, e não nos dados externos.

**Exemplo:** um cálculo de posição que gera um índice maior que o tamanho da lista, por causa de um erro na lógica.

```php
throw new OutOfRangeException("Índice {$indice} fora da faixa válida da lista.");
```

**Atenção:** `OutOfBoundsException` (runtime) e `OutOfRangeException` (lógica) são parecidas, mas pertencem a ramos diferentes. A diferença está na origem do erro: a primeira ocorre com dados reais em execução, e a segunda indica erro na lógica do código.

## 6. Exemplo cotidiano

Pense em um restaurante. Os problemas que podem acontecer se dividem em tipos diferentes:

* **Problema estrutural da cozinha** (o fogão quebrou, faltou energia): é o equivalente a um `Error`. Não é algo que o atendente resolve sozinho, e indica um problema grave no ambiente.
* **Problema que o atendente resolve** (o cliente pediu um prato que acabou, o cartão foi recusado): é o equivalente a uma `Exception`. O atendente sabe o que fazer e segue o atendimento.
* **Dentro das exceções**, os imprevistos do dia a dia (a máquina de cartão perdeu a conexão, um ingrediente acabou no meio do preparo) são `RuntimeException`. Os erros de procedimento, como anotar um pedido sem informar o prato, são `LogicException`.

## 7. Exemplo prático em código

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

## 8. Resumo

| Classe | Ramo | Tipo de problema | Deve capturar? |
|---|---|---|---|
| `Throwable` | Interface raiz | Qualquer coisa que pode ser lançada | É o tipo do `catch` mais amplo |
| `Error` | Motor do PHP | Falha interna ou bug | Normalmente não |
| `Exception` | Aplicação | Problema tratável | Sim |
| `UnexpectedValueException` | `RuntimeException` | Valor fora do conjunto esperado | Sim |
| `UnderflowException` | `RuntimeException` | Remoção em estrutura vazia | Sim |
| `RangeException` | `RuntimeException` | Valor fora do intervalo em execução | Sim |
| `OverflowException` | `RuntimeException` | Inserção em estrutura cheia | Sim |
| `OutOfBoundsException` | `RuntimeException` | Chave ou índice inexistente em execução | Sim |
| `BadFunctionCallException` | `LogicException` | Função ou callback inválido | Corrigir o código |
| `BadMethodCallException` | `LogicException` | Método inexistente ou inacessível | Corrigir o código |
| `DomainException` | `LogicException` | Valor fora da regra de domínio | Corrigir o código |
| `InvalidArgumentException` | `LogicException` | Argumento com tipo ou valor incorreto | Corrigir o código |
| `LengthException` | `LogicException` | Comprimento acima do limite | Corrigir o código |
| `OutOfRangeException` | `LogicException` | Índice fora da faixa por erro de lógica | Corrigir o código |