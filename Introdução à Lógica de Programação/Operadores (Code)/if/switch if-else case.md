# Estruturas condicionais em PHP

Guia para iniciantes sobre as estruturas que fazem o programa tomar decisões: `if`, `else`, `else if`, operador ternário e `switch-case`. Para cada uma, você vê o conceito, um exemplo do dia a dia, o código em PHP e quando usar.

## Sumário

1. [If e else (Se e Senão)](#if-e-else-se-e-senão)
2. [Else if (Senão se)](#else-if-senão-se)
3. [Operador ternário (Ternary Operator)](#operador-ternário-ternary-operator)
4. [Switch-case](#switch-case)
5. [Comparativo técnico](#comparativo-técnico)
6. [Quando usar cada um](#quando-usar-cada-um)
7. [Resumo](#resumo)

## If e else (Se e Senão)

`if` vem do inglês e significa "se": se a condição dentro dele for verdadeira, um bloco de código é executado. O `else` ("senão") é o caminho alternativo, executado quando a condição do `if` é falsa.

**Exemplo cotidiano:** *se* estiver chovendo, você leva o guarda-chuva; *senão*, sai sem ele.

```php
<?php
// Adicionamos aspas
$nome = "fellipe"; 

if ($nome == "fellipe") { // Compara com '=='
    echo "Está rodando! (Verdadeiro)";
    // Em uma função, você usaria: return true;
} else {
    echo "Inativa! (Falso)";
    // Em uma função, você usaria: return false;
}
?>
```

- `$nome = "fellipe";` guarda um texto na variável (textos precisam de aspas).
- `$nome == "fellipe"` é a condição: o `==` **compara** os dois valores.
- O bloco do `if` roda quando a comparação é verdadeira.
- O bloco do `else` roda em qualquer outro caso.

> **Atenção:** `=` atribui um valor; `==` compara dois valores. Trocar um pelo outro é um erro muito comum.

## Else if (Senão se)

O `else if` adiciona novas possibilidades entre o `if` e o `else`: uma terceira, uma quarta, quantas forem necessárias. O PHP testa uma condição por vez, de cima para baixo, e para na primeira verdadeira. O `else` final cobre o que nenhuma condição atendeu.

**Exemplo cotidiano:** na portaria de um prédio, o porteiro verifica: *se* é o morador, libera; *senão se* é o entregador, manda aguardar; *senão*, não deixa entrar.

```php
<?php
$nome = "carlos"; // Informação presente

if ($nome == "fellipe") {
    echo "É o Fellipe (Verdadeiro)";
}
// Aspas em "carlos" e '==' para comparar
else if ($nome == "carlos") { 
    echo "É o Carlos (Presente)";
}
else {
    echo "Nenhuma das opções (Informação Ausente)";
}
?>
```

- Primeiro o PHP compara com `"fellipe"`; não é igual, então segue.
- Depois compara com `"carlos"`; é igual, então exibe "É o Carlos (Presente)" e ignora o restante.
- O `else` só roda se nenhuma das comparações anteriores for verdadeira.

<!-- Imagem da matriz de respostas com if/else: adicionar em imagens/ e referenciar aqui -->

## Operador ternário (Ternary Operator)

O operador ternário é um atalho para um `if/else` simples, escrito em uma linha: uma condição, o valor se for verdadeira e o valor se for falsa. O nome é o mesmo usado no Java. No PHP ele pode devolver qualquer tipo de dado, não só `true` ou `false`.

**Exemplo cotidiano:** é como um aviso na porta: "Aberto ou fechado?", definido por uma única checagem.

```php
<?php
$nota = 8;

// A estrutura é: (condição) ? se_verdadeiro : se_falso;
$resultado = ($nota >= 7) ? "Aprovado (Positivo)" : "Reprovado (Negativo)";

echo $resultado; // Saída: Aprovado (Positivo)
?>
```

- `($nota >= 7)` é a condição.
- O texto depois do `?` é o valor se a condição for verdadeira.
- O texto depois do `:` é o valor se for falsa.

> **Atenção:** o operador de comparação "maior ou igual" é `>=`. A forma `=>` não é comparação no PHP (ela é usada em arrays).

## Switch-case

O `switch` compara **uma única variável** com vários valores fixos, um por `case`, até encontrar um valor igual. Quando encontra, executa aquele bloco; o `break` encerra o `switch` para que os `case` seguintes não sejam executados. O `default` cobre o caso em que nenhum valor bateu.

**Exemplo cotidiano:** os botões de um elevador. Cada número de andar leva a um destino específico, e cada botão tem uma ação só.

```php
<?php
$nivelAcesso = 'editor';

switch ($nivelAcesso) {
    case 'admin':
        echo "Painel Total";
        break;
    case 'editor':
        echo "Painel de Postagens";
        break;
    default:
        echo "Acesso Negado";
}
?>
```

- `switch ($nivelAcesso)` define qual variável será comparada.
- Cada `case` é um valor possível; aqui `'editor'` coincide e exibe "Painel de Postagens".
- O `break` impede que o PHP continue para os próximos `case`.
- O `default` funciona como o `else` do `if`.

> **Atenção:** o `switch` usa comparação branda (`==`). Se você precisa de comparação estrita, o PHP 8 trouxe a estrutura `match` (Pattern Matching).

## Comparativo técnico

| Critério | If / Else if / Else | Operador ternário (`? :`) | Switch-case |
|---|---|---|---|
| Simplicidade | Excelente para lógicas complexas; longo para atribuições simples | Muito enxuto para escolhas binárias (sim/não) | Ideal para comparar uma variável com vários valores fixos |
| Legibilidade | Pode virar uma "bola de neve" se houver muitos ninhos | Ótimo em uma linha; ruim se aninhado | Limpo para múltiplos estados e menus |
| Desempenho | Avalia condição por condição, em sequência | Praticamente igual a um `if/else` simples | Equivalente na prática; o ganho, se houver, é pequeno |

### Desempenho (Performance)

Em um PHP moderno, a diferença de tempo entre as três estruturas é imperceptível na maioria das aplicações. O gargalo de verdade nunca é a estrutura em si, e sim o que está dentro da condição (por exemplo, uma consulta pesada ao banco de dados dentro de um `if`). Por isso, escolha pela **clareza do código**, não por velocidade.

## Quando usar cada um

### If / Else (o coringa)

Use quando precisar avaliar condições complexas, várias variáveis juntas ou intervalos numéricos. Encadear dezenas de `else if` deixa o código poluído e difícil de manter.

```php
if ($nota >= 7 && $frequencia >= 75) {
    echo "Aprovado";
}
```

### Operador ternário (o atalho)

Use para atribuições rápidas baseadas em uma única condição verdadeiro/falso. Economiza linhas, mas **evite aninhar ternários** (ex.: `$a ? $b : $c ? $d : $e`): isso destrói a legibilidade e, no PHP 8, exige parênteses para funcionar.

```php
$status = ($usuarioAtivo) ? "Online" : "Offline";
```

### Switch-case (o especialista em estados)

Use quando houver uma única variável e vários valores fixos possíveis, como status de pedidos, menus, opções do sistema e dias da semana. Evita uma sequência repetitiva de `else if` (`if ($status == 1)... else if ($status == 2)...`).

## Resumo

| Situação | Estrutura |
|---|---|
| Testar várias variáveis diferentes ou intervalos (maior, menor, E/OU) | `if / else if / else` |
| Atribuir um valor rápido com base em uma condição simples (sim/não) | Operador ternário |
| Checar muitos valores fixos de uma mesma variável (ex.: códigos 200, 404, 500) | `switch-case` |