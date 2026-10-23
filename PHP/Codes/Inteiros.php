<?php
// ==========================================
// GUIA DE ESTUDOS: TIPOS NUMÉRICOS (INTEIROS) EM PHP
// ==========================================

// Todos os números inteiros (positivos e negativos)
// integer: Guarda valores menores (dentro do limite padrão da arquitetura do sistema)
// long: Em muitas linguagens (como Java/C++), representa números maiores de 64 bits. 
// No PHP moderno, os inteiros funcionam como o equivalente a 64 bits (o antigo 'long').

$number = 10;          // Inteiro positivo
$numberNegativo = -10; // Inteiro negativo

// Número extremamente grande. 
// O PHP lida com números muito grandes convertendo-os automaticamente 
// para o tipo 'float' (ponto flutuante) caso estoure o limite máximo de bits de um inteiro.
$numberlong = 10000000000000000000000000000000000000;

// --- FUNÇÃO PARA EXIBIR O TIPO E O VALOR DO DADO ---
// O var_dump() mostra informações estruturadas sobre a variável, 
// incluindo o seu tipo (int, float, etc.) e o valor exato guardado.
var_dump($number);         // Mostra que é um int(10)
var_dump($numberNegativo); // Mostra que é um int(-10)
var_dump($numberlong);     // Mostra que se transformou em float devido ao tamanho gigante!

?>