<?php
// ==========================================
// GUIA DE ESTUDOS: STRINGS E HTML EM PHP
// ==========================================

// --- 1. O CONCEITO DE STRING ---
// Sequência de caracteres, geralmente utilizada para representar palavras, 
// frases ou textos de um programa. Pode ser implementada com aspas duplas ("") 
// ou simples (''), passada tanto diretamente no ECHO, quanto em variável ou constante.
echo "Isso é uma string, implementada com aspas duplas ou simples, passada tanto em variavel, constant quanto no ECHO\n";

// Atribuindo uma string a uma variável
$varString = "Isso é uma string em variavel"; 

// Exibindo a variável na tela
echo $varString;


// --- 2. INTEGRAÇÃO COM HTML ---
// O PHP roda no servidor, mas ele pode gerar e cuspir código HTML diretamente 
// para o navegador do cliente renderizar. É possível passar tags como h1, h2, etc., 
// dentro de uma string ou variável, suportando totalmente tags HTML!

$h10 = "<h1>Texto em H1</h1>";
echo $h10; // O navegador vai interpretar a tag e exibir o texto com estilo de cabeçalho principal

?>