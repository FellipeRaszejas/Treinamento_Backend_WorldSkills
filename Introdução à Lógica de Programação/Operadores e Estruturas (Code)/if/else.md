IF ELSE & IF-ELSE

IF (Do inglÊs ser: "se")

se a condição dentro do if for verdadeira algo deve acontecer
$nome = fellipe;
if ($nome == "fellipe"){
    return true;
}

else seria o resultado de caso o if estivesse errado, se não é a primeira condição, será a última
else{
    return false
}


if else se trata sobre uma nova possibilidade dentro das opções, uma terceira, quarta, n° opções até ser enviada para a ultima

$nome = carlos
if ($nome == "fellipe"){
    return true;
}
else if(nome = "carlos"){
    return "true";
}
else seria o resultado de caso o if estivesse errado, se não é a primeira condição, será a última
else{
    return false
}

abaixo tem uma imagem de uma matriz com as respostas tendo if else presente
.


Também tem o caso do "ternario" (aprendi o nome no java)

que dava a condição e depois opção a ou bc

$nota => 7 ? true : false


corrigido da IA:
. Estrutura BÁSICA (IF/ELSE)
Objetivo: Avaliar Verdadeiro/Falso ou Rodando/Inativa.

PHP
<?php
// Adicionamos aspas
$nome = "fellipe"; 

if ($nome == "fellipe") { // Compara com '=='
    echo "Está rodando! (Verdadeiro)";
    // Em uma função, você usaria: return true;
} else {
    echo "Inativa! (Falso)";
    // Em uma função, você usaria: return false;
}
?>
2. Múltiplas Possibilidades (IF / ELSE IF / ELSE)
Objetivo: Avaliar qual informação específica está Presente.

PHP
<?php
$nome = "carlos"; // Informação presente

if ($nome == "fellipe") {
    echo "É o Fellipe (Verdadeiro)";
}
// CORREÇÃO: Adicionamos aspas em "carlos" e o segundo '=' no '=='
else if ($nome == "carlos") { 
    echo "É o Carlos (Presente)";
}
else {
    echo "Nenhuma das opções (Informação Ausente)";
}
?>
3. O Ternário no PHP
O nome é o mesmo do Java ("operador ternário"), e ele é excelente para definir um estado de forma rápida. O PHP também suporta retornar outros tipos de dados, não apenas true ou false:

PHP
<?php
$nota = 8;

// A estrutura é: (condição) ? se_verdadeiro : se_falso;
$resultado = ($nota >= 7) ? "Aprovado (Positivo)" : "Reprovado (Negativo)";

echo $resultado; // Saída: Aprovado (Positivo)
?>


Finaliza em switch case 

Uma estrutura condicional que trabalha até um valor ser equivante ao passado

switch(cargo){
    case 1: cargo="programador";
    break;

     case 2: cargo="encanador";
    break;

     case 3: cargo="professor";
    break;
}