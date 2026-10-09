# Camada 2: Zend Engine (o seu "lexer/parser" do PHP)

**Foco:** entender como o PHP lê, compila e executa seu código. Esta camada responde ao seu objetivo de enxergar "como a máquina entende".

```
.php → LEXER (re2c) → tokens → PARSER (Bison, LALR) → AST → COMPILADOR → opcodes → ZEND VM
                                                                         ↑ OPcache guarda aqui
```

## 1. Pipeline de compilação
- [ ] **Lexer:** transforma texto em tokens (`T_OPEN_TAG`, `T_VARIABLE`, `T_STRING`, `T_ECHO`...)
- [ ] **Parser:** gramática, precedência, conflitos; gera a **AST** (explícita desde o PHP 7)
- [ ] **Compilador:** AST → **opcodes**
- [ ] **Zend VM:** executa opcodes em loop, com handlers e frames
- [ ] Diferença entre erro de **parse** (compilação) e erro de **runtime** (VM)
- [ ] Por que um erro de sintaxe impede o arquivo inteiro de rodar

## 2. Valores e memória
- [ ] **`zval`:** estrutura que guarda tipo e valor
- [ ] **Contagem de referências** e **copy-on-write** (por isso arrays "copiam" barato)
- [ ] **Coletor de ciclos** (GC): quando é necessário
- [ ] Gerenciador de memória do Zend, `memory_limit`
- [ ] Vazamentos em scripts longos (CLI, workers, filas)
- [ ] Strings internadas, arrays empacotados vs hash (noção)

## 3. Ciclo de vida
- [ ] **MINIT** (módulo inicia) → **RINIT** (requisição inicia) → execução → **RSHUTDOWN** → **MSHUTDOWN**
- [ ] **Share-nothing:** o estado morre ao fim de cada requisição
- [ ] Consequências: sem estado global entre requisições, conexão de banco recriada (salvo persistentes)
- [ ] Contraste com Node e servidores long-running (Swoole, RoadRunner, FrankenPHP)

## 4. OPcache e JIT
- [ ] O que o OPcache evita (lexer + parser + compilação a cada requisição)
- [ ] `opcache.enable`, `validate_timestamps`, `revalidate_freq`, `memory_consumption`
- [ ] **Invalidação no deploy** (por que "o código novo não apareceu")
- [ ] **Preloading**
- [ ] **JIT:** o que faz, quando ajuda (CPU-bound) e quando pouco muda (apps web com I/O)
- [ ] Verificar status: `opcache_get_status()`

## 5. Extensões e API interna
- [ ] Extensões em C: PDO, mbstring, curl, json, etc.
- [ ] `php -m`, `php -i`, `phpinfo()`
- [ ] Funções internas vs funções do usuário; por que as internas são rápidas
- [ ] (Avançado) como uma função nativa é registrada

## 6. Ferramentas para **ver** o pipeline
- [ ] `token_get_all()` e `PhpToken::tokenize()`
- [ ] **`nikic/php-parser`:** gerar, percorrer e modificar a AST (e imprimir de volta)
- [ ] Opcodes: `php -d opcache.opt_debug_level=0x10000 -d opcache.enable_cli=1 script.php` (confirme as flags na doc da sua versão), ou extensão VLD
- [ ] `phpdbg`, `php -r`, `php -l` (lint)
- [ ] (Opcional) ler no GitHub do PHP: `Zend/zend_language_scanner.l`, `Zend/zend_language_parser.y`, `Zend/zend_vm_def.h`

## Autoavaliação
1. Qual a diferença entre token e nó da AST?
2. Por que o OPcache acelera sem mudar o código?
3. O que significa "share-nothing" na prática?
4. Por que atribuir um array grande a outra variável não o copia de imediato?
5. Por que mudei um arquivo e a resposta continua antiga?

## Exercícios
- Tokenizar um script e imprimir os nomes dos tokens com `token_get_all`
- Usar `nikic/php-parser` para encontrar todas as chamadas de `var_dump` e removê-las
- Imprimir os opcodes de uma função simples e identificar `ADD`, `ASSIGN`, `RETURN`
- Escrever um **tokenizer e parser recursivo descendente** para uma mini-linguagem (em PHP)
- Medir um script com e sem OPcache (CLI com `opcache.enable_cli`)
- Observar uso de memória de um array de 1 milhão de itens vs generator
