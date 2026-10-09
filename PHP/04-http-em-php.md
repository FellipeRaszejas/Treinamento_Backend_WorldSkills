# Camada 4: HTTP em PHP

**Foco:** como a requisição vira variáveis PHP e como a resposta sai. Construir uma aplicação **sem framework** primeiro.

## 1. Entrada
- [ ] Superglobais: `$_GET`, `$_POST`, `$_SERVER`, `$_COOKIE`, `$_FILES`, `$_REQUEST`, `$_ENV`
- [ ] `php://input` e leitura de corpo JSON
- [ ] Como o PHP interpreta formulários (`a[b]=1` vira array)
- [ ] `filter_input`, `filter_var`
- [ ] Headers da requisição (`getallheaders`, `$_SERVER['HTTP_*']`)

## 2. Saída
- [ ] `header()`, `http_response_code()`, `Location` e redirects (`exit` depois)
- [ ] **"Headers already sent":** saída antes dos headers, BOM, espaços
- [ ] Output buffering (`ob_start`)
- [ ] Enviar JSON, arquivos, downloads, streams

## 3. Sessões e cookies
- [ ] `session_start`, armazenamento, `session.save_path`, cookie `PHPSESSID`
- [ ] `session_regenerate_id`, expiração, destruição correta
- [ ] `setcookie` com `HttpOnly`, `Secure`, `SameSite`
- [ ] Sessões em Redis/banco para vários servidores

## 4. Uploads
- [ ] `$_FILES`, `move_uploaded_file`
- [ ] Limites: `upload_max_filesize`, `post_max_size`, `max_file_uploads`
- [ ] Validação de tipo e tamanho, nome seguro, destino fora do web root

## 5. Roteamento e front controller
- [ ] `public/index.php` como único ponto de entrada
- [ ] Reescrita de URL, `REQUEST_URI`, `parse_url`
- [ ] Router manual (método + padrão → handler), parâmetros de rota
- [ ] Bibliotecas: FastRoute, Symfony Routing

## 6. Middleware e PSR-7/15
- [ ] Padrão de pipeline: request → middlewares → handler → response
- [ ] Objetos imutáveis de Request/Response
- [ ] Exemplos: autenticação, CORS, logging, tratamento de erros

## 7. Apresentação
- [ ] Templates em PHP puro (`ob_start` + `include`), Twig, Blade
- [ ] **Escape de saída** (`htmlspecialchars`)
- [ ] Layouts, partials, flash messages, paginação

## 8. Extras
- [ ] E-mail (SMTP), geração de PDF/CSV, cron e CLI
- [ ] i18n e fusos horários
- [ ] Negociação de conteúdo (`Accept`)

## Autoavaliação
1. Como `index.php?id=5` chega em `$_GET['id']`?
2. Por que `header()` falha depois de um `echo`?
3. Onde fica o estado da sessão e como o navegador o referencia?
4. Por que o limite de upload "não obedece" meu código?
5. Qual a diferença entre `$_POST` e `php://input`?

## Exercícios
- Construir um site CRUD sem framework: front controller, router, templates e sessão
- Escrever um **pipeline de middleware** à mão
- Implementar login com sessão e logout seguro
- Upload de imagem com validação e miniatura
