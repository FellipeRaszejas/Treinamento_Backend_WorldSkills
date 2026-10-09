# Camada 8: Segurança

**Foco:** segurança desde o início, aplicada ao seu projeto. Em competição ela rende pontos; em produção evita desastres. **A segurança está no servidor; validação no front é só conveniência.**

## 1. Mentalidade
- [ ] Nunca confiar na entrada (GET, POST, headers, cookies, arquivos, JSON)
- [ ] Defesa em profundidade, menor privilégio
- [ ] Falhar de forma segura; não vazar detalhes em erros
- [ ] **OWASP Top 10** (versão atual) aplicado a PHP

## 2. Injeção
- [ ] **SQL Injection:** prepared statements sempre; whitelist para nomes de coluna/tabela/ordenação
- [ ] **Command injection:** `exec`, `shell_exec`, `system`, `escapeshellarg`; evitar quando possível
- [ ] LDAP/NoSQL/template injection (noção)
- [ ] **Remote Code Execution** via `eval`, `include` dinâmico, `unserialize`

## 3. Saída e XSS
- [ ] `htmlspecialchars($s, ENT_QUOTES, 'UTF-8')` conforme o contexto (HTML, atributo, JS, URL)
- [ ] Templates com escape automático (Twig/Blade)
- [ ] **CSP** e outros headers de segurança
- [ ] APIs JSON: `Content-Type` correto

## 4. CSRF e sessões
- [ ] **CSRF:** token por sessão/formulário, `SameSite`, verificar `Origin`
- [ ] **Session fixation/hijacking:** `session_regenerate_id` no login, `HttpOnly`, `Secure`
- [ ] Expiração, logout real, sessão em múltiplos servidores

## 5. Senhas e criptografia
- [ ] `password_hash` / `password_verify` / `password_needs_rehash` (bcrypt/argon2)
- [ ] **Nunca** MD5/SHA1 puro para senha; nunca texto puro
- [ ] `random_bytes`/`random_int` (não `rand`/`mt_rand`) para tokens
- [ ] `hash_equals` (comparação em tempo constante)
- [ ] Criptografia: libsodium, `openssl_*` (noção); TLS

## 6. Arquivos
- [ ] **Upload:** validar MIME real (`finfo`), extensão, tamanho, renomear, **salvar fora do web root**, nunca executar
- [ ] **Path traversal** (`../`), `basename`, `realpath`
- [ ] **LFI/RFI:** nunca `include $_GET['x']`
- [ ] Permissões de arquivos e diretórios

## 7. Controle de acesso
- [ ] **IDOR/BOLA:** checar dono do recurso
- [ ] Autorização em toda rota, nunca só no menu
- [ ] Mass assignment (campos que o usuário não deve definir)
- [ ] Enumeração de usuários, força bruta, rate limiting

## 8. Configuração e hardening
- [ ] Produção: `display_errors=Off`, `log_errors=On`, `expose_php=Off`
- [ ] `open_basedir`, `disable_functions` (avaliar), limites de upload/memória
- [ ] `.env` fora do web root e do Git; segredos fora do código
- [ ] HTTPS, HSTS, headers (`X-Content-Type-Options`, `Referrer-Policy`, `X-Frame-Options`/CSP `frame-ancestors`)
- [ ] Atualizar PHP e extensões (versões sem suporte)

## 9. Dependências e supply chain
- [ ] `composer audit`, lockfile, revisar pacotes novos
- [ ] Evitar pacotes abandonados

## 10. Auditoria e resposta
- [ ] Logs de segurança, alertas, monitoramento
- [ ] Plano de resposta (noção), divulgação responsável

## Autoavaliação
1. Por que `addslashes` e `mysql_real_escape_string` não substituem prepared statements?
2. Quando `htmlspecialchars` não basta?
3. Por que `unserialize` em dados do usuário é perigoso?
4. Como um upload de `.php` vira RCE e como evitar?
5. Diferença entre XSS refletido, armazenado e DOM-based?

## Exercícios
- Construir uma app vulnerável de propósito (SQLi, XSS, CSRF, upload, IDOR) e **explorá-la**
- Corrigir cada falha e escrever o teste que a pega
- Rodar OWASP ZAP ou similar na sua aplicação
- Configurar um `php.ini` de produção e headers de segurança no Nginx
- Revisar um código alheio procurando 10 problemas de segurança
