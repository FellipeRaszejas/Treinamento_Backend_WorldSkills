# PHP: Strings, Arrays Associativos, Variáveis e Inteiros

Este guia reúne quatro pontos do PHP que costumam gerar dúvidas em quem está começando: como escrever e juntar strings, como usar arrays com chaves de texto, como funcionam o escopo e as referências de variáveis e como o PHP divide números inteiros.

## Sumário

1. [Strings: Aspas Simples vs. Duplas e Concatenação](#1-strings-aspas-simples-vs-duplas-e-concatenação)
   - [Aspas simples e aspas duplas](#aspas-simples-e-aspas-duplas)
   - [Concatenação](#concatenação)
2. [Arrays Associativos (Chaves de Texto)](#2-arrays-associativos-chaves-de-texto)
   - [Por que isso importa](#por-que-isso-importa)
3. [Variáveis: Escopo e Referências](#3-variáveis-escopo-e-referências)
   - [Escopo](#escopo)
   - [Atribuição por referência](#atribuição-por-referência)
4. [Inteiros e Operações Matemáticas](#4-inteiros-e-operações-matemáticas)
5. [Resumo](#5-resumo)

---

## 1. Strings: Aspas Simples vs. Duplas e Concatenação

### Aspas simples e aspas duplas

**Conceito:** no PHP, a escolha entre aspas simples (`''`) e duplas (`""`) muda o **comportamento** do texto. Nas duplas, o PHP procura variáveis dentro do texto e as substitui pelo valor; nas simples, o texto sai exatamente como foi escrito.

**No dia a dia:** as aspas duplas funcionam como uma carta-modelo ("Prezado ____"), em que o nome é preenchido na hora de enviar. As aspas simples funcionam como um carimbo: o que está gravado é o que aparece, sem nenhum campo para preencher.

```php
<?php
$nome = "Ana";
$sobrenome = "Silva";

echo "$nome $sobrenome";        // Ana Silva
echo '$nome $sobrenome';        // $nome $sobrenome
echo $nome . " " . $sobrenome;  // Ana Silva
```

- Na linha 1 do `echo`, as aspas duplas fazem o PHP trocar `$nome` e `$sobrenome` pelos valores.
- Na linha 2, as aspas simples imprimem o texto literalmente, com os cifrões.
- Na linha 3, a concatenação monta o mesmo resultado da primeira.

| Característica | Aspas simples `'...'` | Aspas duplas `"..."` |
|---|---|---|
| Variáveis dentro do texto | Não são interpretadas (saem literais) | São substituídas pelo valor |
| Caracteres especiais (`\n`, `\t`) | Não funcionam | Funcionam |
| Quando usar | Texto fixo, sem variáveis | Texto que mistura variáveis, como `"$nome $sobrenome"` |

### Concatenação

**Conceito:** em PHP, o operador para juntar strings é o **ponto** (`.`), e não o sinal de mais (`+`).

- Exemplo: `$nomeCompleto = $nome . " " . $sobrenome;`
- Se você usar o `+`, o PHP tenta somar os textos como se fossem números e, dependendo da versão e do conteúdo, gera um aviso ou um erro.

| Operação | Operador | Exemplo |
|---|---|---|
| Juntar textos | `.` | `$nome . " " . $sobrenome` |
| Somar números | `+` | `10 + 5` |

---

## 2. Arrays Associativos (Chaves de Texto)

**Conceito:** os arrays indexados usam números como posição (`0`, `1`, `2`...). Nos **arrays associativos**, o índice é uma palavra, a **chave**, associada a um valor.

**No dia a dia:** um array indexado é um armário com gavetas numeradas (gaveta 0, gaveta 1...). Um array associativo é um armário em que cada gaveta tem uma etiqueta ("meias", "camisetas"), e você abre a gaveta pelo nome.

```php
$usuario = [
    "nome" => "Fellipe",
    "idade" => 30,
    "ativo" => true
];
echo $usuario["nome"]; // Imprime "Fellipe"
```

- `"nome" => "Fellipe"`: a chave `"nome"` aponta para o valor `"Fellipe"`.
- `$usuario["nome"]`: busca o valor pela chave, e não pela posição.

### Por que isso importa

O PHP, o Laravel e o JSON usam arrays associativos o tempo todo. Um array associativo vira JSON com uma única função, o que facilita enviar dados de uma API para o frontend:

```php
echo json_encode($usuario); // {"nome":"Fellipe","idade":30,"ativo":true}
```

No Laravel, os resultados de uma consulta ao banco chegam como objetos ou coleções (*Collections*), que podem ser convertidos em array (`toArray()`) e em JSON quando a resposta é enviada ao frontend.

| Tipo de array | Índice | Exemplo de acesso |
|---|---|---|
| Indexado | Número (`0, 1, 2...`) | `$lista[0]` |
| Associativo | Texto (chave) | `$usuario["nome"]` |

---

## 3. Variáveis: Escopo e Referências

### Escopo

**Conceito:** o escopo define **onde** uma variável existe. Uma variável criada fora de uma função não existe dentro dela por padrão (e vice-versa).

**No dia a dia:** é como as salas de uma casa. O que está na cozinha não aparece na sala, a menos que alguém leve até lá.

```php
<?php
$taxa = 10;

function mostrarTaxa() {
    echo $taxa; // $taxa não existe aqui dentro (variável indefinida)
}
```

Para usar uma variável externa dentro da função, há duas saídas:

| Forma | Como funciona |
|---|---|
| Passar como **parâmetro** | `function mostrarTaxa($taxa)`, chamando com `mostrarTaxa($taxa);` |
| Usar a palavra **`global`** | `global $taxa;` dentro da função |

> O parâmetro costuma ser a opção mais clara e segura, pois deixa explícito o que a função recebe.

### Atribuição por referência

**Conceito:** por padrão, quando você atribui uma variável a outra (`$a = $b`), o PHP **copia o valor**. Para que as duas apontem exatamente para o mesmo espaço de memória, de modo que, se uma mudar, a outra mude junto, usa-se o E comercial (`&`).

**No dia a dia:** copiar o valor é como tirar uma cópia de um documento: mudar a cópia não altera o original. Usar `&` é como criar um atalho para o documento: abrir o atalho e editar altera o arquivo original.

```php
$original = "PHP";
$copiaReferencia = &$original;
$copiaReferencia = "Laravel";
echo $original; // Vai imprimir "Laravel"!
```

- `$copiaReferencia = &$original;`: as duas variáveis passam a ser dois nomes para o mesmo valor.
- `$copiaReferencia = "Laravel";`: altera o valor compartilhado.
- `echo $original;`: imprime `Laravel`, pois o original mudou junto.

| Atribuição | Sintaxe | Efeito |
|---|---|---|
| Por valor (cópia) | `$a = $b;` | Mudar `$a` **não** altera `$b` |
| Por referência | `$a = &$b;` | Mudar `$a` **altera** `$b` |

---

## 4. Inteiros e Operações Matemáticas

**Conceito:** em algumas linguagens estáticas, dividir um inteiro por outro (`5 / 2`) resulta em `2`, truncando o decimal. No PHP, a divisão de inteiros retorna automaticamente um número de ponto flutuante (`float`) quando há resto. Ou seja, `5 / 2` resulta exatamente em `2.5`.

**No dia a dia:** dividir 5 pizzas entre 2 pessoas dá 2,5 pizzas para cada uma, e não 2.

```php
<?php
echo 5 / 2;        // 2.5
echo 4 / 2;        // 2 (sem resto, o resultado é inteiro)
echo intdiv(5, 2); // 2 (divisão inteira, descarta o resto)
echo 5 % 2;        // 1 (o resto da divisão)
```

| Expressão | Resultado | Observação |
|---|---|---|
| `5 / 2` | `2.5` | Divisão com resto retorna `float` |
| `4 / 2` | `2` | Divisão exata retorna inteiro |
| `intdiv(5, 2)` | `2` | Quando se quer apenas a parte inteira |
| `5 % 2` | `1` | Resto da divisão |

---

## 5. Resumo

| Tema | Ideia central | Atenção |
|---|---|---|
| **Aspas duplas** | Interpretam variáveis e `\n` | Úteis quando o texto mistura variáveis |
| **Aspas simples** | Texto literal | Não substituem variáveis |
| **Concatenação** | Usa o ponto (`.`) | O `+` é só para números |
| **Array associativo** | Índice é uma chave de texto | Base para JSON e APIs |
| **Escopo** | Variável externa não existe dentro da função | Passe como parâmetro ou use `global` |
| **Referência (`&`)** | Dois nomes para o mesmo valor | Alterar um altera o outro |
| **Divisão (`/`)** | Retorna `float` se houver resto | `5 / 2` é `2.5` |