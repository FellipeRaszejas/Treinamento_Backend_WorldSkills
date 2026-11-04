# Laço foreach em PHP

Guia para iniciantes sobre o `foreach`, a estrutura de repetição feita para percorrer coleções de dados, como os arrays: como ler cada item, como obter também o índice (a chave), como concatenar textos e como combiná-lo com `if/else`.

## Sumário

1. [Estrutura do foreach (foreach Structure)](#estrutura-do-foreach-foreach-structure)
2. [Percorrendo uma coleção](#percorrendo-uma-coleção)
3. [Índice e valor (Key and Value)](#índice-e-valor-key-and-value)
4. [Concatenação com o ponto (String Concatenation)](#concatenação-com-o-ponto-string-concatenation)
5. [Misturando regras: foreach com if/else](#misturando-regras-foreach-com-ifelse)
6. [Resumo](#resumo)

## Estrutura do foreach (foreach Structure)

O `foreach` percorre uma coleção do primeiro ao último elemento, entregando um item por volta. Diferente do `for`, você não precisa criar um contador, nem definir a condição de parada, nem atualizar nada: o PHP faz isso sozinho.

**Exemplo cotidiano:** a chamada de uma turma. O professor lê a lista de nomes e, para cada nome, faz a mesma ação (chamar o aluno). Ele não precisa contar quantos alunos existem: quando a lista acaba, a chamada termina.

Um caso comum no desenvolvimento é buscar vários registros no banco de dados (como o MySQL) e percorrê-los para exibir cada um na tela.

```php
foreach ($colecao as $item) {
    // bloco executado uma vez para cada item
}

foreach ($colecao as $chave => $item) {
    // $chave é o índice; $item é o valor
}
```

| Parte | Função |
|---|---|
| `$colecao` | A coleção que será percorrida (por exemplo, um array) |
| `$item` | Variável que recebe o valor do elemento da vez |
| `$chave` | Variável que recebe o índice (a chave) do elemento da vez, quando usada |

## Percorrendo uma coleção

```php
<?php
$TodosOsDados = ["dado01", "dado02", "dado03"];

// 1. O foreach básico para percorrer a coleção
foreach ($TodosOsDados as $DadoIndividual) {
    // Usamos o ponto (.) para concatenar texto com a quebra de linha "\n"
    echo $DadoIndividual . "\n";
}
```

- `$TodosOsDados` é o array com três valores.
- A cada volta, `$DadoIndividual` recebe um dos valores: primeiro `"dado01"`, depois `"dado02"` e por fim `"dado03"`.
- O `echo` exibe o valor da vez seguido de uma quebra de linha.
- Quando o último elemento é processado, o loop termina sozinho.

## Índice e valor (Key and Value)

Para saber **em que posição** cada dado está guardado, use `$indice => $DadoIndividual`. O índice (também chamado de chave, ou *key*, do array) começa em 0; no exemplo, os índices são 0, 1 e 2.

```php
// 2. Resgatando o Índice (Chave) e o Valor juntos
foreach ($TodosOsDados as $indice => $DadoIndividual) {
    echo "Posição [{$indice}] tem o valor: " . $DadoIndividual . "\n";
}
```

| Volta | `$indice` | `$DadoIndividual` | Saída |
|---|---|---|---|
| 1ª | `0` | `"dado01"` | `Posição [0] tem o valor: dado01` |
| 2ª | `1` | `"dado02"` | `Posição [1] tem o valor: dado02` |
| 3ª | `2` | `"dado03"` | `Posição [2] tem o valor: dado03` |

## Concatenação com o ponto (String Concatenation)

No PHP, o ponto (`.`) é o operador que "cola" textos e variáveis em uma única string. Nos exemplos acima, ele junta o valor do dado com a quebra de linha.

| Código | Resultado |
|---|---|
| `$DadoIndividual . "\n"` | O valor do dado seguido de uma quebra de linha |
| `"Posição [{$indice}] tem o valor: " . $DadoIndividual` | O texto fixo, com o índice dentro das chaves, seguido do valor |

> **Atenção:** o `"\n"` quebra a linha no terminal e no código-fonte da página. No navegador, para a quebra aparecer na tela, use `"<br>"` (por exemplo, `echo $DadoIndividual . "<br>";`).

## Misturando regras: foreach com if/else

Você pode colocar estruturas condicionais dentro do `foreach` para validar cada dado de uma coleção, como os que vêm do banco de dados.

```php
// 3. Misturando regras: foreach com if/else para validação de dados
foreach ($TodosOsDados as $DadoIndividual) {
    if ($DadoIndividual == "dado02") {
        echo "Esse é o dado procurado!\n";
    } else {
        echo "Não é o dado procurado.\n";
    }
}
?>
```

- Em cada volta, o `if` compara o dado da vez com `"dado02"`.
- Se forem iguais, exibe "Esse é o dado procurado!"; caso contrário, o `else` exibe "Não é o dado procurado.".
- Com o array do exemplo, a saída é: `Não é o dado procurado.`, `Esse é o dado procurado!` e `Não é o dado procurado.`, nessa ordem.

## Resumo

| Conceito | Como funciona |
|---|---|
| `foreach` | Percorre a coleção do primeiro ao último elemento, sem contador manual (`$i < count(...)`) |
| `$indice => $DadoIndividual` | Entrega o índice e o valor; útil para saber a posição em que o dado está guardado (0, 1, 2...) |
| Concatenação (`.`) | Operador usado para "colar" strings e variáveis |
| `foreach` com `if/else` | Valida ou filtra cada item da coleção; muito usado com dados de bancos de dados e APIs |

Comparativo com o `for`:

| Critério | `for` | `foreach` |
|---|---|---|
| Contador | Você cria e atualiza (`$i++`) | Não precisa |
| Condição de parada | Você escreve (`$i < 365`) | O PHP para no último elemento |
| Melhor uso | Repetir um número conhecido de vezes | Percorrer todos os itens de uma coleção |