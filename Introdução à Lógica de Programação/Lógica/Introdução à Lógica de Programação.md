# Introdução à Lógica de Programação

Guia para entender como os computadores "pensam" e como podemos nos comunicar com eles: o que é lógica, como ela se conecta ao pensamento filosófico, a definição técnica de lógica de programação e um exemplo cotidiano (tomar café) em formato de linha do tempo.

## Sumário

1. [O que é lógica?](#o-que-é-lógica)
2. [A definição de lógica](#a-frase-do-cortella-e-a-definição-de-lógica)
3. [Definição técnica de lógica de programação](#definição-técnica-de-lógica-de-programação)
4. [Exemplo cotidiano: tomar café](#exemplo-cotidiano-tomar-café)
5. [Conclusão](#conclusão)

## O que é lógica?

Em sua essência, lógica é a **resolução de um problema**. É a ferramenta intelectual que usamos para sair de uma situação de "travamento" e atingir um objetivo.

No contexto computacional, a lógica serve para traçar o caminho mais eficiente para que a máquina execute uma tarefa.

## A frase do Cortella e a definição de lógica

<p align="center">
  <img src="imagens/cortella.jpg" alt="Foto de Cortella" width="360">
</p>

Uma frase filosófica de Cortella resume bem o que é um problema:

> **"Problema é uma questão que foge da regra, impedindo de atingir um objetivo com eficiência e eficácia."**

Essa frase conversa diretamente com a definição filosófica de lógica:

> "Parte da filosofia que trata das formas do pensamento em geral (dedução, indução, hipótese, inferência etc.) e das operações intelectuais que visam à determinação do que é verdadeiro ou não."

A definição pode ser quebrada em três partes:

| Trecho | O que significa |
|---|---|
| **"Trata das formas do pensamento em geral"** | A lógica estuda as estruturas que o pensamento usa, não o conteúdo dele. Ela não se importa se você está pensando em café ou em física quântica, mas sim se a forma como você liga as ideias faz sentido. |
| **"(dedução, indução, hipótese, inferência etc.)"** | São as "ferramentas" do pensamento lógico. Usa-se a **dedução** para partir de regras gerais para casos específicos; a **indução** para criar regras gerais a partir de observações; criam-se **hipóteses** e fazem-se **inferências** (conclusões). |
| **"Determinação do que é verdadeiro ou não"** | É o objetivo final da lógica computacional. Para um computador, tudo se resume a valores verdadeiros (True/1) ou falsos (False/0). A lógica de programação organiza as operações para que o computador chegue à conclusão correta sobre o que fazer, com base nas condições estabelecidas. |

**Conexão:** a lógica computacional é a aplicação prática dessas "operações intelectuais" para criar o percurso que resolve o desvio (o problema) e atinge o objetivo com eficácia.

## Definição técnica de lógica de programação

> **A organização e o planejamento das instruções assertivas em um algoritmo, a fim de viabilizar a implementação de um programa.**

Isso significa que, antes de escrever o código em uma linguagem como Python ou Java, é preciso planejar a sequência exata de passos lógicos (o algoritmo) que a máquina deve seguir.

## Exemplo cotidiano: tomar café

Como aplicar a lógica na vida real, transformando um desejo em um algoritmo:

| | |
|---|---|
| **Objetivo** | Tomar café |
| **Problema** | Não tem café pronto |
| **A lógica (resolução)** | Criar e seguir um algoritmo para fazer café |

Um algoritmo é uma receita: precisa ser detalhado e estar na ordem correta para funcionar.

### Linha do tempo: o algoritmo para fazer café

<table>
  <tr>
    <td width="22%" align="center" valign="top"><h4>Passo 1</h4><b>Preparar a água</b></td>
    <td width="4%" align="center">→</td>
    <td width="22%" align="center" valign="top"><h4>Passo 2</h4><b>Preparar o coador e o pó</b></td>
    <td width="4%" align="center">→</td>
    <td width="22%" align="center" valign="top"><h4>Passo 3</h4><b>O processo de coar</b></td>
    <td width="4%" align="center">→</td>
    <td width="22%" align="center" valign="top"><h4>Passo 4</h4><b>O objetivo atingido</b></td>
  </tr>
  <tr>
    <td align="center" valign="top">♨️</td>
    <td></td>
    <td align="center" valign="top"><img src="imagens/passo-2-coador-e-po.jpg" alt="Coador com filtro de papel pronto para receber o pó de café" width="100%"></td>
    <td></td>
    <td align="center" valign="top"><img src="imagens/passo-3-coando-o-cafe.jpg" alt="Água quente sendo derramada sobre o pó de café no coador" width="100%"></td>
    <td></td>
    <td align="center" valign="top"><img src="imagens/passo-4-cafe-pronto.jpg" alt="Xícara de café pronto ao lado de grãos de café" width="100%"></td>
  </tr>
  <tr>
    <td align="center" valign="top">O primeiro passo é aquecer a água. Se não fizermos isso, o resto não importa.</td>
    <td></td>
    <td align="center" valign="top">Enquanto a água aquece, preparamos o coador com o filtro e o pó de café.</td>
    <td></td>
    <td align="center" valign="top">Assim que a água estiver quente (e não fervendo, para não queimar o pó: uma instrução assertiva!), derramamos a água sobre o pó no coador.<br><br><i>Opcional: neste ponto, podemos decidir se vamos adicionar açúcar à água ou ao café pronto.</i></td>
    <td></td>
    <td align="center" valign="top">Finalmente, temos o café pronto e podemos desfrutar.</td>
  </tr>
</table>

## Conclusão

Sem a organização lógica dos passos (o algoritmo), o problema de "não ter café" não seria resolvido e o objetivo de "tomar café" não seria atingido. É exatamente isso que fazemos ao programar: organizamos os passos para a máquina atingir um objetivo.