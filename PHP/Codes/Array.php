<?php
// ==========================================
// GUIA DE ESTUDOS: VETORES E ARRAYS EM PHP
// ==========================================

// --- 1. O CONCEITO DE ARRAY ---
// Estrutura de dados que armazena uma coleção de elementos de tal forma que 
// cada um dos elementos possa ser identificado por, pelo menos, um índice ou uma chave.
// Também chamados de vetores.

// --- 2. O PROBLEMA DA ABORDAGEM TRADICIONAL (NÃO VIÁVEL) ---
// Se tivéssemos 100 cursos, teríamos que criar 100 variáveis separadas, 
// o que torna o código impossível de gerenciar em loops ou sistemas reais:
$cursoA = "PHP";
$cursoB = "Java";
$cursoC = "C++";

echo $cursoA;
echo $cursoB;


// --- 3. A SOLUÇÃO COM ARRAYS ---
// Agrupamos todos os valores em uma única estrutura indexada:
$cursos = array("PHP", "JAVA", "REDES", "C");

// --- POR QUE USAR O print_r()? ---
// O comando 'echo' serve apenas para imprimir strings simples ou números na tela. 
// Se você tentar dar um 'echo $cursos', o PHP vai disparar um erro do tipo "Array to string conversion" 
// porque ele não sabe transformar uma lista inteira em um texto simples.
// O 'print_r()' (Print Readable) foi feito exatamente para isso: 
// ele exibe estruturas de dados complexas (como Arrays e Objetos) de forma legível, 
// mostrando o índice e o valor de cada elemento.
print_r($cursos);


// --- 4. COMO ACESSAR UM ÍNDICE ESPECÍFICO ---
// Os arrays em PHP começam a contar os índices a partir do ZERO (0).
// Portanto: índice 0 = "PHP", índice 1 = "JAVA", índice 2 = "REDES", etc.

// Correção importante sobre o seu trecho original (`print_r([2])`):
// Para acessar o elemento de um array guardado em uma variável, 
// você deve passar o nome da variável seguido do índice entre colchetes:
print_r($cursos[2]); // Vai exibir exatamente: REDES

?>