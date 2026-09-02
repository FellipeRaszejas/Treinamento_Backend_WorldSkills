# Como o PHP Executa Classes e Objetos por Baixo dos Panos

Sem problema — só PHP, e o foco aqui é **o que a máquina faz**, não como escrever código.

Vamos usar esta classe como cobaia:

```php
class ContaBancaria
{
    private int $numero;
    private float $saldo;
    private string $titular;

    public function __construct(int $numero, string $titular)
    {
        $this->numero = $numero;
        $this->titular = $titular;
        $this->saldo = 0.0;
    }

    public function depositar(float $valor): bool
    {
        if ($valor <= 0) {
            return false;
        }

        $this->saldo += $valor;

        return true;
    }

    public function __toString(): string
    {
        return "Numero: {$this->numero}\nTitular: {$this->titular}\nSaldo: {$this->saldo}";
    }
}
```

---

## 1. O que acontece quando o interpretador lê `class ContaBancaria { ... }`?

Isso passa pelo mesmo pipeline que já vimos:

```text
Código PHP
    ↓
Lexer
    ↓
Parser
    ↓
AST
    ↓
Compilador
    ↓
Opcodes
```

Porém, quando o compilador encontra uma classe, ele precisa produzir uma estrutura específica que representa essa classe na memória.

No PHP, essa estrutura é conhecida como **class entry** (`zend_class_entry` na implementação da Zend Engine).

Podemos imaginá-la, de forma simplificada, assim:

```text
┌──────────────────────────────────────┐
│          ContaBancaria               │
│        class entry                   │
├──────────────────────────────────────┤
│                                      │
│ Tabela de métodos                    │
│                                      │
│ "__construct" → função               │
│ "depositar"   → função               │
│ "__toString"  → função               │
│                                      │
├──────────────────────────────────────┤
│                                      │
│ Propriedades / metadados             │
│                                      │
│ "$numero"  → private                 │
│ "$saldo"   → private                 │
│ "$titular" → private                 │
│                                      │
└──────────────────────────────────────┘
```

Essa estrutura guarda, entre outras coisas:

* uma tabela de métodos;
* informações sobre as propriedades;
* modificadores de acesso;
* metadados da classe;
* informações necessárias para criar e manipular objetos daquela classe.

### A tabela de métodos

A tabela de métodos pode ser imaginada como uma hash table:

```text
nome do método → implementação
```

Por exemplo:

```text
"depositar"  → código que implementa depositar()
"__construct" → código que implementa __construct()
"__toString" → código que implementa __toString()
```

O ponto importante é:

> **O código dos métodos não é copiado para cada objeto.**

A estrutura da classe é criada uma vez e fica disponível na memória.

Se você fizer:

```php
$conta1 = new ContaBancaria(1, "Cainã");
$conta2 = new ContaBancaria(2, "Maria");
$conta3 = new ContaBancaria(3, "João");
```

não significa que o PHP criou três cópias de `depositar()`.

Existe uma implementação compartilhada:

```text
                ContaBancaria
                class entry
                     │
          ┌──────────┼──────────┐
          ↓          ↓          ↓
      depositar   __construct  __toString
          │
          │
    ┌─────┴─────┐
    ↓           ↓
 objeto 1     objeto 2
```

A classe funciona como um **molde estrutural e comportamental**.

---

# 2. O que acontece quando você executa `new ContaBancaria(...)`?

Agora temos uma mudança importante.

Quando o código executa:

```php
$conta = new ContaBancaria(1, "Cainã");
```

a VM precisa criar uma **instância** da classe.

De forma simplificada, podemos imaginar o processo assim:

```text
new ContaBancaria(...)
        │
        ↓
Procura a class entry
        │
        ↓
Aloca memória para o objeto
        │
        ↓
Inicializa suas propriedades
        │
        ↓
Associa o objeto à class entry
        │
        ↓
Procura __construct
        │
        ↓
Executa o construtor
```

## 2.1. A engine aloca memória para o objeto

Primeiro, a engine cria um novo bloco de memória que representa o objeto.

Podemos imaginá-lo assim:

```text
Objeto
┌───────────────────────────┐
│ class entry ──────────────┼──────→ ContaBancaria
│                           │
│ $numero                   │
│ $saldo                    │
│ $titular                  │
└───────────────────────────┘
```

Cada objeto possui seu próprio estado.

Por exemplo:

```text
$conta1
┌────────────────────┐
│ numero  = 1        │
│ saldo   = 100.00   │
│ titular = "Cainã"  │
└────────────────────┘


$conta2
┌────────────────────┐
│ numero  = 2        │
│ saldo   = 500.00   │
│ titular = "Maria"  │
└────────────────────┘
```

Os valores são diferentes porque pertencem a objetos diferentes.

---

# 3. Métodos são compartilhados, estado não

Essa é uma das ideias mais importantes para entender objetos em PHP.

Imagine:

```php
$conta1 = new ContaBancaria(1, "Cainã");
$conta2 = new ContaBancaria(2, "Maria");
```

As duas instâncias precisam ter:

```text
numero
saldo
titular
```

independentes.

Porém, não precisam de uma cópia própria do código:

```php
depositar()
```

A relação pode ser visualizada assim:

```text
                 ContaBancaria
                 class entry
                      │
          ┌───────────┼────────────┐
          │           │            │
          ↓           ↓            ↓
    __construct   depositar   __toString
          │           │            │
          └───────────┼────────────┘
                      │
             ┌────────┴────────┐
             ↓                 ↓
         $conta1           $conta2
         estado            estado
```

Ou seja:

> **O comportamento é definido pela classe; o estado pertence à instância.**

---

# 4. O objeto mantém uma referência para sua classe

O objeto precisa saber a qual classe pertence.

Isso permite que a engine saiba, entre outras coisas:

* quais métodos existem;
* quais propriedades existem;
* quais são as regras de acesso;
* quais métodos mágicos estão disponíveis.

Podemos pensar em algo parecido com:

```text
$conta
   │
   ↓
┌─────────────────┐
│ Objeto          │
│                 │
│ $numero         │
│ $saldo          │
│ $titular        │
│                 │
│ class entry ────┼──────────┐
└─────────────────┘          │
                             ↓
                  ┌───────────────────┐
                  │ ContaBancaria     │
                  │ class entry       │
                  │                   │
                  │ métodos           │
                  │ propriedades      │
                  │ metadados         │
                  └───────────────────┘
```

---

# 5. O construtor não é chamado "por educação"

Depois que o objeto é criado, a engine procura um método chamado exatamente:

```php
__construct
```

Se ele existir, a engine o chama automaticamente.

Por exemplo:

```php
$conta = new ContaBancaria(1, "Cainã");
```

conceitualmente desencadeia algo próximo de:

```text
new
 │
 ├── cria objeto
 │
 ├── encontra ContaBancaria
 │
 ├── procura "__construct"
 │
 └── chama:
       __construct(1, "Cainã")
```

Isso é importante:

> `__construct` não é apenas uma convenção que os programadores decidiram seguir.

É um nome reconhecido pela própria engine.

Ele funciona como um **método mágico**: um método que a engine pode invocar automaticamente em situações específicas.

---

# 6. Modificadores de acesso: `private`, `public` e `protected`

Considere:

```php
class ContaBancaria
{
    private float $saldo;
}
```

E depois:

```php
$conta->saldo;
```

Se essa tentativa de acesso acontecer fora do escopo permitido, ocorre um erro.

Mas onde está essa informação?

A propriedade possui metadados que incluem informações sobre sua visibilidade.

De forma simplificada:

```text
Propriedade
┌──────────────────────────┐
│ nome: "$saldo"           │
│ tipo: float              │
│ visibilidade: private    │
└──────────────────────────┘
```

Quando algum código tenta acessar:

```php
$conta->saldo
```

a engine precisa verificar o contexto daquele acesso.

Conceitualmente:

```text
Tentativa de acesso
        │
        ↓
Qual propriedade?
        │
        ↓
$saldo
        │
        ↓
Qual é a visibilidade?
        │
        ↓
private
        │
        ↓
Qual é o escopo atual?
        │
        ↓
É permitido?
     /      \
   sim       não
   ↓          ↓
acessa      erro
```

Portanto, o encapsulamento envolve **checagens feitas pela engine durante a execução**.

Isso é diferente de imaginar que `private` simplesmente "esconde" fisicamente o valor.

---

# 7. `__toString()`: como o PHP sabe que deve chamar esse método?

Considere:

```php
$conta = new ContaBancaria(1, "Cainã");

echo $conta;
```

A engine recebeu um objeto, mas precisa produzir uma string.

Objetos não possuem automaticamente uma representação textual universal.

Então o PHP verifica se a classe possui o método mágico:

```php
__toString
```

No nosso exemplo:

```php
public function __toString(): string
{
    return "Numero: {$this->numero}\nTitular: {$this->titular}\nSaldo: {$this->saldo}";
}
```

O processo pode ser imaginado assim:

```text
echo $conta
     │
     ↓
É um objeto
     │
     ↓
Procura __toString
     │
     ↓
Existe?
     │
    sim
     ↓
executa __toString()
     │
     ↓
obtém uma string
     │
     ↓
imprime
```

Novamente, o nome é importante.

A engine procura especificamente:

```text
"__toString"
```

Esse é o mecanismo dos **métodos mágicos**.

Eles funcionam como pontos de extensão para comportamentos específicos da linguagem.

---

# 8. Métodos mágicos são ganchos da engine

Alguns métodos mágicos conhecidos são:

```text
__construct
__destruct
__toString
__call
__get
__set
__isset
__unset
```

Eles não são mágicos no sentido de existir uma "mágica" acontecendo.

O mecanismo é mais simples:

```text
A engine está realizando uma operação
            │
            ↓
Existe um método especial relacionado?
            │
            ↓
        Procura pelo nome
            │
            ↓
          Executa
```

Por isso o nome precisa ser exatamente o esperado.

---

# 9. E a "sobrecarga de métodos"?

Aqui existe uma pegadinha importante.

Em linguagens como Java ou C++, podemos ter métodos com o mesmo nome e assinaturas diferentes:

```text
depositar(float)
depositar(float, int)
depositar(float, int, string)
```

Isso é **method overloading**.

PHP não funciona dessa maneira.

Se você tentar:

```php
class ContaBancaria
{
    public function depositar(float $valor)
    {
    }

    public function depositar(float $valor, int $numero)
    {
    }
}
```

isso não é permitido.

O problema acontece ainda durante a compilação.

---

# 10. Por que o PHP não permite dois métodos com o mesmo nome?

Uma forma simplificada de imaginar a tabela de métodos é:

```text
Hash Table

"depositar"   → função A
"__construct" → função B
"__toString"  → função C
```

O nome do método funciona como uma chave.

Não pode existir:

```text
"depositar" → função A
"depositar" → função B
```

como duas definições independentes da mesma classe.

Quando a engine está construindo a estrutura da classe, ela detecta a duplicidade e gera um erro fatal.

Portanto:

```text
Código PHP
    ↓
Lexer
    ↓
Parser
    ↓
AST
    ↓
Compilação da classe
    ↓
Construção da tabela de métodos
    ↓
Nome duplicado?
    ↓
SIM
    ↓
Erro
```

Nem chega ao ponto de executar os métodos.

---

# 11. Então como resolver o problema que a sobrecarga tentava resolver?

O problema normalmente não é "quero duas funções".

O problema real costuma ser:

> "Quero que um mesmo método consiga trabalhar com diferentes quantidades ou formas de argumentos."

O PHP possui outros mecanismos para isso.

---

## 11.1. Parâmetros com valor padrão

Podemos fazer:

```php
function depositar(float $valor, ?int $numero = null)
{
    // ...
}
```

Agora o mesmo método pode ser chamado de formas diferentes:

```php
depositar(100);
```

ou:

```php
depositar(100, 123);
```

Existe apenas um método:

```text
depositar
     │
     ├── valor
     │
     └── numero opcional
```

---

# 12. Argumentos variádicos

Outra possibilidade é utilizar `...`:

```php
function somar(int ...$numeros)
{
    // ...
}
```

Isso permite:

```php
somar(1);
```

```php
somar(1, 2);
```

```php
somar(1, 2, 3, 4, 5);
```

Internamente, os argumentos recebidos são agrupados:

```text
somar(1, 2, 3, 4)

        ↓

$numeros

┌───────────────┐
│ 1             │
│ 2             │
│ 3             │
│ 4             │
└───────────────┘
```

Ou seja, novamente temos **um único método**, mas ele consegue receber uma quantidade variável de argumentos.

---

# 13. `__call()`: interceptando métodos inexistentes

Existe ainda um mecanismo particularmente interessante:

```php
__call()
```

Imagine:

```php
$conta->qualquerCoisa(10, 20);
```

Mas o método `qualquerCoisa` não existe.

Normalmente, isso resultaria em um erro.

Porém, se a classe possuir:

```php
public function __call($nome, $argumentos)
{
    // ...
}
```

a engine pode utilizar esse método mágico.

O fluxo simplificado fica:

```text
$conta->qualquerCoisa(10, 20)
              │
              ↓
Procura "qualquerCoisa"
              │
              ↓
Existe na tabela de métodos?
          /          \
        sim           não
        ↓              ↓
    executa       procura __call
                       │
                       ↓
                  encontrou?
                    /    \
                  sim     não
                  ↓        ↓
              executa     erro
              __call
```

O `__call()` recebe:

```text
nome do método
      +
argumentos
```

Por exemplo:

```php
public function __call($nome, $argumentos)
{
    var_dump($nome);
    var_dump($argumentos);
}
```

Uma chamada:

```php
$conta->depositarEspecial(100, 200);
```

poderia resultar conceitualmente em:

```text
$nome
↓
"depositarEspecial"

$argumentos
↓
[
    100,
    200
]
```

Isso permite criar comportamentos dinâmicos e, em determinados designs, **simular uma espécie de sobrecarga**.

Mas é importante entender a diferença:

> Isso não transforma o PHP em uma linguagem com method overloading tradicional.

Existe apenas um `__call()` interceptando chamadas para métodos que não foram encontrados normalmente.

---

# 14. Visão geral

Podemos juntar tudo em um único modelo mental:

```text
                    CÓDIGO PHP
                        │
                        ↓
                ┌───────────────┐
                │     Lexer     │
                └───────┬───────┘
                        ↓
                ┌───────────────┐
                │     Parser    │
                └───────┬───────┘
                        ↓
                ┌───────────────┐
                │      AST      │
                └───────┬───────┘
                        ↓
                ┌───────────────┐
                │   Compilador  │
                └───────┬───────┘
                        ↓
                   Opcodes
                        │
                        ↓
              ┌───────────────────┐
              │    Class Entry    │
              │                   │
              │ métodos           │
              │ propriedades      │
              │ visibilidade      │
              │ metadados         │
              └─────────┬─────────┘
                        │
                 ┌──────┴──────┐
                 ↓             ↓
              objeto 1      objeto 2
                 │             │
              estado        estado
                 │             │
                 └──────┬──────┘
                        │
                  métodos
                  compartilhados
```

---

# 15. Resumo mental

Se você quiser guardar apenas algumas ideias, guarde estas:

### Classe

A classe compilada gera uma estrutura que representa a classe na memória:

```text
ContaBancaria
     │
     ├── métodos
     ├── propriedades
     ├── visibilidade
     └── metadados
```

### Objeto

Cada `new` cria uma nova instância:

```text
new ContaBancaria(...)
        ↓
     objeto
        ↓
   estado próprio
```

### Métodos

Os objetos não precisam carregar uma cópia própria do código dos métodos.

```text
objeto ─────→ class entry ─────→ métodos
```

### Propriedades

Cada objeto possui seu próprio estado:

```text
$conta1->saldo ≠ $conta2->saldo
```

### Construtor

Ao criar o objeto, a engine procura:

```text
__construct
```

e, se existir, executa automaticamente.

### Visibilidade

`private`, `protected` e `public` fazem parte das informações que a engine usa para verificar se determinado acesso é permitido.

### Métodos mágicos

São nomes especiais reconhecidos pela engine:

```text
__construct
__toString
__call
...
```

Eles funcionam como **ganchos para eventos específicos da execução**.

### Sobrecarga tradicional

PHP não permite:

```php
depositar(...)
depositar(...)
```

na mesma classe.

Para resolver necessidades semelhantes, usamos mecanismos como:

```text
valores padrão
variádicos
__call
```

---

# 16. A ideia central

No fim, uma classe em PHP não é simplesmente "um arquivo com funções dentro".

Para a engine, ela se transforma em uma estrutura que descreve:

```text
Quem sou?
Que propriedades tenho?
Que métodos tenho?
Quem pode acessar minhas propriedades?
Que comportamentos especiais possuo?
```

E quando fazemos:

```php
$conta = new ContaBancaria(1, "Cainã");
```

a engine utiliza essa estrutura para construir uma nova instância com **estado próprio**, mas que continua ligada à definição da classe e ao código dos métodos.

A distinção fundamental é:

```text
             CLASSE
               │
        ┌──────┴──────┐
        │             │
   comportamento     estrutura
        │             │
        └──────┬──────┘
               │
          class entry
               │
        ┌──────┴──────┐
        ↓             ↓
     objeto 1      objeto 2
        │             │
     estado          estado
     próprio         próprio
```

**Classe = definição compartilhada.**

**Objeto = instância com estado próprio.**

**Engine = mecanismo que conecta os dois durante a execução.**
