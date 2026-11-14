# Entrada de dados e intval em PHP

Este guia explica como o PHP lê números digitados pelo usuário com `fgets(STDIN)`, como a função `intval` converte esse texto em número inteiro e como os três códigos de exemplo (soma, tempo e soma com filtro) funcionam passo a passo.

## Sumário

1. [Estrutura básica do código](#estrutura-básica-do-código)
2. [fgets(STDIN)](#fgetsstdin)
3. [intval](#intval)
4. [echo e variáveis dentro de aspas duplas](#echo-e-variáveis-dentro-de-aspas-duplas)
5. [Operadores usados](#operadores-usados)
6. [Código 1: soma de dois números](#código-1-soma-de-dois-números)
7. [Código 2: distância e tempo](#código-2-distância-e-tempo)
8. [Código 3: soma sem os múltiplos de 3](#código-3-soma-sem-os-múltiplos-de-3)
9. [Resumo](#resumo)

## Estrutura básica do código

Os três códigos seguem o mesmo roteiro de **entrada → processamento → saída**:

| Etapa | O que acontece | Onde aparece no código |
|---|---|---|
| Entrada | O programa lê o que foi digitado | `fgets(STDIN)` |
| Conversão | O texto vira número inteiro | `intval(...)` |
| Processamento | O programa faz a conta | `+`, `*`, `for`, `if` |
| Saída | O resultado é mostrado na tela | `echo` |

Os trechos `<?php` e `?>` indicam onde o código PHP começa e termina. Tudo o que vem depois de `//` é um comentário: o PHP ignora essas linhas, elas servem apenas para explicar o código a quem lê.

## fgets(STDIN)

**Conceito:** `fgets` lê **uma linha** de texto de uma fonte. `STDIN` (*Standard Input*, entrada padrão) é a fonte: tudo o que é digitado no teclado (ou enviado ao programa pela plataforma do desafio).

**Exemplo do dia a dia:** imagine um caixa de mercado que lê um bilhete por vez. Cada chamada de `fgets(STDIN)` é como pegar o próximo bilhete da pilha e ler o que está escrito nele.

```php
$linha = fgets(STDIN);
```

Pontos importantes:

- O valor lido é sempre **texto** (*string*), mesmo que você digite `5`. O PHP recebe `"5\n"`.
- O `\n` no final é a quebra de linha, gerada quando o usuário aperta Enter. Ela também vem junto no texto.
- Cada chamada lê a **próxima** linha. Por isso o primeiro código chama `fgets(STDIN)` duas vezes: uma para `$a` e outra para `$b`.
- Se não houver mais nada para ler (fim da entrada), `fgets` devolve `false`.

## intval

**Conceito:** `intval` (*integer value*, valor inteiro) converte um valor qualquer em um número inteiro. Em PHP, ela é a forma mais comum de transformar o texto lido por `fgets` em número que pode entrar em contas.

**Exemplo do dia a dia:** pense em um bilhete com `"5"` escrito à caneta. Você enxerga o desenho do número, mas só consegue somar quando entende que aquilo vale cinco unidades. O `intval` faz essa "tradução" de texto para quantidade.

```php
$numero = intval("42");   // 42 (número inteiro)
```

### Como o intval se comporta

| Valor recebido | Resultado | Por quê |
|---|---|---|
| `"42"` | `42` | Texto com número vira inteiro |
| `"42\n"` | `42` | Espaços e quebra de linha no final são ignorados |
| `"  7"` | `7` | Espaços no começo também são ignorados |
| `"42abc"` | `42` | Lê os dígitos do começo e para na primeira letra |
| `"abc"` | `0` | Sem dígitos no começo, o resultado é zero |
| `3.9` | `3` | Corta a parte decimal (não arredonda) |
| `-3.9` | `-3` | Corta a parte decimal, indo em direção ao zero |
| `true` | `1` | Verdadeiro vale 1 |
| `false` | `0` | Falso vale 0 (também é o que `fgets` devolve no fim da entrada) |
| `null` | `0` | Valor vazio vira zero |

Por isso `intval(fgets(STDIN))` funciona bem: o `"5\n"` que chega do teclado vira simplesmente `5`, sem o `\n`.

### Segundo parâmetro: a base numérica

`intval` aceita um segundo argumento opcional, que indica a **base** do número (o padrão é 10, a base decimal).

```php
echo intval("101", 2);   // 5  (101 em binário vale 5)
echo intval("ff", 16);   // 255 (ff em hexadecimal vale 255)
```

Nos desafios deste guia a base padrão é suficiente, então usamos só `intval(texto)`.

### Funções parecidas

| Forma | Exemplo | Resultado |
|---|---|---|
| `intval($x)` | `intval("12")` | `12` |
| Conversão com `(int)` | `(int) "12"` | `12` |
| `floatval($x)` | `floatval("3.5")` | `3.5` (número com casas decimais) |
| `strval($x)` | `strval(12)` | `"12"` (texto) |

`intval($x)` e `(int) $x` fazem a mesma coisa na maioria dos casos. A diferença é que `intval` é uma função e aceita a base como segundo argumento.

## echo e variáveis dentro de aspas duplas

**Conceito:** `echo` envia texto para a saída (a tela). Quando o texto está entre **aspas duplas** `" "`, o PHP troca o nome da variável pelo valor dela. Esse recurso se chama **interpolação**.

**Exemplo do dia a dia:** é como um formulário de carta com lacunas: "Olá, ____!". Você escreve o modelo uma vez e o PHP preenche a lacuna com o valor da variável.

```php
$nome = "Ana";
echo "Olá, $nome!\n";   // Olá, Ana!
```

| Aspas | Substitui a variável? | Exemplo | Resultado |
|---|---|---|---|
| Duplas `" "` | Sim | `echo "Soma: $soma";` | `Soma: 8` |
| Simples `' '` | Não | `echo 'Soma: $soma';` | `Soma: $soma` |

O `\n` dentro das aspas duplas é uma **quebra de linha**: depois de imprimir o texto, o cursor vai para a linha de baixo. Nos desafios, a saída precisa ter exatamente o formato pedido, por isso o `\n` aparece no final.

## Operadores usados

| Operador | Nome | Exemplo | O que faz |
|---|---|---|---|
| `+` | Soma | `$a + $b` | Soma os dois valores |
| `*` | Multiplicação | `$distancia * 2` | Multiplica os valores |
| `%` | Módulo (resto da divisão) | `$i % 3` | Devolve o que sobra da divisão por 3 |
| `!=` | Diferente de | `$i % 3 != 0` | Verdadeiro quando os valores são diferentes |
| `<=` | Menor ou igual | `$i <= $numero` | Verdadeiro quando o da esquerda não é maior |
| `+=` | Soma e guarda | `$soma += $i` | Equivale a `$soma = $soma + $i` |
| `++` | Incremento | `$i++` | Aumenta `$i` em 1 |

**Sobre o `%`:** se você divide 10 balas entre 3 amigos, cada um recebe 3 e **sobra 1**. Esse "sobra 1" é o resultado de `10 % 3`. Quando o resto é `0`, a divisão é exata, ou seja, o número é **divisível**.

## Código 1: soma de dois números

**Objetivo:** ler dois números inteiros (um por linha) e imprimir a soma no formato `SOMA = valor`.

```php
<?php
  // Leia o Desafio e siga o código base abaixo para resolvê-lo. Algumas dicas:
  // 1. Use a função "fgets(STDIN)" para ler uma linha de Entrada;
  // 2. Use a função "echo" formatar e imprimir sua(s) Saída(s).

  $a = intval(fgets(STDIN));
  $b = intval(fgets(STDIN));
  
  // Cria a variável para receber a soma de $a e $b
  $soma = $a + $b;

  // Imprime no formato exigido: SOMA = valor (com quebra de linha ao final)
  echo "SOMA = $soma\n";
?>
```

### Explicação das partes

| Trecho | O que faz |
|---|---|
| `fgets(STDIN)` | Lê uma linha digitada (por exemplo, `"3\n"`) |
| `intval(...)` | Converte esse texto para o número inteiro `3` |
| `$a = ...` / `$b = ...` | Guarda cada número em uma variável. A primeira chamada lê a 1ª linha e a segunda lê a 2ª |
| `$soma = $a + $b;` | Soma os dois números e guarda o resultado |
| `echo "SOMA = $soma\n";` | Imprime o texto fixo `SOMA = ` seguido do valor de `$soma` e uma quebra de linha |

### Exemplo de execução

| Entrada | Saída |
|---|---|
| `3` | `SOMA = 8` |
| `5` | |

## Código 2: distância e tempo

**Objetivo:** ler uma distância em quilômetros e calcular o tempo, sabendo que cada quilômetro leva 2 minutos.

```php
<?php
  // Leia o Desafio e siga o código base abaixo para resolvê-lo. Algumas dicas:
  // 1. Use a função "fgets(STDIN)" para ler uma linha de Entrada;
  // 2. Use a função "echo" formatar e imprimir sua(s) Saída(s).

  $distancia = intval(fgets(STDIN));

  // Cada quilômetro de distância leva 2 minutos para ser acumulado
  $tempo = $distancia * 2;

  // Imprime o tempo calculado seguido da mensagem " minutos" e quebra de linha
  echo "$tempo minutos\n";
?>
```

### Explicação das partes

| Trecho | O que faz |
|---|---|
| `intval(fgets(STDIN))` | Lê a linha digitada e a transforma em número inteiro |
| `$tempo = $distancia * 2;` | Multiplica a distância por 2, pois cada km leva 2 minutos |
| `echo "$tempo minutos\n";` | Imprime o valor de `$tempo`, o texto ` minutos` e uma quebra de linha |

**Exemplo do dia a dia:** é como a regra de uma receita: "cada porção leva 2 minutos de preparo". Para 5 porções, são 5 × 2 = 10 minutos.

### Exemplo de execução

| Entrada | Saída |
|---|---|
| `5` | `10 minutos` |

## Código 3: soma sem os múltiplos de 3

**Objetivo:** ler um número `N` e somar todos os números de 1 até `N`, **pulando** os que são divisíveis por 3.

```php
<?php
  // Leia o Desafio e siga o código base abaixo para resolvê-lo. Algumas dicas:
  // 1. Use a função "fgets(STDIN)" para ler uma linha de Entrada;
  // 2. Use a função "echo" formatar e imprimir sua(s) Saída(s).

  $numero = intval(fgets(STDIN));

  $soma = 0;

  // Percorre todos os números de 1 até o número fornecido
  for ($i = 1; $i <= $numero; $i++) {
      // Adiciona à soma apenas se o número NÃO for divisível por 3
      if ($i % 3 != 0) {
          $soma += $i;
      }
  }

  // Imprime o resultado no formato exigido
  echo "Soma dos números de 1 a $numero, exceto os divisíveis por 3: $soma\n";
?>
```

### Explicação das partes

| Trecho | O que faz |
|---|---|
| `$soma = 0;` | Cria o "acumulador" começando em zero. Sem isso, não haveria onde guardar a soma |
| `for (...)` | Repete o bloco de código várias vezes |
| `$i = 1` | Começa a contagem no número 1 |
| `$i <= $numero` | Continua repetindo enquanto `$i` não passar do número lido |
| `$i++` | A cada volta, aumenta `$i` em 1 |
| `if ($i % 3 != 0)` | Testa se o resto da divisão por 3 é **diferente de zero** (ou seja, se `$i` **não** é múltiplo de 3) |
| `$soma += $i;` | Se passou no teste, adiciona `$i` ao acumulador |

**Exemplo do dia a dia:** imagine subir uma escada contando os degraus, mas só anotando na caderneta os degraus que **não** são múltiplos de 3. No fim, você soma tudo o que anotou.

### Acompanhando a execução (entrada 10)

| `$i` | `$i % 3` | Entra na soma? | `$soma` depois |
|---|---|---|---|
| 1 | 1 | Sim | 1 |
| 2 | 2 | Sim | 3 |
| 3 | 0 | Não | 3 |
| 4 | 1 | Sim | 7 |
| 5 | 2 | Sim | 12 |
| 6 | 0 | Não | 12 |
| 7 | 1 | Sim | 19 |
| 8 | 2 | Sim | 27 |
| 9 | 0 | Não | 27 |
| 10 | 1 | Sim | 37 |

Saída final: `Soma dos números de 1 a 10, exceto os divisíveis por 3: 37`

## Resumo

| Conceito | Para que serve | Exemplo |
|---|---|---|
| `fgets(STDIN)` | Lê uma linha digitada (vem como texto, com `\n`) | `fgets(STDIN)` |
| `intval()` | Converte texto (ou outro valor) em número inteiro | `intval("5\n")` → `5` |
| `echo` | Imprime o resultado na saída | `echo "SOMA = $soma\n";` |
| Interpolação | Coloca o valor da variável dentro do texto (só com aspas duplas) | `"$tempo minutos"` |
| `\n` | Quebra de linha | `echo "oi\n";` |
| `%` | Resto da divisão (0 significa divisível) | `10 % 3` → `1` |
| `for` | Repete um bloco um número definido de vezes | `for ($i = 1; $i <= $n; $i++)` |
| `if` | Executa um bloco só quando a condição é verdadeira | `if ($i % 3 != 0)` |
| `+=` | Soma um valor ao que já está guardado na variável | `$soma += $i;` |