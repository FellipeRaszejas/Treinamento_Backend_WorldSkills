<?php
// ==========================================
// GUIA DE ESTUDOS: ESCOPO GLOBAL X LOCAL EM PHP
// ==========================================

// Variável global (criada fora de qualquer função, visível no script principal)
$a = 50;

// --- 1. TENTATIVA FALHA DE ACESSO DIRETO (SEM O 'GLOBAL') ---
// Se descomentado, daria erro porque a função não enxerga a variável de fora automaticamente:
// function subErrada(){
//     $x = $a - 40; 
//     return $x;
// }
// echo subErrada();


// --- 2. FORMA DE ACESSO USANDO A PALAVRA 'GLOBAL' ---
// A palavra 'global' puxa a variável de fora para dentro do escopo da função.
function subComGlobal()
{
    global $a; // Importa o $a global para dentro da função
    $x = $a - 40;
    return $x;
}
echo subComGlobal(); // Exibe 10


// --- 3. ESCOPO LOCAL (VARIÁVEL QUE FICA PRESA DENTRO DA FUNÇÃO) ---
// Variáveis criadas dentro de funções morrem assim que a função termina.
// Se descomentado, o echo $y daria erro porque $y não existe fora da função:
// function soma(){
//     $y = 10 + 40;
// }
// echo $y; // ERRO: Variável indefinida fora da função!

// Maneira correta retornando o valor para fora:
function somaCorreta()
{
    $x = 10 + 40;
    return $x;
}
echo somaCorreta(); // Exibe 50


// ==========================================
// 4. RESPONDENDO À SUA DÚVIDA: 
// "Por que não posso passar como parâmetro na global?"
// ==========================================
/*
O seu trecho comentado:
// function sub($a)
// {
//     $x = $a - 40;
//     return $x;
// }
// echo sub();

RESPOSTA DIRETA: 
Na verdade, VOCÊ PODE SIM passar como parâmetro! Inclusive, na engenharia de software 
e no desenvolvimento moderno (como no Laravel), passar dados por parâmetro é 
considerada a MELHOR PRÁTICA (muito mais limpa e segura do que usar a palavra 'global').

Por que o seu código deu errado?
Porque você criou a função exigindo um parâmetro (`sub($a)`), mas na hora de chamar 
a função você escreveu apenas `sub()` vazia. O PHP gerou um erro porque faltou 
enviar o dado obrigatório dentro dos parênteses.

Se você chamar a função passando a variável global corretamente, ela funciona perfeitamente:
*/

function subComParametro($valor)
{
    $x = $valor - 40;
    return $x;
}

// Passando a variável $a (que vale 50) como argumento para dentro da função:
echo subComParametro($a); // Vai funcionar perfeitamente e exibir 10!

?>