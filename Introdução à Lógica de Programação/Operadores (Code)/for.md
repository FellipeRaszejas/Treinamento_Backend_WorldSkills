# Laço for em PHP

Guia para iniciantes sobre o `for`, o laço de repetição usado quando você sabe quantas voltas o código precisa dar: as três partes que o compõem, quando cada uma roda e como o PHP executa cada volta.

## Sumário

1. [Estrutura do for (for Structure)](#estrutura-do-for-for-structure)
2. [Anatomia do for em detalhes (for Anatomy)](#anatomia-do-for-em-detalhes-for-anatomy)
   - [Inicialização (Initialization)](#inicialização-initialization)
   - [Expressão booleana (Boolean Expression)](#expressão-booleana-boolean-expression)
   - [Incremento ou atualização (Increment / Update)](#incremento-ou-atualização-increment--update)
3. [Fluxo na prática](#fluxo-na-prática)
4. [Conteúdo extra: ordenação por bolha](#conteúdo-extra-ordenação-por-bolha)
5. [Resumo](#resumo)

## Estrutura do for (for Structure)

O `for` repete um bloco de código enquanto uma condição for verdadeira. Ele reúne, em uma única linha, tudo o que o loop precisa para funcionar: o ponto de partida, a condição para continuar e a atualização do contador.

**Exemplo cotidiano:** marcar os dias do ano em um calendário. Você começa no dia 0, marca o dia, avança para o próximo e para quando chega ao fim do ano.

```php
for (inicialização; expressão booleana; incremento) {
    // bloco de código repetido a cada volta
}
```

## Anatomia do for em detalhes (for Anatomy)

O `for` tem três partes, separadas por ponto e vírgula, e cada uma roda em um momento diferente.

| Parte | Exemplo | Quando roda | Para que serve |
|---|---|---|---|
| Inicialização | `$i = 0` | Uma única vez, quando o loop começa | Criar a variável de controle (o contador) e dar a ela o valor inicial |
| Expressão booleana | `$i < 365` | Antes de cada volta | Decidir se o loop continua |
| Incremento / atualização | `$i++` | No final de cada volta | Atualizar o contador |

### Inicialização (Initialization)

Roda **apenas uma vez**, no exato momento em que o loop começa. Geralmente é usada para criar a variável de controle (o contador) e dar a ela um valor inicial (o ponto de partida).

### Expressão booleana (Boolean Expression)

Roda **antes de cada volta** do loop. Ela é o guardião do estado: se o resultado for verdadeiro, o bloco de código executa e o loop continua; se for falso, o loop termina imediatamente e o programa segue para o código que vem depois dele.

### Incremento ou atualização (Increment / Update)

Roda **no final de cada volta**, depois que todo o bloco entre chaves termina de executar. Ele atualiza o contador (somando ou subtraindo), o que garante que, em algum momento, a expressão booleana ficará falsa. Sem isso, o loop nunca termina: é o famoso **loop infinito**.

## Fluxo na prática

```php
for($i = 0; $i < 365; $i++){
    echo "dia $i<br>"; 
    var_dump($i);
}
```

Esse código exibe os dias de 0 a 364 (365 voltas). O ciclo exato que o PHP executa é:

1. Cria `$i = 0` (uma única vez).
2. Pergunta: `$i < 365`? Como `0 < 365` é verdadeiro, continua.
3. Entra no bloco: imprime `"dia 0"` e executa `var_dump(0)`.
4. Chega ao final do bloco e executa `$i++`, então `$i` passa a valer `1`.
5. Volta ao passo 2, avalia `1 < 365` e repete o processo até `$i` chegar a `365`, quando a condição fica falsa e o loop termina.

## Conteúdo extra: ordenação por bolha

Dois `for` aninhados (um dentro do outro) permitem percorrer um array várias vezes, comparando elementos vizinhos. Um exemplo clássico é a ordenação por bolha, explicada em um arquivo separado: [Ordenação por bolha (Bubble Sort)](ordenacao-bolha.md).

## Resumo

| Parte do `for` | Exemplo | Roda | Função |
|---|---|---|---|
| Inicialização | `$i = 0` | Uma vez, no início | Criar o contador |
| Expressão booleana | `$i < 365` | Antes de cada volta | Continuar ou parar |
| Incremento | `$i++` | No fim de cada volta | Avançar o contador e evitar o loop infinito |

# Ordenação por bolha (Bubble Sort)

Conteúdo extra do guia [Laço for em PHP](README.md): como ordenar um array usando dois `for` aninhados.

## Sumário

1. [Conceito](#conceito)
2. [Código completo](#código-completo)
3. [A lógica explicada](#a-lógica-explicada)
4. [Passo a passo com o array de exemplo](#passo-a-passo-com-o-array-de-exemplo)
5. [Resumo](#resumo)

## Conceito

A ordenação por bolha (Bubble Sort) compara pares de elementos vizinhos e troca de lugar os que estão fora de ordem. A cada passada completa pelo array, o maior elemento restante "borbulha" até a última posição disponível.

**Exemplo cotidiano:** organizar uma fila de pessoas da mais baixa para a mais alta. Você compara duas pessoas lado a lado e, se a da frente for mais alta, elas trocam de lugar. Repetindo isso da frente até o fim da fila, a pessoa mais alta vai parar no final.

## Código completo

```php
<?php

$arr = [1, 5, 3, 0];
$qtd_elementos_array = count($arr);

for ($i = 0; $i < $qtd_elementos_array - 1; $i++) {
    for ($PosicaoAtual = 0; $PosicaoAtual < $qtd_elementos_array - $i - 1; $PosicaoAtual++) {
        
        $ProximaPosicao = $PosicaoAtual + 1;

        if ($arr[$ProximaPosicao] < $arr[$PosicaoAtual]) {
            $auxiliar = $arr[$PosicaoAtual];
            $arr[$PosicaoAtual] = $arr[$ProximaPosicao];
            $arr[$ProximaPosicao] = $auxiliar;
        }
    }
}

// Exibe o array ordenado
echo "Array ordenado: ";
print_r($arr);

?>
```

## A lógica explicada

1. **O array inicial (`$arr`):** contém os números desordenados `[1, 5, 3, 0]`.
2. **Laço externo (`for` principal):** controla quantas "varreduras", ou passagens completas, serão feitas no array. A cada passada completa, o maior elemento restante "borbulha" para a última posição disponível.
3. **Laço interno (`for` aninhado):** faz as comparações entre vizinhos. Ele compara o elemento de `$PosicaoAtual` com o de `$ProximaPosicao` (`$PosicaoAtual + 1`).
4. **A troca (swap):**
   - Se o elemento da frente for menor que o de trás (`$arr[$ProximaPosicao] < $arr[$PosicaoAtual]`), eles estão fora de ordem.
   - Usamos uma variável temporária chamada `$auxiliar` para guardar um dos valores, evitando que ele seja sobrescrito durante a inversão de lugares entre os dois índices.

## Passo a passo com o array de exemplo

Estado do array ao final de cada passada do laço externo:

| Passada (`$i`) | Comparações feitas | Array depois da passada |
|---|---|---|
| Início | Nenhuma | `[1, 5, 3, 0]` |
| 0 | `1` e `5` (mantém), `5` e `3` (troca), `5` e `0` (troca) | `[1, 3, 0, 5]` |
| 1 | `1` e `3` (mantém), `3` e `0` (troca) | `[1, 0, 3, 5]` |
| 2 | `1` e `0` (troca) | `[0, 1, 3, 5]` |

O resultado exibido por `print_r($arr)` é o array `[0, 1, 3, 5]`.

## Resumo

| Elemento | Função |
|---|---|
| `$arr` | Array que será ordenado |
| `for` externo (`$i`) | Controla o número de passadas |
| `for` interno (`$PosicaoAtual`) | Compara cada par de vizinhos |
| `$auxiliar` | Guarda um valor durante a troca para não perdê-lo |
| `if ($arr[$ProximaPosicao] < $arr[$PosicaoAtual])` | Detecta pares fora de ordem |