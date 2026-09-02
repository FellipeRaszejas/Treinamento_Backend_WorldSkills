# 🧠 Questões de Revisão — PHP por Baixo dos Panos

> **Objetivo:** testar sua capacidade de compreender e explicar o funcionamento interno de classes e objetos em PHP.
>
> Tente responder **sem consultar o README**. O importante não é usar os mesmos termos, mas conseguir construir uma explicação coerente do que a máquina está fazendo.

---

## 🟢 Nível 1 — Fundamentos

### 1. O que acontece quando o PHP encontra uma declaração como esta?

```php
class ContaBancaria
{
    // ...
}
```

Explique o caminho desde o código PHP até a representação da classe que será utilizada durante a execução.

---

### 2. O que é uma `class entry`?

Explique com suas próprias palavras:

* o que ela representa;
* por que ela existe;
* que tipo de informação ela precisa guardar.

---

### 3. Qual é a diferença entre a classe e um objeto?

Considere:

```php
$conta1 = new ContaBancaria(1, "Cainã");
$conta2 = new ContaBancaria(2, "Maria");
```

Explique o que é compartilhado entre `conta1` e `conta2` e o que é independente entre eles.

---

### 4. Por que não seria necessário criar uma cópia de `depositar()` para cada objeto?

Explique como dois objetos conseguem executar o mesmo método sem cada um possuir uma cópia própria do código.

---

### 5. O que acontece conceitualmente quando executamos:

```php
$conta = new ContaBancaria(1, "Cainã");
```

Descreva o processo em ordem, desde o `new` até a execução do construtor.

---

## 🟡 Nível 2 — Explique para outra pessoa

### 6. Imagine que alguém diga:

> "Cada objeto possui uma cópia de todos os métodos da classe."

Você considera essa afirmação correta?

Explique por quê.

---

### 7. Explique a relação entre um objeto e sua `class entry`.

Por que o objeto precisa estar associado à estrutura que representa sua classe?

---

### 8. Explique a seguinte afirmação:

> **"O comportamento é compartilhado, mas o estado é individual."**

Use `ContaBancaria` como exemplo.

---

### 9. Por que duas contas podem ter saldos diferentes se ambas utilizam o mesmo método `depositar()`?

Explique o que acontece quando:

```php
$conta1->depositar(100);
$conta2->depositar(500);
```

---

### 10. O que torna `__construct()` diferente de um método comum?

Explique por que podemos dizer que ele é um método reconhecido pela própria engine.

---

## 🟠 Nível 3 — Visibilidade e execução

### 11. O que acontece quando fazemos:

```php
$conta->saldo;
```

sendo `$saldo` uma propriedade `private`?

Explique o que a engine precisa verificar antes de permitir o acesso.

---

### 12. Onde você colocaria a informação de que uma propriedade é `private`?

Explique por que a engine precisa conhecer essa informação durante a execução.

---

### 13. Explique o conceito de **escopo atual de execução** nesse contexto.

Por que a engine precisa saber "de onde" uma propriedade está sendo acessada?

---

### 14. Compare estas três propriedades:

```php
public float $saldo;
protected float $saldo;
private float $saldo;
```

O que muda, do ponto de vista da engine?

---

### 15. Verdadeiro ou falso?

> "Uma propriedade `private` é fisicamente invisível para a memória fora do objeto."

Explique sua resposta.

---

## 🔵 Nível 4 — Métodos mágicos

### 16. O que acontece quando executamos:

```php
echo $conta;
```

e `$conta` é um objeto?

Descreva o processo que leva a engine a executar `__toString()`.

---

### 17. Por que `__toString()` pode ser considerado um "gancho" da engine?

Explique o que significa dizer que a engine reconhece determinados nomes de métodos.

---

### 18. Compare:

```php
$conta->__toString();
```

com:

```php
echo $conta;
```

Qual é a diferença conceitual entre essas duas situações?

---

### 19. Cite pelo menos três métodos mágicos e explique **qual situação da execução pode fazer a engine procurá-los**.

Não basta listar os nomes.

---

## 🔴 Nível 5 — Sobrecarga

### 20. Por que isto não funciona em PHP?

```php
class Calculadora
{
    public function somar(int $a, int $b)
    {
    }

    public function somar(int $a, int $b, int $c)
    {
    }
}
```

Explique em que momento o problema é detectado.

---

### 21. O que a tabela de métodos tem a ver com a impossibilidade de declarar dois métodos com o mesmo nome?

Explique usando a ideia de:

```text
nome → implementação
```

---

### 22. A seguinte afirmação está correta?

> "O PHP escolhe qual `depositar()` executar em tempo de execução com base na quantidade de argumentos."

Explique.

---

### 23. Como um parâmetro padrão resolve parte do problema que a sobrecarga tentava resolver?

Use um exemplo.

---

### 24. Como argumentos variádicos resolvem outro tipo de problema relacionado à quantidade de argumentos?

Explique o que acontece com:

```php
function somar(int ...$numeros)
{
}
```

quando fazemos:

```php
somar(1, 2, 3, 4);
```

---

## 🟣 Nível 6 — `__call()`

### 25. O que acontece quando fazemos:

```php
$conta->algumMetodoQueNaoExiste(10, 20);
```

e a classe possui um `__call()`?

Descreva o caminho percorrido pela engine.

---

### 26. O que são os dois principais dados recebidos pelo `__call()`?

Explique o significado de cada um.

---

### 27. Por que `__call()` não é exatamente a mesma coisa que method overloading tradicional?

Essa é uma questão importante. Tente explicar sem simplesmente dizer "porque PHP não tem overload".

---

## 🧩 Nível 7 — Conectando tudo

### 28. Construa mentalmente o seguinte cenário:

```php
$conta = new ContaBancaria(10, "Cainã");

$conta->depositar(500);

echo $conta;
```

Explique **tudo o que a engine precisa fazer**, desde a criação do objeto até a impressão da string.

Tente mencionar:

* `class entry`;
* objeto;
* estado;
* tabela de métodos;
* `__construct`;
* `depositar`;
* `__toString`.

---

### 29. Desenhe a memória conceitualmente

Represente usando ASCII algo semelhante a:

```text
ContaBancaria
     │
     ↓
class entry
     │
     ├── métodos
     ├── propriedades
     └── metadados
```

Depois adicione:

```php
$conta1
$conta2
$conta3
```

Mostre visualmente quais partes são compartilhadas e quais são individuais.

---

### 30. Explique esta frase:

> **"A classe é um molde, mas não é uma cópia do objeto."**

O que exatamente está sendo compartilhado?

O que é criado novamente quando usamos `new`?

---

## 🧠 Nível 8 — Questões de compreensão profunda

### 31. Se existirem 10.000 objetos `ContaBancaria`, quantas cópias conceituais do método `depositar()` precisam existir?

Explique seu raciocínio.

---

### 32. Se existirem 10.000 objetos, cada um com um saldo diferente, onde esses saldos precisam estar representados?

Por que não poderiam estar simplesmente na `class entry`?

---

### 33. Por que a engine não pode simplesmente procurar uma função global chamada `depositar()` quando fazemos:

```php
$conta->depositar(100);
```

O que a associação entre objeto e classe resolve?

---

### 34. Imagine que a engine encontre:

```text
"depositar" → implementação X
```

na tabela de métodos.

O que ainda precisa ser determinado antes de o método executar?

---

### 35. Se `__toString()` não existisse na classe, o que aconteceria conceitualmente ao tentar:

```php
echo $conta;
```

Por que a engine não consegue simplesmente "imprimir o objeto"?

---

## 🏆 Desafio final

### 36. Explique PHP Orientado a Objetos para alguém que sabe programar, mas não entende como a linguagem executa objetos.

Você tem **5 minutos** e não pode consultar material.

Sua explicação obrigatoriamente deve responder:

1. O que acontece quando uma classe é compilada?
2. O que é a `class entry`?
3. Onde ficam os métodos?
4. Onde fica o estado de cada objeto?
5. O que acontece durante um `new`?
6. Como `__construct()` é encontrado?
7. Como a visibilidade é verificada?
8. Como `__toString()` é encontrado?
9. Por que PHP não possui sobrecarga tradicional de métodos?
10. Qual é o papel de `__call()`?

---

# 🎯 Teste de domínio

Depois de responder, dê uma nota para cada resposta:

| Nota  | Significado                                                           |
| ----- | --------------------------------------------------------------------- |
| **0** | Não sei responder                                                     |
| **1** | Sei o conceito, mas não consigo explicar                              |
| **2** | Consigo explicar parcialmente                                         |
| **3** | Consigo explicar com clareza                                          |
| **4** | Consigo explicar e dar um exemplo                                     |
| **5** | Consigo explicar, exemplificar e conectar com o funcionamento interno |

### Resultado

```text
0–30   → Preciso revisar os fundamentos
31–60  → Entendo os conceitos principais
61–90  → Tenho uma boa compreensão
91–120 → Consigo explicar o funcionamento com segurança
121+   → Domínio muito bom do modelo mental
```

> 💡 **Regra de ouro:** se você consegue responder "o que acontece?" mas não consegue responder "por que a engine precisa fazer isso?", ainda existe espaço para aprofundar.
