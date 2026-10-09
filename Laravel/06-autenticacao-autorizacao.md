# Camada 6: Autenticação e Autorização

**Foco:** quem é o usuário (autenticação) e o que ele pode fazer (autorização), com a segurança sempre no servidor.

## 1. Conceitos centrais
- [ ] **Guards** (como autenticar: `session`, `token`/Sanctum) e **User Providers** (onde buscar o usuário: `eloquent`, `database`)
- [ ] `config/auth.php`
- [ ] Facade `Auth`: `check`, `user`, `id`, `attempt`, `login`, `logout`
- [ ] Sessão e cookie: `remember me`, regeneração de sessão no login, logout seguro
- [ ] Hashing (`Hash::make/check`, `needsRehash`), nunca guardar senha em texto

## 2. Starter kits e pacotes
- [ ] Starter kits (React/Vue/Livewire): o que geram e **ler o código gerado**
- [ ] **Fortify** (back-end de auth sem UI), conceito de Breeze/Jetstream (legado/alternativo)
- [ ] Verificação de e-mail, reset de senha, confirmação de senha
- [ ] 2FA (noção), login social com **Socialite**
- [ ] **Confirme na doc** quais kits e opções existem na sua versão

## 3. Sanctum
- [ ] **Tokens de API** (personal access tokens, abilities/escopos)
- [ ] **Autenticação de SPA** com cookie de sessão + CSRF (`/sanctum/csrf-cookie`)
- [ ] Configurar `stateful domains`, CORS e cookies (`SESSION_DOMAIN`)
- [ ] Revogação de tokens
- [ ] **Passport** (OAuth2 completo): quando é necessário (noção)

## 4. Autorização
- [ ] **Gates** (`Gate::define`) vs **Policies** (por modelo, `viewAny/view/create/update/delete`)
- [ ] Usar: `Gate::authorize()`, `Gate::allows`, `$user->can`, `@can`, middleware `can:` (`$this->authorize()` exige o trait `AuthorizesRequests`, que o `Controller` base do Laravel 11+ não inclui)
- [ ] Registro/descoberta de Policies (convenção de nome ou `Gate::policy`) e `make:policy --model`
- [ ] Ver também a camada 17 (fluxo com FormRequest e Service)
- [ ] Respostas customizadas (`Response::deny`), `before()` para admins
- [ ] **Roles e permissões:** modelagem própria ou pacote (ex.: Spatie Permission)
- [ ] Evitar **IDOR**: sempre verificar o dono do recurso

## 5. Proteções
- [ ] **Rate limiting** de login (`throttle`, `RateLimiter`)
- [ ] Bloqueio de enumeração de usuários, mensagens genéricas
- [ ] Senhas fortes e `Password::` rules
- [ ] Sessões: driver (`database`, `redis`), expiração, múltiplos dispositivos (`logoutOtherDevices`)

## Autoavaliação
1. Qual a diferença entre guard e user provider?
2. Por que regenerar a sessão no login?
3. Policy vs Gate: quando usar cada um?
4. Como o Sanctum autentica uma SPA sem token?
5. Por que `@can` no menu não basta para proteger a rota?

## Exercícios
- Implementar login, registro e logout **à mão** (sem starter kit) para entender o fluxo
- Escrever uma Policy completa para um recurso e testá-la
- Configurar Sanctum com tokens e depois com SPA (cookie)
- Criar um sistema simples de roles e um middleware de permissão
- Tentar acessar `/orders/{id}` de outro usuário e corrigir a falha (IDOR)
