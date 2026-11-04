# Incremento e decremento em PHP

Guia para iniciantes sobre os operadores `++` e `--`, que somam ou subtraem 1 de uma variável, e sobre a diferença entre colocá-los antes (`++$a`) ou depois (`$a++`) da variável.

## Sumário

1. [Pré-incremento e pré-decremento (Pre-increment and Pre-decrement)](#pré-incremento-e-pré-decremento-pre-increment-and-pre-decrement)
2. [Pós-incremento e pós-decremento (Post-increment and Post-decrement)](#pós-incremento-e-pós-decremento-post-increment-and-post-decrement)
   - [Lado a lado com o pré-incremento](#lado-a-lado-com-o-pré-incremento)
3. [Uso em loops](#uso-em-loops)
4. [Resumo](#resumo)

## Pré-incremento e pré-decremento (Pre-increment and Pre-decrement)

Com `++$a` e `--$a`, o PHP **primeiro** altera o valor da variável (soma ou subtrai 1) e **depois** usa esse novo valor na expressão.

**Exemplo cotidiano:** é como um placar de jogo em que você marca o ponto primeiro e só depois olha o placar. O valor que você vê já inclui o ponto novo.

```php
$a = 5;
// O PHP soma 1 ANTES de comparar. 
// $a vira 6, e aí ele compara: 6 == 6 (Verdadeiro)
if (++$a == 6) { 
    echo "Entrou!"; 
}
```

- `$a = 5;` guarda o valor inicial.
- `++$a` soma 1 e, com isso, `$a` passa a valer 6.
- A comparação `6 == 6` é verdadeira, então o `echo` é executado.

## Pós-incremento e pós-decremento (Post-increment and Post-decrement)

Com `$a++` e `$a--`, o PHP **primeiro** usa o valor atual da variável na expressão e, logo em seguida, soma ou subtrai 1.

**Exemplo cotidiano:** agora você olha o placar primeiro e só depois marca o ponto. O valor que você leu é o de antes do ponto novo.

```php
$a = 5;
// O PHP usa o valor atual (5) para comparar: 5 == 5 (Verdadeiro).
// Só depois da comparação, ele incrementa o $a para 6.
if ($a++ == 5) {
    echo "Entrou!";
}

var_dump($a); // int(6)
```

- A comparação usa o valor atual, `5`, então `5 == 5` é verdadeira e o `echo` é executado.
- Depois de usar o valor, o PHP soma 1, e `$a` passa a valer 6.
- Por isso, o `var_dump($a)` logo abaixo mostra `int(6)`.

### Lado a lado com o pré-incremento

O jeito mais fácil de enxergar a diferença é exibir o valor e, em seguida, olhar a variável.

```php
$pos = 5;
echo $pos++; // Exibe 5 (valor de antes)
echo $pos;   // Exibe 6 (já somado)

$pre = 5;
echo ++$pre; // Exibe 6 (já somado)
echo $pre;   // Exibe 6
```

- Com `$pos++`, o `echo` mostra o valor **antes** da soma (5); só na linha seguinte aparece o 6.
- Com `++$pre`, o `echo` já mostra o valor **depois** da soma (6).
- Nos dois casos a variável termina valendo 6; o que muda é o valor entregue no momento em que a expressão é usada.

## Uso em loops

Os operadores de incremento e decremento são muito usados em loops (`while`, `for`), contadores e paginação. Dentro de um loop, quando a instrução está sozinha na linha, tanto faz usar `++$contador` ou `$contador++`: o resultado é o mesmo.

```php
<?php
$contador = 0;

// Enquanto o contador for menor que 3, ele roda e soma 1
while ($contador < 3) {
    echo "Rodada: " . $contador . "<br>";
    $contador++; // Aqui tanto faz ser ++$contador ou $contador++, pois está isolado na linha
}
?>
```

- O loop começa com `$contador` valendo 0.
- A cada volta, exibe a rodada e soma 1.
- Quando `$contador` chega a 3, a condição `$contador < 3` fica falsa e o loop termina (as rodadas exibidas são 0, 1 e 2).

## Resumo

Comparativo com `$a = 5` no início de cada linha:

| Operador | Nome | O que a expressão devolve | Valor de `$a` depois |
|---|---|---|---|
| `++$a` | Pré-incremento | 6 (já somado) | 6 |
| `$a++` | Pós-incremento | 5 (valor de antes) | 6 |
| `--$a` | Pré-decremento | 4 (já subtraído) | 4 |
| `$a--` | Pós-decremento | 5 (valor de antes) | 4 |

| Situação | Qual usar |
|---|---|
| Precisa do valor **já alterado** na própria expressão | `++$a` ou `--$a` |
| Precisa do valor **de antes** na própria expressão | `$a++` ou `$a--` |
| A instrução está sozinha na linha (ex.: dentro de um loop) | Qualquer um dos dois |