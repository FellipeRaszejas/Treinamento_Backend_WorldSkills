<?php
  // Leia o Desafio e siga o código base abaixo para resolvê-lo. Algumas dicas:
  // 1. Use a função "fgets(STDIN)" para ler uma linha de Entrada;
  // 2. Use a função "echo" formatar e imprimir sua(s) Saída(s).

  $a = intval(fgets(STDIN));
  $b = intval(fgets(STDIN));
  
  // Cria a variável para receber a soma de $a e $b
  $soma = $a + $b;

  // Imprime no formato exigido: SOMA = valor (com quebra de linha ao final)
  echo "SOMA = $soma\n";
?>