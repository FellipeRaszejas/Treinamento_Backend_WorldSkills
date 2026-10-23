# O Caminho de uma Requisição: Do Clique à Tela

Este guia acompanha o que acontece desde o momento em que o usuário clica em um botão no navegador até a página aparecer na tela, passando pelo cliente, pela internet, pelo servidor (Apache e PHP) e pelo banco de dados.

## Sumário

1. [Visão geral](#1-visão-geral)
2. [O Caminho Passo a Passo](#2-o-caminho-passo-a-passo)
   - [Passo 1: O Cliente](#passo-1-o-cliente)
   - [Passo 2: A Internet (Nuvem)](#passo-2-a-internet-nuvem)
   - [Passo 3: O Servidor, o Apache e o PHP](#passo-3-o-servidor-o-apache-e-o-php)
   - [Passo 4: O Banco de Dados](#passo-4-o-banco-de-dados)
   - [Passo 5: O Retorno](#passo-5-o-retorno)
3. [As Quatro Camadas da Arquitetura Web](#3-as-quatro-camadas-da-arquitetura-web)

---

## 1. Visão geral

**Conceito:** toda página web é fruto de uma conversa entre duas pontas. O **cliente** faz um pedido (*request*), o **servidor** processa e devolve uma resposta (*response*).

**No dia a dia:** é como pedir comida em um restaurante. Você (cliente) faz o pedido, o garçom (internet) leva até a cozinha, a cozinha (servidor com PHP) prepara o prato seguindo as regras da casa, busca os ingredientes na despensa (banco de dados) e o garçom traz o prato pronto até a sua mesa.

| Restaurante | Arquitetura web |
|---|---|
| Você, na mesa | Cliente (navegador ou app) |
| Garçom | Internet / Nuvem |
| Cozinha e regras da casa | Servidor (Apache + PHP) e regras de negócio |
| Despensa | Banco de dados |
| Prato pronto | Página HTML ou resposta JSON |

![Esquema do fluxo de uma requisição: o cliente (notebook e celular, circulado em vermelho) envia um Request pela internet/nuvem até o servidor, onde o Apache aciona o PHP; o PHP faz uma Query ao banco de dados, recebe os dados brutos (Return) e devolve a Response ao cliente](imagens/fluxo-requisicao-cliente-servidor-banco.jpg)

*Esquema do caminho de uma requisição entre cliente, internet, servidor (Apache e PHP) e banco de dados.*

O mesmo caminho, em linha do tempo:

| 💻 Cliente | → | ☁️ Internet | → | 🪶 Apache | → | 🐘 PHP | → | 🗄️ Banco de dados | → | 🐘 PHP filtra | → | 💻 Cliente |
|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| clica em "Cursos" | | viaja a requisição | | recebe o pedido | | aplica as regras | | devolve os dados | | monta a resposta | | exibe na tela |

---

## 2. O Caminho Passo a Passo

O exemplo usa o **PHPTube**: o usuário está navegando e clica em "Cursos".

### Passo 1: O Cliente

**Conceito:** o cliente (*frontend*, navegador ou app) é o ponto de partida. Na imagem, é a parte marcada de vermelho.

- O usuário está no notebook ou no celular, navegando no PHPTube, e clica em "Cursos".
- O navegador envia uma **requisição** (mensagem) pela internet até o endereço do servidor.

### Passo 2: A Internet (Nuvem)

**Conceito:** a internet é o meio de transporte, o "trânsito de dados".

- Antes de sair, o nome do site é traduzido em um endereço IP pelo **DNS**.
- A mensagem viaja pela rede, passando por roteadores e cabos, até bater na porta do servidor web onde a aplicação está hospedada.

### Passo 3: O Servidor, o Apache e o PHP

**Conceito:** o servidor é o motor de processamento e das regras de negócio.

- O servidor recebe o pedido.
- O **Apache** (servidor web) intercepta a requisição HTTP e aciona o interpretador **PHP** para ler o código fonte da aplicação.
- É aqui que entram as **regras de negócio**: o código PHP processa o que o usuário quer fazer, valida se ele está autenticado, verifica quais permissões ele tem e decide o que deve ser buscado.

### Passo 4: O Banco de Dados

**Conceito:** o banco de dados é a camada de **persistência**, onde as informações ficam guardadas de forma permanente.

- O PHP faz uma consulta (*query* SQL) ao banco de dados.
- O banco devolve os dados em estado **bruto** (*raw data*), ou seja, sem formatação nem regras aplicadas.
- A regra de negócio, rodando no servidor PHP, organiza esses dados. Exemplo: dos cursos existentes, exibir exatamente 10 vídeos por página.

Exemplo em PHP de uma consulta que já pede só os 10 cursos da página (a conexão `$pdo` é considerada já criada):

```php
<?php
$porPagina = 10;
$pagina = 1;
$inicio = ($pagina - 1) * $porPagina;

$sql = "SELECT id, titulo FROM cursos ORDER BY titulo LIMIT :limite OFFSET :inicio";
$consulta = $pdo->prepare($sql);
$consulta->bindValue(':limite', $porPagina, PDO::PARAM_INT);
$consulta->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$consulta->execute();

$cursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
```

- `$porPagina` e `$pagina`: definem o tamanho da página e qual página foi pedida.
- `LIMIT` e `OFFSET`: pedem ao banco apenas os 10 registros da página, em vez de trazer a tabela inteira.
- `prepare` e `bindValue`: montam a consulta de forma segura, sem colar valores direto no texto SQL.
- `fetchAll`: devolve os resultados como uma lista de arrays, pronta para o PHP trabalhar.

### Passo 5: O Retorno

- O PHP monta a página **HTML** (ou uma resposta **JSON**) com os 10 cursos filtrados.
- A resposta volta pela internet até o navegador do cliente, que a exibe na tela.

---

## 3. As Quatro Camadas da Arquitetura Web

A mesma jornada vista por camadas, seguindo o esquema da imagem:

| Camada | Onde acontece | Papel |
|---|---|---|
| **1. Cliente (Frontend)** | No dispositivo do usuário (celular ou notebook circulado em vermelho) | Interface visual onde o usuário interage (botões, menus, cliques). O cliente apenas envia o pedido (requisição HTTP) e aguarda a resposta para desenhar o resultado na tela |
| **2. Trânsito (Internet / Nuvem)** | No meio da infraestrutura | Atua como o correio digital: o pedido viaja pela rede, por protocolos de comunicação, até encontrar o endereço IP do servidor correto |
| **3. Servidor e Processamento (Backend)** | No servidor físico ou em nuvem, onde residem o Apache e o PHP | O Apache recebe o tráfego e entrega o script ao interpretador PHP. É aqui que moram as regras de negócio: o código valida se o usuário tem permissão, processa o pedido e decide exatamente o que deve ser buscado |
| **4. Persistência (Banco de Dados)** | No sistema gerenciador de banco de dados (ícone superior direito) | Guarda de forma permanente todas as informações (cursos, usuários, vídeos). O PHP faz uma consulta, o banco devolve os dados brutos e o servidor aplica o filtro lógico (por exemplo, limitar a exibição a 10 itens por página) antes de devolver a resposta final ao cliente |