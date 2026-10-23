<?php
// ==========================================
// GUIA DE ESTUDOS: TIPOS DE VARIÁVEIS E CONSTANTES EM PHP
// ==========================================


// --- 1. VARIÁVEIS ---
// Espaço na memória do computador que pode ser consultado ou alterado 
// durante a execução do algoritmo. Sempre começam com o cifrão ($).
$nome = "Fellipe";
$sobrenome = "Raszejas";
$hora = 8;

// Exibindo variáveis na tela (o PHP interpõe variáveis dentro de aspas duplas)
echo "Meu nome é: $nome $sobrenome e estudo $hora horas por dia\n";


// --- 2. CONSTANTES ---
// Armazenar valor fixo em memória que NÃO possa ser alterado.
// Exemplo: define("NOME_DA_CONSTANTE", "valor");
define("CPF", "********");
echo CPF;


// --- 3. PRÁTICA PERMITIDA COM VARIÁVEIS ---
// Variáveis podem ter seus valores alterados quantas vezes quisermos.
$contador = 1;
echo $contador; // Mostra 1
$contador = 2;
echo $contador; // Mostra 2 (mudou com sucesso!)


// --- 4. PRÁTICA PROIBIDA / QUEBRADA COM CONSTANTES ---
// O código abaixo geraria erro ou aviso se estivesse descomentado, 
// pois constantes não aceitam reatribuição de valor:
// define("contadores", 3);
// define("contadores", 4); // ERRO: Constante já definida!


// ==========================================
// 5. ANÁLISE DE CENÁRIOS: CONSTANTES DENTRO DE FUNÇÕES
// ==========================================
// Pergunta: Mas e se eu tentar redefinir o valor de uma constante dentro de uma função?
// Resposta: As constantes em PHP são globais por natureza e imutáveis. 
// Elas NÃO podem ser redefinidas, independentemente de ser dentro ou fora de uma função.

// Cenário A: Constante definida no começo e tentativa de reescrita dentro da função
define("ESCOPO_GLOBAL", "Valor Original");

function testarConstanteNaFuncao() {
    // Se tentarmos redefinir aqui dentro, o PHP emite um WARNING (aviso) 
    // informando que a constante já existe, e IGNORA a alteração.
    // define("ESCOPO_GLOBAL", "Novo Valor Tentado"); 
}

// Cenário B: Função escrita primeiro e tentativa de reescrita no fluxo geral
// A regra não muda: a primeira linha que executa o 'define' grava o valor na memória.
// Qualquer tentativa posterior de mudar o valor gera aviso e mantém o dado original.

?>