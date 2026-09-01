<?php

// ===============================================================================
// 2. O PIPELINE DE EXECUÇÃO DO PHP (E O VLD)
// ===============================================================================

// Lexer: Quebra em Tokens
// Parser: Monta a AST
// Compilador: Trata de opCodes
// Dispatcher: Le os opCodes e executa 
$soma = 2 + 3;
echo $soma;

/*===============================================================================
3. CICLO DE VIDA POR REQUISIÇÃO & OPCACHE
===============================================================================
    este script roda do zero a cada request.

    Ao final da execução. Todas as variaveis são DESTRUÍDAS da memória
    O opCache pula etapas comos Lexer->Parser->AST->Compilador (guardando opCodes compilados em RAM)
    mas a Zend VM ainda executa as linhas abaixo a cada request.
*/

$configuracaoCarregada = [
    'app_name' => 'meuSistema',
    'env' => 'production'
];
// Opcodes gerados para este loop serão executados do início ao fim a cada HTTP Request:
foreach ($configuracaoCarregada as $chave => $valor) {
    //processamento temporario
}

/*
===============================================================================
4. TIPAGEM RESOLVIDA EM TEMPO DE EXECUÇÃO (ZVAL & HANDLERS)
===============================================================================
- Internamente, $a e $b são estruturas em C chamadas 'zval' (guarda valor + tipo).
- A verificação de tipo NÃO acontece na compilação, mas SIM dentro do handler
  do opcode ZEND_ADD durante a execução na VM.
- O ZEND_ADD percebe que "10" é uma string numérica, converte implicitamente 
  para inteiro no momento da soma e atribui o tipo IS_LONG ao resultado final.
*/
$a = "10"; // zval (type: IS_STRING, value: "10")
$b = 5;    // zval (type: IS_LONG, value: 5)

$resultado = $a + $b;
