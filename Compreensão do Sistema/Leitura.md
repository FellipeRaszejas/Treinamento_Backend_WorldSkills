# As 3 Fases de Análise do Código

Este guia detalha as três fases pelas quais o código fonte passa antes de ser traduzido: a análise léxica, a sintática e a semântica. Para cada uma, mostra o que ela faz, o que entrega para a fase seguinte e que tipo de erro costuma encontrar.

## Sumário

1. [Visão geral](#1-visão-geral)
2. [Análise Léxica (O Scanner / Lexer)](#2-análise-léxica-o-scanner--lexer)
   - [O que faz](#o-que-faz)
   - [Exemplo: do texto aos tokens](#exemplo-do-texto-aos-tokens)
3. [Análise Sintática (A Gramática)](#3-análise-sintática-a-gramática)
   - [O que faz](#o-que-faz-1)
   - [Exemplo: a árvore sintática](#exemplo-a-árvore-sintática)
   - [Exemplo de erro sintático](#exemplo-de-erro-sintático)
4. [Análise Semântica (O Significado e a Lógica)](#4-análise-semântica-o-significado-e-a-lógica)
   - [O que faz](#o-que-faz-2)
   - [Os operadores `=`, `==` e `===`](#os-operadores---e-)
   - [Exemplo de erro semântico](#exemplo-de-erro-semântico)
5. [Resumo](#5-resumo)

---

## 1. Visão geral

**Conceito:** antes de traduzir o código, o compilador o examina em três fases consecutivas. A saída de cada fase é a entrada da seguinte.

**No dia a dia:** é como revisar uma frase. Primeiro você separa as palavras, depois confere a gramática e, por fim, pergunta se a frase faz sentido. A frase "O sofá comeu a pizza" tem palavras corretas e gramática correta, mas não faz sentido.

| 📄 Código fonte | → | 🔤 Análise léxica | → | 🌳 Análise sintática | → | 🧠 Análise semântica |
|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| texto puro | | gera **tokens** | | gera a **árvore sintática** | | valida o **sentido** |

---

## 2. Análise Léxica (O Scanner / Lexer)

### O que faz

**Conceito:** lê o código fonte **caractere por caractere** e o particiona em pequenos blocos com significado, chamados **tokens**. No caminho, descarta o que não importa para a tradução: espaços em branco e comentários.

**Tipos de token:**

| Tipo | Exemplos |
|---|---|
| Identificadores | `$total`, `idade`, `calcular` |
| Palavras reservadas | `if`, `while`, `return` |
| Números | `10`, `3.14` |
| Strings | `"Olá"` |
| Operadores e símbolos | `=`, `+`, `;`, `(` |

### Exemplo: do texto aos tokens

Para a linha abaixo, o comentário e os espaços são descartados:

```php
$total = 10 + 5; // soma
```

| Pedaço do código | Token |
|---|---|
| `$total` | identificador |
| `=` | operador |
| `10` | número |
| `+` | operador |
| `5` | número |
| `;` | símbolo |
| `// soma` | descartado (comentário) |

> Erros típicos desta fase: um símbolo que a linguagem não reconhece ou um texto aberto com aspas e nunca fechado. Escrever `whlie` no lugar de `while` **não** é erro léxico, pois `whlie` vira um identificador válido. O problema só aparece na fase seguinte.

---

## 3. Análise Sintática (A Gramática)

### O que faz

**Conceito:** recebe os tokens e os organiza em uma **estrutura hierárquica**, a árvore sintática. Garante que a ordem das palavras e dos símbolos respeita a regra gramatical da linguagem (por exemplo, se a estrutura de um `if` ou de uma função foi escrita na ordem correta).

**Nota:** as regras gramaticais variam de acordo com a linguagem.

### Exemplo: a árvore sintática

Para `$total = 10 + 5;`, a soma acontece antes da atribuição, e a árvore mostra essa hierarquia:

```
      =
     / \
$total   +
        / \
       10  5
```

### Exemplo de erro sintático

```php
<?php
if ($idade > 18 {
    echo "Maior de idade";
}
```

- **O que está errado:** falta o `)` que fecha a condição do `if`.
- **Por que é sintático:** todos os tokens existem na linguagem, mas estão fora da ordem que a gramática exige.

---

## 4. Análise Semântica (O Significado e a Lógica)

### O que faz

**Conceito:** valida o **sentido lógico** do que foi escrito. Garante que a operação faz sentido dentro das regras da linguagem, por exemplo, se você não está tentando somar um texto com um número de forma inválida.

### Os operadores `=`, `==` e `===`

Cada um tem um significado diferente:

| Operador | Função | Existe em |
|---|---|---|
| `=` | Atribuição | Praticamente todas as linguagens |
| `==` | Comparação de valor | PHP, JavaScript, Java, C e outras |
| `===` | Comparação estrita de valor **e** tipo | PHP e JavaScript |

Quem reconhece que `===` é **um único** operador (e não três `=` seguidos) é a análise léxica, que cria um token distinto para cada um. A análise semântica entra depois, conferindo se a atribuição ou a comparação faz sentido para os tipos envolvidos.

### Exemplo de erro semântico

```java
int idade = "vinte";
```

- **O que está errado:** a variável é do tipo inteiro, mas recebe um texto.
- **Por que é semântico:** a linha está bem escrita (tokens e gramática corretos), porém não faz sentido. O compilador do Java rejeita o código com um erro de tipos incompatíveis.

> No PHP, que tem tipagem dinâmica, parte dessas verificações de tipo acontece durante a execução, e não antes dela.

---

## 5. Resumo

| Fase | Entrada | Saída | Pergunta que responde | Exemplo de erro |
|---|---|---|---|---|
| **Léxica** | Código fonte (texto) | Tokens | "Estas são palavras e símbolos válidos?" | Texto com aspas que nunca fecham |
| **Sintática** | Tokens | Árvore sintática | "A ordem respeita a gramática?" | `if ($idade > 18 {` |
| **Semântica** | Árvore sintática | Árvore validada | "Isto faz sentido?" | `int idade = "vinte";` |