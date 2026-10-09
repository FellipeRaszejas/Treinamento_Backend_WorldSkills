# Camada 7: APIs REST e Autenticação

**Foco:** projetar e implementar APIs consistentes, seguras e documentadas, que o front-end consegue consumir sem surpresas.

## 1. Design REST
- [ ] Recursos e URLs (`/users/42/orders`), substantivos, plural
- [ ] Verbos corretos e **idempotência** (`PUT/DELETE` idempotentes, `POST` não)
- [ ] **Status codes** corretos: 200, 201, 204, 400, 401, 403, 404, 409, 422, 429, 500
- [ ] Paginação (offset vs cursor), filtros, ordenação, busca
- [ ] Versionamento (`/v1`, header)
- [ ] HATEOAS e níveis de maturidade de Richardson (noção)

## 2. JSON e contratos
- [ ] `json_encode/decode`, flags, `JSON_THROW_ON_ERROR`
- [ ] Formato de resposta consistente (envelope ou direto)
- [ ] **Formato padronizado de erro** (ex.: Problem Details, RFC 9457)
- [ ] Datas (ISO 8601), dinheiro, enums, `null` vs ausente
- [ ] Resources/Transformers para não vazar campos do banco

## 3. Validação
- [ ] Validar tipo, tamanho, formato, regras de negócio
- [ ] Erros por campo (422) para o front exibir
- [ ] DTOs e Value Objects, bibliotecas (Respect/Validation, Symfony Validator)
- [ ] Sanitizar vs validar vs escapar (são coisas diferentes)

## 4. Autenticação
- [ ] **Sessão (cookie)** vs **token**; vantagens e riscos de cada
- [ ] **JWT:** estrutura (header.payload.signature), assinatura, expiração, `HS256` vs `RS256`, por que não guardar segredos no payload
- [ ] Refresh tokens, revogação, logout
- [ ] Hash de senha (`password_hash`), recuperação de senha segura
- [ ] OAuth2/OpenID Connect (noção), API keys
- [ ] 2FA (noção)

## 5. Autorização
- [ ] Diferença entre autenticar e autorizar
- [ ] RBAC, policies, ownership (evitar **IDOR**)
- [ ] Verificar permissão **no servidor, em toda rota**

## 6. CORS, limites e proteção
- [ ] Headers `Access-Control-*`, preflight `OPTIONS`, credenciais
- [ ] Rate limiting/throttling
- [ ] Limite de tamanho de payload, timeouts
- [ ] Idempotency keys (noção)

## 7. Documentação e ferramentas
- [ ] **OpenAPI/Swagger**, geração de documentação e clientes
- [ ] Testar com curl, Postman, Insomnia, REST Client
- [ ] Testes de contrato
- [ ] Uploads/downloads e streaming; WebSocket/SSE (noções)

## Autoavaliação
1. Quando usar 400, 401, 403, 404 e 422?
2. Por que `PUT` é idempotente e `POST` não?
3. O que é um JWT e por que não é criptografado por padrão?
4. Como evitar IDOR em `/orders/{id}`?
5. Por que o navegador dispara `OPTIONS` antes do `POST`?

## Exercícios
- Construir uma API REST completa (CRUD + auth + paginação + validação)
- Gerar a documentação OpenAPI e conferir contra a implementação
- Implementar JWT à mão (sem biblioteca) para entender, depois trocar por biblioteca
- Escrever testes de API cobrindo sucesso, validação e acesso negado
