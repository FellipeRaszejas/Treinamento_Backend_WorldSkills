<?php
  // Leia o Desafio e siga o código base abaixo para resolvê-lo. Algumas dicas:
  // 1. Use a função "fgets(STDIN)" para ler uma linha de Entrada;
  // 2. Use a função "echo" formatar e imprimir sua(s) Saída(s).

  $distancia = intval(fgets(STDIN));

  // Cada quilômetro de distância leva 2 minutos para ser acumulado
  $tempo = $distancia * 2;

  // Imprime o tempo calculado seguido da mensagem " minutos" e quebra de linha
  echo "$tempo minutos\n";
?>