# Debugging no PHP

Este guia explica o que é debugging, como o PHP classifica os erros em Notice, Warning, Parse Error e Fatal Error, e como configurar a exibição de erros em ambiente de desenvolvimento e de produção.

## Sumário

1. [O que é o debugging](#1-o-que-é-o-debugging)
2. [A anatomia dos erros no PHP](#2-a-anatomia-dos-erros-no-php)
   - [Notice (aviso leve)](#21-notice-aviso-leve)
   - [Warning (aviso moderado)](#22-warning-aviso-moderado)
   - [Parse Error (erro de sintaxe)](#23-parse-error-erro-de-sintaxe)
   - [Fatal Error (erro fatal)](#24-fatal-error-erro-fatal)
   - [Resumo dos níveis](#25-resumo-dos-níveis)
3. [O painel de controle: `error_reporting` e `display_errors`](#3-o-painel-de-controle-error_reporting-e-display_errors)
4. [Código para laboratório e teste](#4-código-para-laboratório-e-teste)
5. [Regra de ouro do desenvolvedor](#5-regra-de-ouro-do-desenvolvedor)

## 1. O que é o debugging

Debugging (depuração) é o processo sistemático de encontrar, analisar e corrigir comportamentos inesperados, falhas de sintaxe ou interrupções no código. Para que isso aconteça de forma controlada, o PHP possui um sistema nativo de relatórios de erros que avisa onde e por que o sistema falhou.

## 2. A anatomia dos erros no PHP

O PHP classifica os problemas em níveis de gravidade. Conhecer cada um deles ajuda a priorizar o que deve ser corrigido imediatamente.

### 2.1 Notice (aviso leve)

**O que é:** é o nível mais brando de alerta. O PHP encontrou algo incomum, mas consegue continuar rodando o script.

**Exemplo clássico:** usar uma variável que nunca foi criada ou inicializada. No PHP 7, esse caso gerava um Notice. A partir do PHP 8, o mesmo caso passou a gerar um Warning, por isso o Notice ficou raro no dia a dia.

**Impacto:** não quebra o sistema imediatamente, mas pode gerar comportamentos inesperados.

🟡 *Este nível não tem imagem de exemplo; a mensagem de Warning abaixo mostra o caso equivalente no PHP 8.*

### 2.2 Warning (aviso moderado)

**O que é:** um alerta de que algo não está funcionando como deveria e pode piorar depois. O script também continua rodando.

**Exemplo clássico:** tentar incluir um arquivo externo que não existe (`include('arquivo.php')`) ou usar uma variável não definida, como na imagem abaixo.

**Impacto:** indica falhas lógicas ou problemas de dependência que precisam de atenção.

<img src="imagens/warning-variavel-indefinida.jpg" alt="Editor VS Code mostrando um PHP Warning de variável indefinida ($result) na linha 42 do script.php" width="100%">

*Ilustração de um PHP Warning por variável indefinida. A mensagem diz que `$result` não foi definida e indica o arquivo e a linha.*

### 2.3 Parse Error (erro de sintaxe)

**O que é:** um erro crítico na gramática da linguagem. Ocorre antes mesmo do código rodar, no momento em que o interpretador lê o arquivo.

**Exemplo clássico:** esquecer um ponto e vírgula (`;`), fechar uma chave errada ou deixar uma aspa aberta.

**Impacto:** bloqueia totalmente a execução. Nenhum código daquele arquivo roda.

<img src="imagens/parse-error-bubble-sort.jpg" alt="Editor VS Code com o arquivo bubble_sort.php e a mensagem de Parse error na linha 14 no terminal" width="100%">

*Ilustração de um Parse Error em um código de ordenação (bubble sort). Note que o terminal mostra o erro de sintaxe antes de qualquer saída do script.*

### 2.4 Fatal Error (erro fatal)

**O que é:** um erro crítico que acontece durante a execução do script. O PHP tentou fazer algo impossível e precisou abortar a execução imediatamente.

**Exemplo clássico:** chamar uma função ou instanciar uma classe que não foi definida no sistema. A imagem abaixo mostra outro caso: a função `count()` recebeu um inteiro quando esperava um array, o que gera um `TypeError` não tratado.

**Impacto:** interrompe a execução na hora. Tudo o que estava abaixo daquela linha é cancelado.

<img src="imagens/fatal-error-typeerror-count.jpg" alt="Editor VS Code mostrando um Fatal error Uncaught TypeError: count() esperava array e recebeu integer, na linha 12" width="100%">

*Ilustração de um Fatal error do tipo `TypeError`, causado pela chamada de `count()` com um inteiro.*

### 2.5 Resumo dos níveis

| Nível | Gravidade | O script continua? | Exemplo típico |
|---|---|---|---|
| Notice | Baixa | Sim | Variável não inicializada (PHP 7) |
| Warning | Média | Sim | Arquivo inexistente no `include` |
| Parse Error | Crítica | Não, nenhum código do arquivo roda | Ponto e vírgula esquecido |
| Fatal Error | Crítica | Não, para na linha do erro | Função não definida |

## 3. O painel de controle: `error_reporting` e `display_errors`

Para gerenciar como o PHP lida com os erros, usamos duas configurações. Elas trabalham juntas, mas têm papéis diferentes.

| Configuração | Pergunta que responde | Valores comuns | Exemplo |
|---|---|---|---|
| `error_reporting` | Quais erros capturar? | `E_ALL`, `E_WARNING`, `E_NOTICE` | `error_reporting(E_ALL);` |
| `display_errors` | Mostrar os erros na tela? | `'1'` ou `'On'` / `'0'` ou `'Off'` | `ini_set('display_errors', '1');` |

**`error_reporting`** é o filtro. Define quais tipos de erro o PHP deve rastrear e registrar. Com `error_reporting(E_ALL);`, o PHP fica de olho em todos os tipos de erro.

**`display_errors`** é a exibição. Define se os erros capturados aparecem na tela do usuário ou ficam ocultos.

* Valor `'1'` ou `'On'`: mostra os erros direto na tela. É ótimo para ambiente de desenvolvimento e local.
* Valor `'0'` ou `'Off'`: oculta os erros da tela. É obrigatório em produção, para não expor a estrutura do banco de dados ou os caminhos do servidor a invasores.

## 4. Código para laboratório e teste

O código abaixo reúne as configurações e simula o comportamento dos erros para você testar no seu ambiente local.

```php
<?php

// 1. Configurando o sistema de erros para ambiente de Desenvolvimento
// Ativa a exibição de erros diretamente na tela
ini_set('display_errors', '1');

// Define que o PHP deve relatar absolutamente todos os tipos de erros (Notice, Warning, Fatal, etc.)
error_reporting(E_ALL);

echo "<h2>Painel de Testes de Erros em PHP</h2>";

// -------------------------------------------------------------
// TESTE 1: Gerando um NOTICE (Variável não definida)
// -------------------------------------------------------------
echo "<p>Testando Notice:</p>";
// A variável $idade não existe, o PHP emite um Notice, mas continua rodando.
echo "A idade do usuário é: " . ($idade ?? "Não informada") . "<br>"; 
// Forçando o Notice puro:
// echo $variavelInexistenteNotice;


// -------------------------------------------------------------
// TESTE 2: Gerando um WARNING (Arquivo inexistente)
// -------------------------------------------------------------
echo "<p>Testando Warning:</p>";
// O arquivo não existe, o PHP emite um Warning, mas o código abaixo dele executa.
@include('arquivo_que_nao_existe.php'); 
echo "O script sobreviveu ao Warning e continua rodando!<br>";


// -------------------------------------------------------------
// TESTE 3: Simulando um FATAL ERROR (Função não definida)
// -------------------------------------------------------------
// ATENÇÃO: Se descomentar a linha abaixo, o script vai parar IMEDIATAMENTE aqui.
// funcaoInexistenteParaPararTudo();

echo "<br><b>Fim do script executado com sucesso!</b>";

?>
```

> **Atenção:** o `@` antes do `include` suprime a mensagem de Warning, então ela não aparece na tela. Para ver o Warning durante o teste, remova o `@`.

## 5. Regra de ouro do desenvolvedor

| Ambiente | `display_errors` | `error_reporting` | Motivo |
|---|---|---|---|
| Desenvolvimento (seu PC) | `1` | `E_ALL` | Achar e corrigir tudo rápido |
| Produção (servidor no ar) | `0` | `E_ALL` | Os erros vão para arquivos de log do servidor, protegendo a aplicação |