# Camada 15: Como o Computador Executa (o que existe "por baixo" do PHP)

**Foco:** entender o que a máquina realmente faz quando seu código roda. A Zend Engine (camada 2) explica o PHP; esta camada explica **o que está embaixo dele**: dados em bytes, memória, processos, arquivos, rede. É o que permite depurar "como o computador" e não "como o programador".

> Nível: básico a avançado. Faça na ordem: representação de dados → memória → processos → arquivos/rede → observar com ferramentas.

## 1. Representação de dados (básico)
- [ ] **Bits e bytes**, binário, hexadecimal; por que `0xFF` é 255
- [ ] **Inteiros:** tamanho fixo (64 bits no PHP moderno), `PHP_INT_MAX`, **overflow vira float** no PHP
- [ ] **Ponto flutuante (IEEE 754):** por que `0.1 + 0.2 !== 0.3`; erro de arredondamento; **nunca use float para dinheiro** (use inteiros em centavos ou `bcmath`)
- [ ] **Strings são sequências de bytes** (binary-safe); `strlen` conta bytes, `mb_strlen` conta caracteres
- [ ] **Codificação:** ASCII, **UTF-8** (1 a 4 bytes por caractere), BOM, por que aparece `Ã§`; `mbstring`
- [ ] **Ordem de bytes (endianness)** e `pack()/unpack()` (noção)
- [ ] **Booleanos e `null`**, conversões implícitas (por que `"0"` é falsy)
- [ ] **Datas:** timestamp Unix (segundos desde 1970 UTC), timezone, horário de verão, ano 2038 (noção)
- [ ] **Hash vs criptografia vs codificação:** MD5/SHA, bcrypt/argon2, base64 (não é segurança)

## 2. Memória (intermediário)
- [ ] **Pilha (stack) e heap:** chamada de função, variáveis locais, objetos
- [ ] **Ponteiros e referências** (conceito); como o PHP usa `zval` e **contagem de referências**
- [ ] **Copy-on-write:** por que atribuir um array grande não o copia na hora
- [ ] **Arrays do PHP = tabelas hash ordenadas** (custo de acesso, de inserção, uso de memória)
- [ ] **Coleta de lixo:** refcount + coletor de ciclos
- [ ] **Vazamento e estouro:** `memory_limit`, `memory_get_usage()`, por que scripts longos crescem
- [ ] **Cache de CPU e localidade** (noção): por que estruturas compactas são mais rápidas

## 3. Sistema operacional e processos (intermediário)
- [ ] **Processo vs thread**; PID; processo pai/filho; sinais (`SIGTERM`, `SIGKILL`)
- [ ] **Modelo do PHP-FPM:** um **processo por requisição simultânea**, workers em pool (por isso `pm.max_children` importa e por que o PHP é "share-nothing")
- [ ] **CLI vs FPM:** mesmo interpretador, ambientes e `php.ini` diferentes
- [ ] **Usuário e permissões:** quem roda o processo (`www-data`), por que "Permission denied" acontece
- [ ] **Variáveis de ambiente** e como o processo as herda
- [ ] **Limites do SO:** memória, arquivos abertos (`ulimit -n`), tempo (`max_execution_time` em Linux não conta o tempo gasto em chamadas de sistema, como espera de banco ou `sleep`)
- [ ] Bloqueio de I/O vs não bloqueante (noção): por que uma consulta lenta ocupa um worker

## 4. Arquivos e rede (intermediário a avançado)
- [ ] **Descritor de arquivo (file descriptor)**; `fopen`, streams, stream wrappers (`php://input`, `file://`, `http://`)
- [ ] **Sistema de arquivos:** inode, permissões, links simbólicos (por que `storage:link`), bloqueio de arquivo (`flock`) e condições de corrida
- [ ] **Sockets e TCP:** conexão, porta, handshake, *keep-alive*; `localhost` vs `127.0.0.1` vs nome de container
- [ ] **Como uma requisição HTTP vira bytes:** texto na rede, linha de requisição, headers, corpo
- [ ] **Unix socket vs TCP** entre Nginx e FPM
- [ ] **DNS** (resolução de nomes), **TLS** (noção)
- [ ] **Conexão com banco:** é um socket; abrir/fechar custa; pool

## 5. Execução e desempenho (avançado)
- [ ] **CPU executa instruções**; interpretador vs compilador vs JIT (conexão com camada 2)
- [ ] **Complexidade (Big-O)** no nível prático: loop dentro de loop, N+1, busca linear vs hash
- [ ] **Concorrência vs paralelismo**; condições de corrida; **atomicidade**
- [ ] **Latência vs vazão**; onde o tempo vai (CPU, disco, rede, banco)
- [ ] **Cache em camadas:** CPU, OPcache, aplicação, banco, CDN

## 6. Ver o que o computador faz (prática)
- [ ] `ps`, `top`/`htop`, `/proc/<pid>` (memória, arquivos abertos), `lsof`, `ss -tlnp`
- [ ] **`strace -f php script.php`** (Linux): lista as chamadas de sistema reais (abrir arquivo, ler, escrever, rede). Em Docker pode precisar de permissão `SYS_PTRACE`
- [ ] `curl -v` e `nc` (netcat) para falar HTTP "na mão"; Wireshark/`tcpdump` (noção)
- [ ] `php -r 'var_dump(0.1+0.2);'`, `memory_get_peak_usage()`, `xdebug`/profilers
- [ ] `hexdump -C`/`xxd` para ver bytes de arquivos; `file`, `iconv`

## Autoavaliação
1. Por que `0.1 + 0.2 == 0.3` é falso e como guardar dinheiro corretamente?
2. Quantos bytes tem `"ação"` em UTF-8 e por que `strlen` não retorna 4?
3. Por que um array grande atribuído a outra variável não consome o dobro de memória?
4. Por que mais usuários simultâneos pedem mais memória no PHP-FPM?
5. O que o computador faz entre eu chamar `file_get_contents()` e receber a string?
6. Por que duas requisições gravando o mesmo arquivo podem corromper o conteúdo?

## Exercícios
- Imprimir `PHP_INT_MAX + 1` e explicar; fazer cálculos de dinheiro com centavos inteiros
- Gravar `"ação"` em um arquivo, abrir com `xxd` e identificar cada byte
- Rodar `strace -f` em um script que lê um arquivo e consulta o banco; identificar `openat`, `read`, `connect`, `sendto`
- Escrever um servidor HTTP mínimo com `stream_socket_server` e acessá-lo com `curl -v`
- Provocar uma condição de corrida com dois processos gravando e consertar com `flock`
- Medir o uso de memória de 1 milhão de itens em array, em generator e em `SplFixedArray`
