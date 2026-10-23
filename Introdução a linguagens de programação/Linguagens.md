# Características das Linguagens de Programação

Este guia apresenta quatro critérios usados para avaliar e comparar linguagens de programação (legibilidade, custo, confiabilidade e capacidade de escrita) e os fatores de mercado que influenciam a escolha de uma linguagem em 2026.

## Sumário

1. [Legibilidade (Readability)](#1-legibilidade-readability)
   - [Conceito de tipagem e estruturas](#conceito-de-tipagem-e-estruturas)
   - [Associação com as linguagens](#associação-com-as-linguagens)
2. [Custo (Cost)](#2-custo-cost)
   - [Associação com as linguagens](#associação-com-as-linguagens-1)
3. [Confiabilidade (Reliability)](#3-confiabilidade-reliability)
   - [Tratamento de exceções (try/catch) e tipos](#tratamento-de-exceções-trycatch-e-tipos)
   - [Ponteiros e segurança](#ponteiros-e-segurança)
   - [Associação com as linguagens](#associação-com-as-linguagens-2)
4. [Capacidade de Escrita (Writability)](#4-capacidade-de-escrita-writability)
   - [Operadores expressivos e reuso](#operadores-expressivos-e-reuso)
   - [Associação com as linguagens](#associação-com-as-linguagens-3)
5. [Outros Fatores Críticos do Mercado Atual (2026)](#5-outros-fatores-críticos-do-mercado-atual-2026)
   - [Atualizações e ecossistema](#atualizações-e-ecossistema)
   - [Frameworks e ferramentas](#frameworks-e-ferramentas)
   - [Adoção pelo mercado e comunidade](#adoção-pelo-mercado-e-comunidade)
   - [Uso para Inteligência Artificial (IA)](#uso-para-inteligência-artificial-ia)
6. [Resumo](#6-resumo)

**Linguagens citadas neste guia:** Python, TypeScript, JavaScript, PHP, Java, C#, Go, C, C++ e Rust.

---

## 1. Legibilidade (Readability)

**Conceito:** a legibilidade mede a facilidade com que os seres humanos conseguem **ler, compreender e manter** o código. Envolve a ortogonalidade (consistência das regras), o uso de palavras-chave intuitivas e estruturas bem definidas.

**No dia a dia:** é como uma receita de bolo. Uma receita com passos numerados e medidas claras qualquer pessoa segue; uma receita escrita em um bloco só, com abreviações misteriosas, dá trabalho até para quem já cozinha bem.

### Conceito de tipagem e estruturas

O uso claro de tipos de dados como `int` (inteiro), `string` (texto) e `bool` (booleano) melhora drasticamente a legibilidade, porque quem lê já sabe que tipo de valor cada variável guarda.

```python
# Exemplo em Python (Alta legibilidade e tipagem dinâmica/opcional)
idade: int = 25
nome: str = "Fellipe"
ativo: bool = True
```

- `idade: int = 25`: a variável `idade` recebe o valor 25, e a anotação `: int` informa que se espera um número inteiro.
- `nome: str` e `ativo: bool`: seguem a mesma ideia, para texto e para verdadeiro/falso.
- Em Python essas anotações são opcionais (a tipagem é dinâmica), mas deixam o código mais fácil de entender.

### Associação com as linguagens

| Linguagens | Legibilidade | Motivo |
|---|---|---|
| Python e TypeScript | Excelente | Sintaxe limpa e tipagem explícita ou intuitiva |
| Java e C# | Boa | Estrutura baseada em blocos claros, orientados a objetos |
| C e C++ | Baixa (relativa) | Complexidade de sintaxe e gerenciamento manual |

---

## 2. Custo (Cost)

**Conceito:** o custo de um software engloba o **ciclo de vida completo**, e não apenas o tempo de escrever o código.

**No dia a dia:** é como comprar um carro. Existe o preço de compra, o custo de aprender a dirigir, o consumo de combustível e o gasto com manutenção. Um carro barato de comprar pode sair caro de manter.

| Componente do custo | O que representa |
|---|---|
| **Treinamento** | Tempo e dinheiro para capacitar desenvolvedores na linguagem |
| **Codificação** | Velocidade com que o software é escrito |
| **Compilação e Execução** | Recursos de hardware (CPU e memória) consumidos para rodar o programa |
| **Infraestrutura** | Custo dos servidores para hospedar a aplicação |

### Associação com as linguagens

| Linguagens | Custo de codificação e treinamento | Custo de execução e infraestrutura | Observação |
|---|---|---|---|
| Python, PHP e JavaScript | Baixo (treinamento rápido) | Maior que o das linguagens compiladas | Exemplo de infraestrutura web otimizada: frameworks como o Laravel, em PHP |
| C, C++ e Rust | Alto (exigem cuidado extremo com a memória) | Baixíssimo | Rodam extremamente rápido, direto no metal |
| Java, C# e Go | Intermediário | Intermediário | Excelente equilíbrio corporativo entre velocidade de desenvolvimento e performance de execução |

---

## 3. Confiabilidade (Reliability)

**Conceito:** a confiabilidade avalia o quão fielmente o programa executa **o que foi projetado para fazer**, lidando com falhas inesperadas por meio de tratamento de exceções, verificação de tipos e segurança de memória.

**No dia a dia:** é como o disjuntor de um circuito elétrico. Quando acontece uma sobrecarga, ele desarma e protege a casa, em vez de deixar tudo queimar.

### Tratamento de exceções (try/catch) e tipos

```java
// Exemplo em Java (Confiabilidade com verificação estática de tipos e exceções)
try {
    int resultado = 10 / 0; // Tentativa de divisão por zero
} catch (ArithmeticException e) {
    System.out.println("Erro: Divisão por zero não permitida!");
}
```

- `try`: bloco onde o código "perigoso" é executado.
- `10 / 0`: divisão por zero, que gera uma exceção (`ArithmeticException`).
- `catch`: captura o erro e executa uma resposta controlada, em vez de o programa quebrar.

### Ponteiros e segurança

Linguagens como o C permitem acesso direto à memória por meio de **ponteiros** (`int *ptr`), o que pode gerar falhas críticas se forem mal utilizados. Em contrapartida, o Rust garante segurança de memória **em tempo de compilação**, sem precisar de um coletor de lixo (*garbage collector*).

### Associação com as linguagens

| Linguagens | Confiabilidade | Motivo |
|---|---|---|
| Rust | Altíssima | O compilador bloqueia erros de ponteiro |
| Java | Altíssima | Forte tipagem estática e gestão automática de memória |
| TypeScript | Alta | Adiciona verificação de tipos estáticos ao JavaScript, trazendo confiabilidade ao ecossistema web |
| C e C++ | Menor (nativa) | Segurança de memória exige disciplina rigorosa do programador |

---

## 4. Capacidade de Escrita (Writability)

**Conceito:** a capacidade de escrita (*writability*) mede a facilidade com que o programador consegue **escrever** código. Envolve expressividade, reuso de código, suporte a abstração e operadores compactos. Pode entrar em conflito com a legibilidade se a linguagem for complexa demais.

**No dia a dia:** é como ter uma cozinha bem equipada. Com uma batedeira, uma tarefa que levaria muito tempo à mão fica pronta em minutos, mas uma cozinha cheia de aparelhos complicados também pode dificultar quem vai ler e repetir a receita depois.

### Operadores expressivos e reuso

Operadores como `++`, `--`, `===`, `&&` e o uso de funções permitem escrever muito com pouco código.

```javascript
// Exemplo em JavaScript (Alta expressividade com operadores lógicos e estritos)
let contador = 0;
contador++; // Incremento

const validarAcesso = (usuario, senha) => {
    return usuario === "admin" && senha !== ""; // Uso de operadores estritos e lógicos
};
```

- `contador++`: soma 1 ao contador em uma única instrução.
- `validarAcesso`: função reutilizável, que pode ser chamada quantas vezes for preciso.
- `===` e `!==`: comparam valor **e** tipo (operadores estritos).
- `&&`: exige que as duas condições sejam verdadeiras ao mesmo tempo.

### Associação com as linguagens

| Linguagens | Capacidade de escrita | Motivo |
|---|---|---|
| JavaScript, TypeScript e Python | Altíssima | Sintaxes flexíveis, bibliotecas ricas e forte suporte a abstrações de alto nível |
| C | Baixa para lógicas complexas | Exige muito mais linhas redundantes para tarefas simples que outras linguagens resolvem com uma única função embutida |

---

## 5. Outros Fatores Críticos do Mercado Atual (2026)

### Atualizações e ecossistema

Linguagens como TypeScript, Rust e Go recebem atualizações frequentes e focadas na produtividade moderna.

### Frameworks e ferramentas

| Linguagem | Destaque em frameworks e ferramentas |
|---|---|
| PHP | Fortemente impulsionado pelo Laravel para desenvolvimento web robusto |
| JavaScript e TypeScript | Dominados por ecossistemas como React, Node.js e Next.js |
| Python | Líder isolado em frameworks de Inteligência Artificial e Ciência de Dados (PyTorch, TensorFlow) |
| Java e C# | Gigantes consolidados em ambientes corporativos, por meio do Spring Boot e do .NET |

### Adoção pelo mercado e comunidade

JavaScript, TypeScript e Python lideram os índices globais de adoção e de comunidades ativas (GitHub, Stack Overflow).

### Uso para Inteligência Artificial (IA)

| Linguagem | Papel na IA |
|---|---|
| Python | Base absoluta para a criação de modelos de IA e *Machine Learning* |
| C++ e Rust | Entram no cenário de IA para otimização de performance e inferência de modelos de grande escala em hardware dedicado (GPUs) |

---

## 6. Resumo

| Critério | O que mede | Linguagens em destaque | Ponto de atenção |
|---|---|---|---|
| **Legibilidade** | Facilidade de ler, entender e manter o código | Python e TypeScript | C e C++ têm sintaxe complexa e gerenciamento manual |
| **Custo** | Ciclo de vida completo: treinamento, codificação, execução e infraestrutura | Java, C# e Go (equilíbrio) | C, C++ e Rust custam mais para aprender; Python, PHP e JavaScript custam mais para executar |
| **Confiabilidade** | Fidelidade ao projeto e tratamento de falhas | Rust e Java | C e C++ exigem disciplina rigorosa com a memória |
| **Capacidade de escrita** | Facilidade de escrever código | JavaScript, TypeScript e Python | C exige muitas linhas para tarefas simples |