# Camada 12: Integração Full-stack

**Foco:** back-end PHP e front-end React (Vite) funcionando juntos, em desenvolvimento e em produção.

## 1. Contrato de API
- [ ] OpenAPI como contrato único; gerar clientes/tipos (opcional)
- [ ] Formato de sucesso e de erro padronizado
- [ ] Códigos HTTP que o front sabe interpretar (401 → login, 422 → erros por campo)
- [ ] Datas, enums, dinheiro e paginação combinados entre os dois lados
- [ ] Versionamento e mudanças compatíveis

## 2. Desenvolvimento local
- [ ] Vite em `:5173`, PHP em `:8000` ou `:80`; **origens diferentes**
- [ ] **Opção A: proxy do Vite** (`server.proxy`), sem CORS no dev
- [ ] **Opção B: CORS** no PHP (headers e preflight `OPTIONS`)
- [ ] Cookies entre origens (`SameSite`, `credentials: 'include'`, `Access-Control-Allow-Credentials`)
- [ ] Variáveis de ambiente do front (`VITE_API_URL`; públicas!)

## 3. Autenticação ponta a ponta
- [ ] Cookie de sessão `HttpOnly` vs token em `Authorization`
- [ ] Login, logout, expiração, refresh
- [ ] Rotas protegidas no front **e** verificação no back
- [ ] CSRF quando se usa cookie

## 4. Estados da UI vs respostas da API
- [ ] Loading, sucesso, vazio, erro de rede, erro de validação, não autorizado
- [ ] Tratar `response.ok` e timeouts no front
- [ ] Mensagens de erro úteis do back

## 5. Docker Compose
- [ ] Serviços: `nginx`, `php-fpm`, `db`, `frontend` (Vite em dev)
- [ ] Redes e nomes de serviço (`db` em vez de `localhost`)
- [ ] Volumes, variáveis, `healthcheck`
- [ ] Seeds e migrations ao subir

## 6. Produção
- [ ] Build do front (`dist/`) servido pelo Nginx e a API em `/api`, **mesma origem**
- [ ] **SPA fallback:** rotas do React devolvem `index.html`; `/api` vai para o PHP
- [ ] `base` do Vite quando em subpasta
- [ ] Cache: assets com hash longos; `index.html` sem cache longo
- [ ] Variáveis embutidas no build do front (não são lidas em runtime)

## 7. Outras integrações
- [ ] Upload de arquivos (multipart) e progresso
- [ ] Tempo real: WebSocket/SSE
- [ ] SEO/SSR (quando o front precisa de HTML renderizado)
- [ ] Internacionalização compartilhada

## Autoavaliação
1. Por que o navegador bloqueia a chamada e como o proxy do Vite evita isso?
2. O que o PHP precisa responder ao `OPTIONS`?
3. Como o Nginx separa `/api` do restante?
4. Por que recarregar uma rota do React dá 404 em produção?
5. Cookie `HttpOnly` ou token no `localStorage`: trade-offs?

## Exercícios
- Projeto completo: React (Vite) + API PHP + MySQL, com login e CRUD
- Fazer funcionar de duas formas: proxy do Vite e CORS
- Subir tudo com `docker compose up` e simular produção com Nginx servindo `dist/` + `/api`
- Quebrar CORS, cookie e fallback de propósito e diagnosticar
