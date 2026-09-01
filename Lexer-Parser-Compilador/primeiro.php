<?php
// ===============================================================================
// 1. BASE CONCEITUAL (POO vs. SINTAXE)
// ===============================================================================
// Existe a classe que é o molde de tudo (nesse caso: 'Carro'), os objetos são copias 
//transítorios que existem durante a execução.
// Atributos (Propriedades): Atributos são características/estados do objeto (ex: cor, modelo, quantidade de bateria). O valor deles pode mudar à vontade ao longo da execução.

// Métodos: Não se definem por "receber ou não um valor". Métodos são os comportamentos/ações que o objeto pode realizar (ex: acelerar, frear, carregar bateria).

class Carro{
    public string $cor;
    public function __construct(string $cor){
        $this->cor = $cor;
    }
    public function acelerar(): string {
        return "vrummmmm";
    }
}
// Herança (Inferência)
class carroEletrico extends Carro{
    public int $bateria = 100;
}

$meuCarro = new Carro("ferrari");
$outroCarro = new carroEletrico("raszejas");

// resultados para teste
// 2. Testando a saída dos dados
echo "Carro normal: " . $meuCarro->cor . "\n";
echo "Som do motor: " . $meuCarro->acelerar() . "\n\n";

echo "Carro elétrico: " . $meuCarro->cor . "\n";
echo "Som do elétrico: " . $meuCarro->acelerar() . "\n"; // Herdou o método acelerar()
echo "Bateria: " . $outroCarro->bateria . "%\n";