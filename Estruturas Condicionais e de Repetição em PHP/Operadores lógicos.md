# Operadores Lógicos em PHP

Guia para iniciantes sobre os operadores que avaliam expressões e decidem se uma informação é verdadeira ou falsa: `&&`, `||`, `and`, `or`, `xor`, `!`, além do curto-circuito, do operador Elvis (`?:`) e da atribuição de coalescência nula (`??=`). Todos os exemplos usam `var_dump()` para mostrar o resultado real de cada expressão.

## Sumário

1. [var_dump()](#var_dump)
2. [Objetivo dos operadores lógicos](#objetivo-dos-operadores-lógicos)
3. [AND (E)](#and-e)
4. [OR (OU)](#or-ou)
5. [Palavras and e or versus símbolos && e ||](#palavras-and-e-or-versus-símbolos--e-)
   - [Precedência e atribuição](#precedência-e-atribuição)
   - [Efeito dos parênteses](#efeito-dos-parênteses)
6. [XOR (OU exclusivo)](#xor-ou-exclusivo)
7. [! (NÃO)](#-não)
8. [Avaliação de curto-circuito (Short-Circuit Evaluation)](#avaliação-de-curto-circuito-short-circuit-evaluation)
9. [Operador Elvis (?:)](#operador-elvis-)
10. [Atribuição de coalescência nula (Null Coalescing Assignment, ??=)](#atribuição-de-coalescência-nula-null-coalescing-assignment-)
11. [Resumo](#resumo)

## var_dump()

O `var_dump()` é uma função do PHP que mostra o **tipo** e o **valor** de uma variável ou expressão. Ele é a melhor ferramenta para estudar operadores lógicos, porque revela exatamente o que o PHP calculou.

Compare com o `echo`, que esconde o tipo:

```php
<?php
echo true;        // imprime: 1
echo false;       // imprime: (nada, string vazia)

var_dump(true);   // bool(true)
var_dump(false);  // bool(false)
var_dump(5);      // int(5)
var_dump("texto");// string(5) "texto"
var_dump(null);   // NULL
```

| Valor | Saída do `var_dump()` | Como ler |
|---|---|---|
| `true` | `bool(true)` | booleano verdadeiro |
| `false` | `bool(false)` | booleano falso |
| `5` | `int(5)` | inteiro |
| `"texto"` | `string(5) "texto"` | texto com 5 bytes |
| `null` | `NULL` | ausência de valor |

Nos exemplos deste guia, o comentário `// bool(...)` ao lado de cada `var_dump()` mostra o que ele imprime.

## Objetivo dos operadores lógicos

Os operadores lógicos avaliam expressões e determinam se uma informação é:

- Verdadeiro ou falso
- Positivo ou negativo
- Presente ou ausente
- Rodando ou inativa

Eles combinam condições, como em uma portaria: "entra quem tem ingresso **e** documento", "entra quem é aluno **ou** professor".

## AND (E)

**Conceito:** o resultado é verdadeiro somente se **as duas** condições forem verdadeiras.

**Exemplo cotidiano:** para entrar em um show, você precisa de ingresso **E** documento. Se faltar um, não entra.

```php
<?php
$a = true;
$b = true;

if ($a && $b == true) {
    echo "AND";
}

var_dump($a && $b); // bool(true)
```

Também é possível escrever com a palavra `and`:

```php
if ($a and $b == true) {
    echo "AND";
}
```

Explicação das partes:

- `$a && $b == true`: o `==` é avaliado antes do `&&`, então o PHP lê como `$a && ($b == true)`. Como `$a` já é um booleano, basta escrever `if ($a && $b)`.
- `var_dump($a && $b)`: mostra o resultado da expressão inteira.

| `$a` | `$b` | `$a && $b` |
|---|---|---|
| `true` | `true` | `true` |
| `true` | `false` | `false` |
| `false` | `true` | `false` |
| `false` | `false` | `false` |

## OR (OU)

**Conceito:** o resultado é verdadeiro se **pelo menos uma** das condições for verdadeira.

**Exemplo cotidiano:** você pode pagar a conta com cartão **OU** com dinheiro. Basta uma das formas funcionar.

```php
<?php
$a = "or";
$b = "nada";

if ($a == "or" || $b == "or") {
    echo "OR";
}

var_dump($a == "or" || $b == "or"); // bool(true)
```

Também é possível escrever com a palavra `or`:

```php
if ($a == "or" or $b == "or") {
    echo "OR";
}
```

| `$a` | `$b` | `$a \|\| $b` |
|---|---|---|
| `true` | `true` | `true` |
| `true` | `false` | `true` |
| `false` | `true` | `true` |
| `false` | `false` | `false` |

## Palavras and e or versus símbolos && e ||

`and` faz o mesmo que `&&`, e `or` faz o mesmo que `||`. A diferença está na **precedência**: a ordem em que o PHP resolve as operações quando há mais de um operador na mesma linha. `&&` e `||` têm precedência **alta**; `and` e `or` têm precedência **baixa**, até mais baixa que o `=` da atribuição.

### Precedência e atribuição

**Exemplo cotidiano:** em uma receita, "bata os ovos **e depois** adicione o leite" tem uma ordem. Se você trocar a ordem, o resultado muda. Com os operadores acontece o mesmo.

Com `&&`, a atribuição guarda o resultado da expressão inteira:

```php
<?php
$resultado = true && false;
var_dump($resultado); // bool(false)
```

Com `and`, o PHP faz a atribuição **primeiro** e só depois avalia o `and`. O resultado é guardado "pela metade":

```php
<?php
$resultado = true and false;
var_dump($resultado); // bool(true)  -> lido como ($resultado = true) and false
```

Para corrigir, use parênteses:

```php
<?php
$resultado = (true and false);
var_dump($resultado); // bool(false)
```

O mesmo vale para `||` e `or`:

```php
<?php
$resultado = false || true;
var_dump($resultado); // bool(true)

$resultado = false or true;
var_dump($resultado); // bool(false) -> lido como ($resultado = false) or true

$resultado = (false or true);
var_dump($resultado); // bool(true)
```

Dentro de um `if`, sem atribuição, `and`/`&&` e `or`/`||` dão o mesmo resultado. O cuidado é necessário quando o resultado é **guardado em uma variável**.

Ordem de precedência, da mais alta para a mais baixa:

| Ordem | Operador | Observação |
|---|---|---|
| 1 | `!` | NÃO |
| 2 | `&&` | E (símbolo) |
| 3 | `\|\|` | OU (símbolo) |
| 4 | `=` | atribuição |
| 5 | `and` | E (palavra) |
| 6 | `xor` | OU exclusivo |
| 7 | `or` | OU (palavra) |

### Efeito dos parênteses

Os parênteses mudam o agrupamento e, com isso, o resultado. Como `&&` tem precedência maior que `||`, o PHP resolve o `&&` primeiro:

```php
<?php
var_dump(true || false && false);   // bool(true)  -> true || (false && false)
var_dump((true || false) && false); // bool(false) -> (true || false) && false
```

Um exemplo mais próximo do dia a dia, com a regra de entrada de uma festa:

```php
<?php
$maiorDeIdade = false;
$temDocumento = true;
$acompanhado  = true;

// Sem parênteses: (maiorDeIdade && temDocumento) || acompanhado
var_dump($maiorDeIdade && $temDocumento || $acompanhado);   // bool(true)

// Com parênteses: maiorDeIdade && (temDocumento || acompanhado)
var_dump($maiorDeIdade && ($temDocumento || $acompanhado)); // bool(false)
```

Mesmas variáveis, regras diferentes. Na dúvida, use parênteses: eles deixam a intenção explícita.

## XOR (OU exclusivo)

**Conceito:** o resultado é verdadeiro quando **exatamente uma** das condições é verdadeira. Se as duas forem verdadeiras, ou as duas falsas, o resultado é falso.

**Exemplo cotidiano:** no menu do almoço, "acompanha suco **ou** refrigerante", mas não os dois. Escolher um é permitido; escolher os dois ou nenhum, não.

```php
<?php
$aluno = "fellipe";
$faculdade = "senai";

if ($aluno == "fellipe" xor $faculdade == "fatec") {
    echo "Apenas uma das condições é verdadeira";
}

var_dump(($aluno == "fellipe") xor ($faculdade == "fatec")); // bool(true)
```

Explicação: `$aluno == "fellipe"` é verdadeiro e `$faculdade == "fatec"` é falso. Como só uma é verdadeira, o `xor` retorna `true`.

| `$a` | `$b` | `$a xor $b` |
|---|---|---|
| `true` | `true` | `false` |
| `true` | `false` | `true` |
| `false` | `true` | `true` |
| `false` | `false` | `false` |

Cuidados:

- Use `==` para **comparar**. Um único `=` **atribui** um valor e a condição quase sempre ficará verdadeira.
- O `xor` não tem versão em símbolo. O `^` existe, mas é o XOR **bit a bit**, outro assunto.

## ! (NÃO)

**Conceito:** inverte o valor lógico: o que era `true` vira `false` e vice-versa.

**Exemplo cotidiano:** um interruptor. Se a luz está acesa, "não acesa" é falso; se está apagada, "não acesa" é verdadeiro.

```php
<?php
$info = "";

if ($info) {
    echo "Tem informações";
} elseif (!$info) {
    echo "Não tem informação";
} else {
    echo "Echo inútil no exemplo, mas faz sentido no código";
}

var_dump(!$info);  // bool(true)
var_dump(!!$info); // bool(false)
```

Explicação:

- `if ($info)`: executa se `$info` for considerado verdadeiro.
- `elseif (!$info)`: executa se `$info` for considerado falso.
- `else`: nunca é alcançado neste exemplo, pois os dois casos anteriores cobrem todas as possibilidades.
- `!!$info`: dupla negação, uma forma de converter qualquer valor em booleano.

O `!` considera como **falso** os valores abaixo. Todo o resto é verdadeiro:

| Valor | `!$valor` |
|---|---|
| `false` | `true` |
| `0` | `true` |
| `""` (texto vazio) | `true` |
| `"0"` | `true` |
| `null` | `true` |
| `[]` (array vazio) | `true` |
| `"abc"` | `false` |
| `5` | `false` |

## Avaliação de curto-circuito (Short-Circuit Evaluation)

**Conceito:** o PHP é "preguiçoso" de forma inteligente. Ao avaliar `&&` e `||`, ele para assim que o resultado final já está garantido.

- No `&&` (E): se a primeira condição for falsa, o PHP nem olha a segunda, porque o resultado será falso de qualquer jeito.
- No `||` (OU): se a primeira condição for verdadeira, o PHP ignora a segunda, porque o resultado já é verdadeiro.

**Exemplo cotidiano:** você quer entrar em um prédio que exige crachá **E** biometria. Se você não tem o crachá, o segurança nem pede a biometria.

Para enxergar isso acontecendo, a função abaixo avisa quando é executada:

```php
<?php
function verificar(string $nome, bool $valor): bool
{
    echo "Avaliando $nome\n";
    return $valor;
}

var_dump(verificar("A", false) && verificar("B", true));
// Avaliando A
// bool(false)       -> "B" nunca foi avaliado

var_dump(verificar("A", true) || verificar("B", true));
// Avaliando A
// bool(true)        -> "B" nunca foi avaliado
```

**Por que isso importa na prática:** o curto-circuito permite checar se uma informação está presente **antes** de usá-la:

```php
<?php
$usuario = null; // Informação ausente

// Sem a checagem, ler $usuario['ativo'] em um valor null gera um aviso (Warning).
// Com o curto-circuito, essa leitura nem acontece:
if ($usuario !== null && $usuario['ativo'] == true) {
    echo "Usuário rodando!";
} else {
    echo "Usuário ausente ou inativo, sem aviso nem erro!";
}
// Como a primeira parte ($usuario !== null) é falsa,
// o PHP nem tenta ler $usuario['ativo'].
```

Em outros casos, como chamar um método (`$usuario->metodo()`) em um valor `null`, o resultado é um erro fatal. Nesses casos a checagem antes do `&&` evita a parada do programa.

> O `and` e o `or` também fazem curto-circuito.

## Operador Elvis (?:)

**Conceito:** é a versão curta do operador ternário (`condição ? verdadeiro : falso`). Ele retorna o valor da esquerda se esse valor for considerado verdadeiro; caso contrário, retorna o valor da direita. É apelidado de "Elvis" porque `?:` lembra o topete do cantor.

**Exemplo cotidiano:** "se tiver café em casa, tome café; senão, tome água".

```php
<?php
// Imagine que veio um dado de um formulário (pode estar vazio/ausente)
$statusInformado = ""; // Vazio / Ausente

// Se $statusInformado tiver valor, usa ele. Se não (vazio/falso/null), usa o padrão "Inativo".
$statusFinal = $statusInformado ?: "Inativo";

var_dump($statusFinal); // string(7) "Inativo"
```

Ele resume o `if/else` em uma única linha para definir valores padrão.

Atenção: o `?:` trata como ausente qualquer valor falso (`0`, `""`, `"0"`, `false`, `null`, `[]`). Para tratar como ausente **somente** o `null`, existe o operador `??`:

```php
<?php
var_dump(0 ?: "Inativo");  // string(7) "Inativo"  -> 0 é falso, então usa o padrão
var_dump(0 ?? "Inativo");  // int(0)             -> 0 não é null, então mantém o 0
```

## Atribuição de coalescência nula (Null Coalescing Assignment, ??=)

**Conceito:** verifica se uma variável ou chave de array está ausente (não existe ou é `null`) e, só nesse caso, atribui um valor padrão. Disponível a partir do PHP 7.4.

**Exemplo cotidiano:** ao arrumar a mesa, você coloca o prato **somente se** ele ainda não estiver lá.

```php
<?php
// Simulando dados de configuração onde a chave 'rodando' ainda não foi criada
$configuracao = [];

// Se a chave 'rodando' não existir (ausente), defina-a como false (inativa)
$configuracao['rodando'] ??= false;

var_dump($configuracao);
// array(1) {
//   ["rodando"]=>
//   bool(false)
// }
```

Se a chave já existir com algum valor diferente de `null`, ela **não** é alterada:

```php
<?php
$configuracao = ['rodando' => true];
$configuracao['rodando'] ??= false;

var_dump($configuracao['rodando']); // bool(true)
```

## Resumo

| Operador | Nome | Resultado verdadeiro quando | Exemplo | `var_dump` |
|---|---|---|---|---|
| `&&` / `and` | E | as duas condições são verdadeiras | `true && false` | `bool(false)` |
| `\|\|` / `or` | OU | pelo menos uma é verdadeira | `false \|\| true` | `bool(true)` |
| `xor` | OU exclusivo | exatamente uma é verdadeira | `true xor true` | `bool(false)` |
| `!` | NÃO | inverte o valor | `!true` | `bool(false)` |
| `?:` | Elvis | retorna o valor da esquerda se for verdadeiro; senão, o da direita | `"" ?: "Inativo"` | `string(7) "Inativo"` |
| `??=` | Atribuição de coalescência nula | atribui só se a variável estiver ausente ou for `null` | `$c['x'] ??= false` | `bool(false)` |

Pontos de atenção:

| Situação | Cuidado |
|---|---|
| `$r = true and false;` | `=` vem antes de `and`: `$r` fica `true`. Use `&&` ou parênteses |
| `$r = false or true;` | `=` vem antes de `or`: `$r` fica `false`. Use `\|\|` ou parênteses |
| `a \|\| b && c` | `&&` é resolvido antes do `\|\|`. Use parênteses para deixar claro |
| `$a = "x"` dentro do `if` | Atribui em vez de comparar. Use `==` |
| Checar antes de usar | Coloque a verificação à esquerda do `&&` para aproveitar o curto-circuito |