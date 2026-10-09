# Perguntas de revisão — PHP: do texto ao resultado

> Sem respostas de propósito. Uso pessoal para testar se o conceito ficou
> internalizado, não decorado.

## Base conceitual (POO)

1. Na analogia platônica, o que representa a Classe e o que representa o
   Objeto? Por que o Objeto é descrito como "transitório"?
2. Quais são os três movimentos que Aristóteles usa para descrever um "ser",
   e como cada um deles aparece numa classe em código?
3. Por que a herança é explicada como uma forma de inferência lógica?

## Lexer

4. O que é um token, e por que o lexer não entende ainda "o que o código faz"?
5. Dê um exemplo (pode ser diferente do usado na explicação) de uma linha de
   código PHP e tente listar os tokens que ela geraria.
6. Por que a analogia de "separar uma frase em palavras" é útil pra explicar
   o lexer, e onde ela é limitada?

## Parser e AST

7. Qual é a diferença entre uma lista de tokens e uma AST? O que a árvore
   adiciona que a lista sozinha não tem?
8. Por que a precedência de operadores (ex: multiplicação antes de soma)
   aparece na *estrutura* da árvore, e não em alguma regra separada?
9. Desenhe (no papel ou mentalmente) a AST de `$resultado = 2 + 3 * 4;`.
   Onde fica a multiplicação em relação à soma, e por quê?

## Compilador e opcodes

10. Por que a AST "ainda não é executável"? O que muda quando ela vira
    opcodes?
11. O que significa dizer que os opcodes são "instruções atômicas e burras"?
12. Se você tivesse que gerar opcodes (mesmo que simplificados) para
    `echo "Olá" . $nome;`, quais passos você imaginaria?

## Zend VM e dispatcher

13. Por que a Zend VM é chamada de "máquina virtual" se ela não é um
    processador físico?
14. Qual é exatamente o papel do dispatcher? O que ele NÃO faz (quem faz de
    fato o trabalho)?
15. Na analogia do centro de triagem, o que representa o "pacote", a
    "etiqueta" e o "setor"?

## Ciclo de vida por requisição

16. O que acontece com a AST, os opcodes e as variáveis quando uma requisição
    HTTP termina?
17. Por que essa característica do PHP não é uma "falha", mas uma escolha de
    arquitetura?
18. O que o `OPcache` resolve exatamente — e o que ele NÃO resolve (ou seja,
    o que ainda roda em toda requisição mesmo com ele ativado)?
19. Dê um exemplo prático de algo que você precisaria salvar explicitamente
    (sessão, banco, cache) porque, de outra forma, se perderia entre uma
    requisição e outra.

## Tipagem em tempo de execução

20. O que é um zval, e o que ele carrega além do valor em si?
21. Por que `"10" + 5` funciona em PHP sem erro de compilação? Em que momento
    exato essa conversão acontece?
22. Você consegue pensar num caso em que essa flexibilidade de tipo pode
    causar um bug silencioso? O que você faria pra se proteger disso?

## Conexão com o que vem depois

23. Por que entender esse pipeline vai ajudar a entender por que o Laravel
    tem cache de rotas e cache de configuração?
24. Se alguém te perguntasse "por que o PHP é mais lento que uma aplicação
    C# que fica de pé o tempo todo", que resposta você daria hoje, com suas
    próprias palavras?