<?php

$arr = [1, 5, 3, 0];
$qtd_elementos_array = count($arr);

for ($i = 0; $i < $qtd_elementos_array - 1; $i++) {
    for ($PosicaoAtual = 0; $PosicaoAtual < $qtd_elementos_array - $i - 1; $PosicaoAtual++) {
        
        $ProximaPosicao = $PosicaoAtual + 1;

        if ($arr[$ProximaPosicao] < $arr[$PosicaoAtual]) {
            $auxiliar = $arr[$PosicaoAtual];
            $arr[$PosicaoAtual] = $arr[$ProximaPosicao];
            $arr[$ProximaPosicao] = $auxiliar;
        }
    }
}

// Exibe o array ordenado
echo "Array ordenado: ";
print_r($arr);

?>