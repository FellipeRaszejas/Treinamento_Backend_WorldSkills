# Camada 10: Segurança

**Foco:** saber o que o Laravel protege sozinho e o que **continua sendo responsabilidade sua**. A segurança está no servidor.

## 1. O que o Laravel faz por você
- [ ] **SQL injection:** Eloquent/Query Builder usam prepared statements (bindings)
- [ ] **XSS:** `{{ }}` do Blade escapa a saída
- [ ] **CSRF:** `@csrf`, middleware de verificação, cookie `XSRF-TOKEN`
- [ ] **Hashing** de senha (bcrypt/argon2) e **criptografia** (`APP_KEY`, `Crypt`)
- [ ] Cookies **criptografados/assinados**, sessão com regeneração
- [ ] Proteções de arquivos: `public/` como único diretório exposto

## 2. O que continua com você
- [ ] **`DB::raw`, `whereRaw`, `orderByRaw`**: nunca concatenar entrada; usar bindings
- [ ] **`{!! !!}` e `@php`**: só com conteúdo confiável/sanitizado
- [ ] **Mass assignment:** `$fillable`, nunca `create($request->all())` sem proteção; preferir `validated()`
- [ ] **Autorização:** policies/gates em toda rota; **IDOR/BOLA**
- [ ] **Validação** de toda entrada; limites de tamanho
- [ ] **Uploads:** validar MIME real, extensão, tamanho; nome aleatório; disk privado; nunca executar
- [ ] **Redirecionamentos abertos:** validar `redirect()->to($input)`
- [ ] SSRF ao fazer requisições com URL do usuário

## 3. Autenticação e sessões
- [ ] Rate limiting de login, mensagens genéricas, 2FA
- [ ] Cookies `Secure`, `HttpOnly`, `SameSite`; `SESSION_*`
- [ ] Sanctum SPA (CSRF + cookie) vs token (guarda segura do token no cliente)
- [ ] Reset de senha seguro, verificação de e-mail

## 4. Configuração e segredos
- [ ] **`APP_DEBUG=false` em produção** (debug expõe `.env`, stack traces, configurações)
- [ ] `APP_KEY` secreta e estável (muda = invalida sessões e dados criptografados)
- [ ] `.env` fora do Git e fora do web root; segredos em variáveis do ambiente
- [ ] Permissões de `storage/` e `bootstrap/cache` (não `777`)
- [ ] Remover rotas e pacotes de debug (Telescope, Debugbar) em produção ou protegê-los

## 5. Rede e headers
- [ ] **CORS** restritivo (`config/cors.php`)
- [ ] HTTPS, HSTS, `TrustProxies`/`trustProxies`, URLs corretas atrás de proxy
- [ ] Headers de segurança (CSP, `X-Content-Type-Options`, `Referrer-Policy`)
- [ ] Rate limiting em rotas sensíveis

## 6. Dependências
- [ ] `composer audit`, `npm audit`, atualização de versões do Laravel e PHP (suporte de segurança por versão)
- [ ] Revisar pacotes, evitar abandonados, lockfile no repositório

## 7. Auditoria
- [ ] Logs de segurança, alertas, monitoramento
- [ ] Soft delete e trilha de auditoria quando necessário

## Autoavaliação
1. Por que `whereRaw("name = '$name'")` é perigoso e como corrigir?
2. Por que `Model::create($request->all())` pode permitir virar admin?
3. O que expõe `APP_DEBUG=true` em produção?
4. Como o Laravel valida o token CSRF?
5. Por que verificar `$this->authorize()` no controller e não só esconder o botão?

## Exercícios
- Criar uma rota vulnerável de propósito (SQLi com `whereRaw`, XSS com `{!! !!}`, mass assignment, IDOR, upload) e **explorá-la**
- Corrigir cada falha e escrever o teste que a pega
- Ativar `APP_DEBUG=true` num ambiente de teste e ver o que vaza
- Rodar uma varredura (ex.: OWASP ZAP) na aplicação
- Revisar um projeto alheio procurando 10 falhas
