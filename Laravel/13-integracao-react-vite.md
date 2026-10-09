# Camada 13: Integração com React/Vite (Full-stack)

**Foco:** juntar o seu conhecimento de React/Vite com o Laravel, de duas formas diferentes: **Inertia** (monólito) e **SPA separada com API** (Sanctum).

## 1. Duas arquiteturas (saber escolher)
| | Inertia + React | Laravel API + SPA React |
|---|---|---|
| Roteamento | Servidor (Laravel) | Cliente (React Router) |
| Dados | Props de controllers | Requisições `fetch`/Axios |
| Auth | Sessão (cookie) | Sanctum SPA (cookie) ou token |
| Deploy | Um só app | Dois apps (ou um servindo o `dist/`) |
| Quando | Time pequeno, rapidez | Mobile/terceiros consomem a API, times separados |

## 2. Inertia + React
- [ ] Controllers retornam `Inertia::render('Pagina', [...props])`
- [ ] Páginas React em `resources/js/Pages`, layout persistente
- [ ] Formulários (`useForm`), validação e erros vindos do Laravel, redirects
- [ ] `Link`, visitas, *shared data* (`HandleInertiaRequests`), flash messages
- [ ] Vite + `laravel-vite-plugin` + plugin React; SSR opcional (noção)
- [ ] Starter kit React: **ler** o código gerado
- [ ] Segurança: não passar dados sensíveis nas props (vão para o HTML/JSON)

## 3. Laravel API + React SPA
- [ ] Projetos separados: Vite (`:5173`) e Laravel (`:8000`)
- [ ] **Proxy do Vite** (`server.proxy`) *ou* **CORS** no Laravel
- [ ] **Sanctum SPA:** chamar `/sanctum/csrf-cookie`, depois login; cookie de sessão e `X-XSRF-TOKEN`; `withCredentials`/`credentials: 'include'`
- [ ] `config/cors.php` (`supports_credentials`), `SANCTUM_STATEFUL_DOMAINS`, `SESSION_DOMAIN`
- [ ] Alternativa: token Bearer (trade-offs de onde guardar o token)
- [ ] Tratar 401 (login), 403, 419, 422 (erros por campo) e 429
- [ ] Variáveis: `VITE_API_URL` (pública!)

## 4. Contrato e tipos
- [ ] OpenAPI como contrato; gerar tipos/cliente para TypeScript (opcional)
- [ ] API Resources com formato estável; versionamento
- [ ] Mesmos nomes e formatos de data/enum nos dois lados

## 5. Desenvolvimento e produção
- [ ] Dev: `php artisan serve` + `npm run dev` (ou Sail/Docker Compose)
- [ ] Produção Inertia: `npm run build` → `public/build` (um deploy)
- [ ] Produção SPA: `dist/` servido pelo Nginx, `/api` para o Laravel (**mesma origem** evita CORS), **SPA fallback**
- [ ] `base` do Vite quando em subpasta; cache de assets com hash
- [ ] Docker Compose: `nginx`, `php-fpm`, `db`, `node` (dev)

## 6. Estados de UI vs API
- [ ] Loading, sucesso, vazio, erro de rede, erro de validação, não autorizado
- [ ] Padronizar formato de erro do Laravel para o front consumir

## Autoavaliação
1. Por que o Inertia dispensa uma API REST separada?
2. Por que o Sanctum SPA exige `csrf-cookie` antes do login?
3. O que o Laravel precisa responder ao `OPTIONS` do preflight?
4. Por que recarregar uma rota do React dá 404 em produção e como o Nginx resolve?
5. Cookie `HttpOnly` vs token em `localStorage`: trade-offs?

## Exercícios
- Mesmo CRUD em **Inertia + React** e em **API + SPA com Sanctum**, comparando esforço e limitações
- Fazer funcionar com proxy do Vite e depois só com CORS
- Quebrar CORS, CSRF e cookie de propósito e diagnosticar
- Subir tudo com Docker Compose simulando produção (Nginx servindo `dist/` + `/api`)
