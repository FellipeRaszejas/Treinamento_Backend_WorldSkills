
# Encurtador de URLs Local em PHP

Este documento registra o processo de estudo e as tentativas feitas para construir um encurtador de URLs que roda localmente, incluindo os erros encontrados, o que cada um significa e as decisões tomadas ao longo do caminho.

## Sumário

1. [Objetivo](#1-objetivo)
2. [Linha do tempo do estudo](#2-linha-do-tempo-do-estudo)
   - [2.1 Entendendo `$_GET`](#21-entendendo-_get)
   - [2.2 Primeira tentativa: hard link](#22-primeira-tentativa-hard-link)
   - [2.3 Segunda tentativa: symlink e os erros](#23-segunda-tentativa-symlink-e-os-erros)
   - [2.4 Cabeçalhos HTTP com `header()`](#24-cabeçalhos-http-com-header)
   - [2.5 Lógica de extração com `strpos` e `substr`](#25-lógica-de-extração-com-strpos-e-substr)
   - [2.6 Geração do código: de `bin2hex` para `hash`](#26-geração-do-código-de-bin2hex-para-hash)
   - [2.7 Versão final e falta de formulário](#27-versão-final-e-falta-de-formulário)
3. [Código final](#3-código-final)
4. [Como executar](#4-como-executar)
5. [Pontos fortes do estudo](#5-pontos-fortes-do-estudo)
6. [Ajustes conceituais](#6-ajustes-conceituais)
7. [Próximos passos](#7-próximos-passos)
8. [Resumo](#8-resumo)

## 1. Objetivo

Construir um encurtador de URLs que receba uma URL digitada pelo usuário e devolva uma versão curta dela, rodando em `localhost`. Além do código, o objetivo é registrar o raciocínio de pesquisa e os caminhos que não funcionaram, para que o processo fique documentado.

## 2. Linha do tempo do estudo

### 2.1 Entendendo `$_GET`

A documentação oficial descreve `$_GET` como um array associativo com as variáveis passadas ao script pela URL, conhecidas como *query string*. Ele é preenchido sempre que a query string existe, independentemente do método HTTP.

Na prática, `$_GET` guarda os valores que aparecem depois do `?` na URL. Ele também recebe os dados digitados pelo usuário quando um formulário usa `method="GET"`, porque o navegador envia os campos do formulário justamente como query string.

Por isso, a primeira versão, `$link = $_GET['link'];`, estava errada. Ela lia um parâmetro chamado `link` na URL, e não o valor digitado pelo usuário. O nome da chave precisa ser o mesmo do campo do formulário (`name="url"`), e a chave correta é `$_GET['url']`.

### 2.2 Primeira tentativa: hard link

Ao pesquisar sobre "link" na documentação, apareceram os *hard links*. A descrição obtida foi a seguinte:

> Um hard link (ou link físico) é um apontamento direto para o inode, o registro físico de dados e metadados de um arquivo no disco. Quando você cria um hard link, o sistema operacional não faz uma cópia do conteúdo do arquivo, mas sim cria um novo nome ou caminho que aponta exatamente para a mesma posição no disco.

O entendimento inicial foi que o hard link cria um novo caminho para uma informação existente. Isso é verdade, mas o recurso só funciona dentro do mesmo sistema de arquivos e apenas para arquivos locais. Como o encurtador precisa associar um código a uma URL, e não a um arquivo do disco, essa solução não atende ao objetivo.

### 2.3 Segunda tentativa: symlink e os erros

A pesquisa seguinte levou às funções `symlink()` e `readlink()`, que criam e leem links simbólicos. Ao testar o exemplo da documentação, apareceram dois erros.

**Erro 1: falha ao criar o link**

```text
PHP Warning: symlink(): Permission denied in C:\Users\WebTecnologia\Desktop\Treinamento_Backend_WorldSkills\Desafios_Oficiais\Symlink.php on line 4
```

Como ler esse erro:

* `PHP Warning`: é um aviso grave. O PHP não parou o programa inteiro, mas informa que a tarefa daquela linha falhou.
* `symlink()`: mostra a função que falhou.
* `Permission denied`: é o motivo do erro. O PHP pediu ao Windows para criar o link simbólico, mas o sistema negou o pedido porque o usuário atual não tem permissão de Administrador nem o Modo de Desenvolvedor ativado.
* `in C:\Users\...\Symlink.php`: mostra o arquivo onde o problema ocorreu.
* `on line 4`: aponta a linha exata do código.

**Erro 2: falha ao ler o link (efeito dominó)**

```text
PHP Warning: readlink(): readlink failed to read the symbolic link (uploads), error 2 in C:\Users\WebTecnologia\Desktop\Treinamento_Backend_WorldSkills\Desafios_Oficiais\Symlink.php on line 6
```

Como ler esse erro:

* `readlink()`: o problema agora está na função que lê o destino de um link simbólico.
* `failed to read the symbolic link (uploads)`: a função tentou abrir o link chamado `uploads`, mas ele não existe. Isso aconteceu porque o Erro 1 impediu a criação do link.
* `error 2`: código de erro do Windows para "O sistema não pode encontrar o arquivo especificado".
* `on line 6`: indica que a segunda falha ocorreu na linha 6 do mesmo arquivo.

Esses dois erros mostram uma relação de causa e efeito: o primeiro impediu a criação do link, e o segundo apenas reclamou da ausência dele. Por isso, sempre se deve corrigir o primeiro erro da lista.

Além disso, `symlink()` e `readlink()` servem exclusivamente para arquivos e pastas locais do sistema operacional. Passar uma URL como `https://google.com` para essas funções faz o PHP procurar uma pasta chamada `https:` no computador, o que resulta em erro. Assim, essa abordagem também não atende ao objetivo.

### 2.4 Cabeçalhos HTTP com `header()`

Ao buscar na documentação, percebi que a URL chega ao servidor pela requisição, e não pelo cabeçalho de resposta. Para enviar informações de volta ao navegador, a função adequada é `header()`. Duas regras importantes da documentação:

* o `header()` precisa ser chamado antes de qualquer saída ser enviada ao navegador, incluindo tags HTML e espaços em branco;
* ele pode substituir um cabeçalho anterior do mesmo tipo ou adicionar um segundo cabeçalho do mesmo tipo, dependendo do parâmetro `replace`.

Exemplo de envio de código de erro HTTP:

```php
<?php
// This example illustrates the "HTTP/" special case
// Better alternatives in typical use cases include:
// 1. header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
//    (to override http status messages for clients that are still using HTTP/1.0)
// 2. http_response_code(404); (to use the default message)
header("HTTP/1.1 404 Not Found");
?>
```

Exemplo de redirecionamento:

```php
<?php
header("Location: http://www.example.com/"); /* Redirect browser */

/* Make sure that code below does not get executed when we redirect. */
exit;
?>
```

Como esse exemplo funciona:

* `header("Location: ...")` informa ao navegador que ele deve ir para outra URL. O navegador recebe uma resposta de redirecionamento e faz uma nova requisição para o endereço indicado.
* `exit` interrompe o script. Sem ele, o PHP continuaria executando o restante do arquivo, o que é indesejado quando o objetivo é redirecionar, porque o código seguinte não deve rodar.

Esse mecanismo é a peça que falta para o encurtador: quando alguém acessar um link curto, o script deve descobrir a URL original e redirecionar o navegador para ela.

### 2.5 Lógica de extração com `strpos` e `substr`

Em um teste, ficou claro que a lógica de funcionamento de um encurtador precisa ser mapeada antes de escrever o código. Um encurtador precisa saber de qual parte da URL extrair o código, e a partir de qual ponto. A ideia inicial era escrever a partir do primeiro `/` da URL.

Para isso, duas funções de string foram estudadas:

* `strpos(string $haystack, string $needle, int $offset = 0): int|false`: encontra a posição da primeira ocorrência de uma substring dentro de outra. O primeiro parâmetro é a string onde a busca acontece, o segundo é o texto procurado, e o terceiro define a partir de qual posição a busca começa.
* `substr()`: retorna a parte da string definida pela posição inicial e pelo comprimento.

Na versão final, essa lógica foi descartada. Como a URL digitada já chega inteira em `$_GET['url']`, não há necessidade de localizar um ponto específico dentro dela. Basta trabalhar diretamente com o valor recebido.

### 2.6 Geração do código: de `bin2hex` para `hash`

A IA sugeriu `bin2hex`, que converte dados binários em hexadecimal, combinado com `random_bytes`, que gera uma quantidade definida de bytes aleatórios.

O problema é que essa combinação gera uma string longa, o que não faz sentido para um encurtador, que deve gerar textos menores do que a URL original. Além disso, `random_bytes` controla a quantidade de bytes, mas não o tamanho final do texto gerado depois da conversão para hexadecimal. São duas regras diferentes: converter dados binários aleatórios em hexadecimal e limitar o tamanho do código final.

Por isso, a solução foi trocada para a função `hash()`, aplicada à URL digitada:

```php
$NovoPosBarra = substr(hash('sha256', $URLdoUsuario), 0, 6);
```

O que acontece nessa linha:

* `hash('sha256', ...)` gera uma sequência de 64 caracteres hexadecimais (0 a 9 e a até f) a partir da URL.
* `substr(..., 0, 6)` mantém apenas os 6 primeiros caracteres e descarta o restante.

**Risco de colisão:** um hash completo de 64 caracteres praticamente nunca se repete. Mas, ao usar apenas 6 caracteres hexadecimais, o número de combinações possíveis cai para 16.777.216 (16⁶).

**Paradoxo do aniversário:** com cerca de 4.000 a 5.000 links salvos, a chance de duas URLs diferentes começarem com os mesmos 6 caracteres passa de 50%. Para um protótipo de estudo, o corte funciona bem. Para um encurtador real, seria necessário usar outra estratégia (veja a seção de ajustes).

### 2.7 Versão final e falta de formulário

A primeira versão funcional tinha dois problemas apontados pela IA:

* Ao abrir a página pela primeira vez, `$_GET['url']` ainda não existe. Isso gera o aviso `Undefined array key "url"`. A solução é verificar com `isset()` antes de usar o valor.
* Apenas usar `echo "Digite..."` não cria uma caixa de texto. Faltava o HTML do formulário.

A versão final corrige os dois pontos e acrescenta validação com `filter_var`, que confere se a URL digitada é válida antes de gerar o código curto.

## 3. Código final

```php
<?php
//Ideia: Usuário digita uma url e o sistema encurta a url.
//Por lógica guardar o valor do link da url em uma variavel, ao pesquisar descobri que se utiliza o $_GET para capturar o valor digita pelo usuário

//ERRO: Verificação se foi enviado URL
if (isset($_GET['url'])) {

    $URLdoUsuario = $_GET['url'];

    // Verifica se a URL digitada é válida
    if (filter_var($URLdoUsuario, FILTER_VALIDATE_URL)) {

        //receber url do sistema
        $DominioDoSistema = "http://localhost:8000/";
        //22 para receber local host, e deve receber alteração caso eu tenha um dominio publicado online, um encurtador real

        $NovoPosBarra = substr(hash('sha256', $URLdoUsuario), 0, 6);

        $NewUrl = ($DominioDoSistema . $NovoPosBarra);

        echo "Sua url encurtada é: " . htmlspecialchars($NewUrl);

    } else {
        echo "Digite uma URL válida!";
    }
}
?>

<form method="GET">
    Digite a url que deseja encurtar:
    <input type="url" name="url" placeholder="https://example.com" required>
    <button type="submit">Encurtar</button>
</form>
```

## 4. Como executar

No PowerShell, dentro da pasta do arquivo, rode:

```powershell
php -S localhost:8000
```

Depois, acesse `http://localhost:8000` no navegador.

## 5. Pontos fortes do estudo

* **Leitura de erros:** a análise dos erros de `symlink()` e `readlink()` identificou função, arquivo, linha e causa, o que é a base da depuração.
* **Escolha do hash e percepção de colisão:** a discussão sobre o paradoxo do aniversário e o risco de cortar o SHA-256 em 6 caracteres mostra preocupação com integridade e escalabilidade.
* **Código final:** usa `isset` para evitar o aviso de chave inexistente, `filter_var` para validar a URL e `htmlspecialchars` para evitar XSS na saída.
* **Processo de pesquisa:** cada tentativa foi documentada, incluindo o motivo de ter sido descartada.

## 6. Ajustes conceituais

**`$_GET` e `header()` não são a mesma coisa.** Uma nota do estudo dizia que a URL vem do cabeçalho e, por isso, deveria ser usada a função `header()`. A correção é:

* `$_GET` coleta os parâmetros que o navegador envia na URL, depois do `?` (a query string, como `?url=valor`). Serve para receber dados.
* `header()` envia instruções do servidor de volta ao navegador, como um redirecionamento (`Location:`) ou um código de status (`404`). Não serve para capturar o que o usuário digitou.

**Substituição de cabeçalhos.** O parâmetro `replace` de `header()` define o comportamento quando já existe um cabeçalho do mesmo tipo. Com `true` (padrão), o novo substitui o anterior. Com `false`, um segundo cabeçalho do mesmo tipo é adicionado, o que é útil em casos como múltiplos `Set-Cookie`.

**Hash truncado versus Base62.** Cortar o hash SHA-256 é uma boa solução para um estudo, mas a estratégia comum em encurtadores reais é outra. Em vez de um hash, usa-se um ID numérico (geralmente vindo de um contador auto-incremento do banco de dados) convertido para Base62, que usa os caracteres `0-9`, `a-z` e `A-Z`. Esse método não tem colisão, porque cada ID é único.

Um exemplo com essa ordem de caracteres: o ID 5000 corresponde a `1iE` em Base62, já que 5000 = 1 × 62² + 18 × 62 + 40. A IA sugeriu o valor `8W`, mas esse valor não corresponde ao ID 5000.

**Hard link e symlink.** Ambos criam caminhos para arquivos locais. A diferença é que o hard link aponta direto para o mesmo registro do disco, e só funciona dentro do mesmo sistema de arquivos. O symlink guarda um caminho e pode apontar para outro local ou disco. Nenhum dos dois serve para encurtar URLs, porque ambos trabalham com arquivos, e não com texto.

## 7. Próximos passos

O código atual gera o link curto, mas não o salva em lugar nenhum. Se o usuário acessar o link gerado, o servidor responde com erro 404, porque não sabe qual URL original aquele código representa.

O próximo passo é guardar o par `[código curto => URL original]` em um banco de dados, como SQLite ou MySQL, ou em um arquivo JSON. Quando o link curto for acessado, o script:

1. lê o código da URL;
2. busca a URL original no armazenamento;
3. redireciona o navegador com `header("Location: ...")` e `exit`, como visto na seção 2.4.

**Ciclo de vida da requisição.** O PHP roda no servidor. Quando o usuário digita a URL e clica em "Encurtar", o navegador faz uma requisição HTTP GET. O PHP lê `$_GET['url']`, gera o código e devolve o HTML com a resposta. Entender esse ciclo de envio e resposta é a base do desenvolvimento backend.

## 8. Resumo

| Etapa | Ferramenta | Resultado |
|---|---|---|
| Receber a URL | `$_GET['url']` com formulário `GET` | Valor digitado pelo usuário |
| Caminho com hard link | `link()` | Descartado: só funciona com arquivos locais |
| Caminho com symlink | `symlink()` e `readlink()` | Descartado: erros de permissão e só funciona com caminhos locais |
| Enviar erro ou redirecionamento | `header()` com `exit` | Parte necessária para o redirecionamento final |
| Extrair parte da URL | `strpos()` e `substr()` | Descartado: a URL inteira já está disponível |
| Gerar código curto | `bin2hex` com `random_bytes` | Descartado: gera texto longo |
| Gerar código curto | `hash('sha256')` cortado em 6 caracteres | Adotado para o estudo, com risco de colisão |
| Validar entrada | `filter_var` com `FILTER_VALIDATE_URL` | Garante URL válida |
| Proteger a saída | `htmlspecialchars` | Evita XSS |
| Salvar o link | Banco de dados ou JSON | Próximo passo, ainda não implementado |