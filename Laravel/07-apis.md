# Camada 7: APIs

**Foco:** construir APIs REST consistentes e seguras no Laravel, consumíveis por React/Vite ou qualquer cliente.

## 1. Estrutura
- [ ] `php artisan install:api` (cria `routes/api.php`, instala Sanctum; confirme na versão que usa)
- [ ] Prefixo `/api`, grupo stateless, `apiResource`
- [ ] Controllers de API enxutos; Services/Actions para regras de negócio
- [ ] Versionamento (`/api/v1`) e organização por versão

## 2. Design REST
- [ ] Recursos, verbos, **status codes corretos** (200, 201, 204, 400, 401, 403, 404, 409, 422, 429, 500)
- [ ] Idempotência (`PUT/DELETE`), `POST` para criação
- [ ] Filtros, ordenação, busca, **paginação** (`paginate` vs `cursorPaginate`)
- [ ] Formato de resposta consistente (envelope ou direto) e de erro padronizado

## 3. API Resources
- [ ] `JsonResource` e `ResourceCollection`; `toArray`, `whenLoaded`, `when`, `additional`
- [ ] Não vazar campos do banco; formatar datas (ISO 8601), enums, dinheiro
- [ ] Meta e links de paginação
- [ ] Relacionamentos condicionais (evita N+1 com `with()`)

## 4. Validação e erros
- [ ] Form Requests, **422 JSON** com erros por campo
- [ ] `withExceptions` para renderizar erros JSON (`shouldRenderJsonWhen`, `render`)
- [ ] `ModelNotFoundException` → 404, `AuthorizationException` → 403, `AuthenticationException` → 401
- [ ] Cabeçalho `Accept: application/json` e por que importa

## 5. Autenticação e proteção
- [ ] Sanctum (token ou SPA), abilities
- [ ] **Policies** em recursos, evitar IDOR
- [ ] **CORS:** `config/cors.php` (origens, métodos, credenciais)
- [ ] **Rate limiting** por usuário/IP, `throttle:api`
- [ ] Limite de payload e timeouts

## 6. Documentação e ferramentas
- [ ] **OpenAPI/Swagger** (ex.: pacotes como Scramble ou L5-Swagger; confirme as opções atuais)
- [ ] Postman/Insomnia, testes de contrato
- [ ] Uploads/downloads, streaming, `Http::` para consumir outras APIs

## 7. Padrões úteis
- [ ] DTOs, Actions, Services
- [ ] Idempotency keys (noção), webhooks (assinatura e verificação)
- [ ] Filas para tarefas lentas e resposta `202 Accepted`

## Autoavaliação
1. Quando uma validação retorna 422 e quando 400?
2. Por que enviar `Accept: application/json` muda o comportamento de erros?
3. Qual a vantagem de API Resources sobre `return $model`?
4. Como o Laravel limita requisições por usuário?
5. Como evitar N+1 em coleções de resources?

## Exercícios
- API completa (CRUD + auth + paginação + filtros) com Resources e testes
- Padronizar todos os erros em JSON, inclusive 404 e 500
- Documentar com OpenAPI e comparar com a implementação
- Configurar CORS para um React em outra origem
- Adicionar rate limit por usuário autenticado
