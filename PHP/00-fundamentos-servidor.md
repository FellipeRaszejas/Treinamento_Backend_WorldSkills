# Camada 0: Fundamentos do Servidor

**Foco:** entender o ambiente onde o PHP roda. Metade dos "bugs de PHP" são, na verdade, bugs de servidor, permissão ou HTTP.

## 1. Linux e terminal
- [ ] Navegação e arquivos: `cd`, `ls -la`, `cp`, `mv`, `rm`, `find`, `tree`
- [ ] Leitura e busca: `cat`, `less`, `head`, `tail -f`, `grep`, `sed`, `awk` (noções)
- [ ] **Permissões e donos:** `chmod`, `chown`, usuário do servidor (`www-data`), por que "403" e "Permission denied" acontecem
- [ ] Processos: `ps`, `top`, `kill`, serviços (`systemctl`)
- [ ] Pipes, redirecionamento, variáveis de ambiente, `PATH`
- [ ] Rede: `curl`, `ping`, `ss`/`netstat`, `ssh`, `scp`
- [ ] Logs: `/var/log`, logs do Nginx/Apache/PHP-FPM

## 2. HTTP em profundidade
- [ ] Estrutura de requisição e resposta (linha inicial, headers, corpo)
- [ ] Métodos (`GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `OPTIONS`), idempotência
- [ ] Status codes: 2xx, 3xx (301/302/304), 4xx (400/401/403/404/405/409/422/429), 5xx (500/502/503/504)
- [ ] Headers: `Content-Type`, `Content-Length`, `Authorization`, `Cookie`/`Set-Cookie`, `Cache-Control`, `ETag`, `Location`, `Origin`
- [ ] Corpos: `application/x-www-form-urlencoded`, `multipart/form-data`, `application/json`
- [ ] CORS e preflight (o que o servidor deve responder)
- [ ] HTTPS/TLS (noção), HTTP/2, proxies reversos, `X-Forwarded-*`
- [ ] Cookies: `HttpOnly`, `Secure`, `SameSite`, `Domain`, `Path`

## 3. Servidores web
- [ ] Nginx vs Apache (modelo de processos, configuração)
- [ ] `document root`, virtual hosts/server blocks
- [ ] **Nginx:** `location`, `try_files`, `fastcgi_pass`, `fastcgi_param`
- [ ] **Apache:** `.htaccess`, `mod_rewrite`, `AllowOverride`
- [ ] Servir estáticos vs repassar ao PHP
- [ ] Reescrita de URL para o front controller (`/qualquer/rota` → `index.php`)
- [ ] Servidor embutido: `php -S localhost:8000 -t public`

## 4. CGI, FastCGI e PHP-FPM
- [ ] Como o servidor entrega a requisição ao PHP (CGI → FastCGI)
- [ ] **PHP-FPM:** pool de workers, socket Unix vs TCP, `pm.max_children`
- [ ] **SAPIs:** CLI, FPM, mod_php, embutido; quando cada um é usado
- [ ] `php.ini`: `php --ini`, `phpinfo()`, diferença entre ini do CLI e do FPM
- [ ] Extensões: `php -m`, habilitar/desabilitar

## 5. SQL e rede (noções)
- [ ] Cliente/servidor de banco, portas, usuários e permissões
- [ ] DNS, portas, sockets, TCP básico, localhost vs 127.0.0.1 vs nome de container

## Autoavaliação
1. O que acontece entre digitar uma URL e o PHP executar `index.php`?
2. Por que um 502 não é erro de código PHP?
3. Qual a diferença entre `php.ini` do CLI e do FPM?
4. Para que serve `try_files` em uma aplicação com front controller?
5. Por que uma pasta com permissão errada gera 403 ou erro de escrita?

## Exercícios
- Instalar Nginx + PHP-FPM (ou Docker) e servir um `index.php` com `phpinfo()`
- Escrever o `location` que manda qualquer rota para `index.php`
- Forçar um 403 por permissão e corrigir
- Enviar requisições com `curl -v` (GET, POST JSON, POST form, upload) e ler os headers
- Derrubar o PHP-FPM de propósito e observar o 502
