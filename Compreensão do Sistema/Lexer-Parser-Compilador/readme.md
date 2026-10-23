# PHP por dentro — do texto ao resultado

> Material de apoio pessoal. Foco: entender o que o computador está
> compreendendo quando você escreve código PHP, não sintaxe nem regra de negócio.

---

## 1. Base conceitual (POO)

Antes de entrar no motor do PHP, vale lembrar de onde vem a ideia de Classe/Objeto:

- **Platão**: o mundo das ideias contém as formas perfeitas; o mundo sensível é
  cópia transitória dessas formas. Analogia direta: **Classe = forma (ideia)**,
  **Objeto = cópia transitória, instanciada no tempo**.
- **Aristóteles**: descreve um "ser" através de três movimentos —
  **definição** (nome + substância), **predicação** (atributos e métodos) e
  **inferência** (uma característica de A se aplica a B por causa da relação
  entre eles — a base lógica da herança).
- Isso é **paradigma**, não sintaxe. Vale igual em C#, PHP, Java etc. Uma classe
  `Carro` com atributos e métodos representa a mesma ideia em qualquer
  linguagem orientada a objetos — muda a "casca" (sintaxe), não o conceito.

---

## 2. O pipeline de execução do PHP

Todo código PHP passa pelas mesmas 5 etapas antes de produzir qualquer efeito
real. Exemplo usado como fio condutor:

```php
$soma = 2 + 3;
echo $soma;
```

### 2.1 Código-fonte (.php)
É só texto puro. Nenhuma estrutura, nenhum significado — apenas caracteres.

### 2.2 Lexer (análise léxica)
Varre o texto caractere por caractere e agrupa em **tokens** — as menores
unidades com significado, como separar uma frase em palavras antes de analisar
a gramática.

```
T_VARIABLE("$soma")   '='   T_LNUMBER(2)   '+'   T_LNUMBER(3)   ';'
```

### 2.3 Parser (análise sintática) → AST
Os tokens, sozinhos, não têm hierarquia. O parser aplica a gramática do PHP e
organiza os tokens numa **árvore** — a AST (Árvore Sintática Abstrata).

A árvore representa **o que depende do quê**, já sem sobra de sintaxe
(sem `;`, sem parênteses redundantes):

```
        ATRIBUIÇÃO
        /         \
    $soma        SOMA
                 /    \
                2      3
```

A posição na árvore define a ordem de execução — é assim que o PHP sabe que a
soma precisa ser resolvida antes da atribuição, e que multiplicação tem
precedência sobre soma quando a expressão é mais complexa.

### 2.4 Compilador → opcodes
A árvore ainda não é executável. O compilador percorre a AST e a "achata" numa
lista sequencial de instruções atômicas — os **opcodes** (parecido com uma
receita reduzida a passos burros e diretos):

```
ZEND_ADD      TMP0, 2, 3
ZEND_ASSIGN   $soma, TMP0
ZEND_ECHO     $soma
```

### 2.5 Zend VM + dispatcher → execução
- **VM (máquina virtual)**: um programa que se comporta como um processador,
  mas executa um conjunto de instruções próprio (os opcodes), não as
  instruções nativas da CPU.
- **Dispatcher**: o "porteiro" da VM. Pega o opcode atual, lê o rótulo
  (`ZEND_ADD`, `ZEND_ECHO`...), decide qual função interna (handler) sabe
  executar aquilo, manda executar, e avança pro próximo opcode. Ele não
  "entende" a operação — só roteia pra quem entende. Igual a um centro de
  triagem: lê a etiqueta do pacote e manda pro setor certo, sem abrir o
  pacote.

```
enquanto houver opcodes:
    pega o opcode atual
    descobre o handler responsável
    executa
    avança
```

---

## 3. O ciclo de vida por requisição (a diferença mais importante)

Esse pipeline inteiro (lexer → parser → AST → compilador → VM) roda **do
zero, a cada requisição HTTP**, por padrão. Quando a requisição termina:

- a AST é descartada
- os opcodes são descartados
- as variáveis são destruídas

Nada persiste de uma requisição pra outra, a não ser que você grave isso
explicitamente em algo externo (sessão, banco, cache, arquivo).

**Por que isso importa na prática:** é a razão de o Laravel (e o PHP em geral)
investir tanto em cache — cache de configuração, cache de rotas, `OPcache`
(que guarda os opcodes já compilados e pula lexer/parser/AST/compilador nas
próximas requisições, mas ainda executa a VM toda vez). O objetivo desses
mecanismos é sempre o mesmo: evitar refazer as partes caras do pipeline.

---

## 4. Tipagem resolvida em tempo de execução

Cada variável em PHP é internamente um container chamado **zval**, que guarda
o valor **e** uma marca de tipo — e essa marca pode mudar durante a execução.
Isso significa que decisões de tipo (como converter `"10"` para número antes
de somar) acontecem **durante** a execução do opcode correspondente
(`ZEND_ADD`), não antes. É por isso que o PHP consegue fazer:

```php
$x = "10" + 5; // 15 — decidido no momento em que o opcode ZEND_ADD roda
```

---

## 5. Próximo passo prático

Existe uma extensão chamada `vld` que exibe os opcodes reais gerados para um
script PHP — dá pra rodar um trecho próprio e ver, opcode por opcode, o que o
Zend Engine gerou. É o jeito mais direto de comprovar tudo isso na prática.

---

## 6. Onde isso conecta com o que vem depois

- **Aula 03 — Estrutura de uma Classe**: como esse mesmo pipeline compila a
  definição de uma classe antes de qualquer objeto existir.
- **Laravel (mais à frente)**: cache de rotas/config e `OPcache` só fazem
  sentido depois de entender por que o pipeline roda do zero a cada request.