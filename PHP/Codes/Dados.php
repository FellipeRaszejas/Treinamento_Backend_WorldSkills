<?php
// ==========================================
// GUIA DE ESTUDOS: MANIPULAÇÃO DE DATAS E HORAS EM PHP
// ==========================================

// --- 1. CONFIGURAÇÃO DE FUSO HORÁRIO ---
// Define o fuso horário padrão para o horário oficial do Brasil (São Paulo),
// garantindo que o servidor traga a hora correta e não a hora UTC/GMT do exterior.
date_default_timezone_set('America/Sao_Paulo');

// --- 2. CAPTURA DE VARIÁVEIS DE DATA E HORA ---
$dia = date("d");     // Dia do mês com dois dígitos (ex: 01 a 31)
$mes = date("m");     // Mês do ano com dois dígitos (ex: 01 a 12)
$ano = date("y");     // Ano com dois dígitos (ex: 26 para 2026). Dica: use "Y" maiúsculo para 4 dígitos (2026).

// Nota sobre o formato de horas:
// 'h' minúsculo exibe o formato de 12 horas (com AM/PM). 
// Se quiser o formato de 24 horas (como o relógio brasileiro costuma usar), utilize 'H' maiúsculo: date("H:i:s")
$horario = date("h:i:s"); 

// --- 3. EXIBIÇÃO FORMATADA ---
// Interpolação de variáveis em strings para montar a mensagem completa
echo ("$dia/$mes/$ano e são $horario da noite\n");

// Exibindo a data diretamente com a função date compactada
echo date("d/m/y");

?>