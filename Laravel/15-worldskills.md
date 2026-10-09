# Camada 15: Preparação Específica para WorldSkills

**Foco:** transformar conhecimento em desempenho sob pressão. **Confirme no Technical Description da sua edição se o Laravel é permitido, exigido ou se o projeto pede PHP puro/outros frameworks.** O que está nos documentos oficiais prevalece sobre este mapa.

## 1. Conhecer a competição
- [ ] Ler **Technical Description** e **Test Projects** anteriores (WorldSkills / SENAI)
- [ ] Entender o **marking scheme** e onde estão os pontos
- [ ] Mapear módulos típicos (back-end/API, banco, correção de bugs, integração com front, segurança)
- [ ] **Regras:** frameworks, pacotes e ferramentas permitidos, internet/documentação, versão do PHP/Laravel, tempo, formato de entrega
- [ ] Se Laravel não for permitido: PHP puro bem estruturado (mini-framework da camada 14 ajuda)

## 2. Habilidades que pontuam
- [ ] Ler requisitos com precisão (pontuação por requisito literal)
- [ ] CRUD, relacionamentos e regras de negócio corretos
- [ ] API consistente (status codes, validação, formato de erro)
- [ ] Autenticação e autorização (policies) funcionando
- [ ] **Segurança básica:** mass assignment, SQL cru, XSS, upload, IDOR, `APP_DEBUG`
- [ ] Banco bem modelado, migrations/seeders reproduzíveis
- [ ] Código limpo e consistente (Pint/PSR-12), testes quando pedido
- [ ] **Correção de bugs em código alheio** (camada 11)
- [ ] Integração com o front (CORS, Sanctum, Inertia)
- [ ] Git e entrega ordenada

## 3. Velocidade (o Laravel favorece quem tem rotina)
- [ ] Dominar `php artisan make:*` (model com `-mfsc`, controller `--resource`, request, policy, resource)
- [ ] Atalhos: `migrate:fresh --seed`, `route:list`, `tinker`, `optimize:clear`
- [ ] **Esqueleto próprio** (estrutura, auth básica, tratamento de erros em JSON, CORS), se as regras permitirem
- [ ] Snippets para validação, policies, resources e testes

## 4. Gestão de tempo
- [ ] Ler o projeto inteiro antes de codar; planejar em blocos
- [ ] Priorizar pelo peso na pontuação; fazer funcionar primeiro, refinar depois
- [ ] Testar cada etapa (`curl`/Postman/testes), commits frequentes
- [ ] Reservar os últimos minutos: seeders, `.env.example`, instruções, rodar do zero (`migrate:fresh --seed`)

## 5. Rotina de treino
- [ ] Simulados cronometrados com projetos anteriores; repetir até ficar fluido
- [ ] Caderno de bugs (camada 11) e de comandos
- [ ] Treinar em ambiente limpo e com versões do ambiente da competição
- [ ] Praticar leitura de código alheio e correção de bugs sob cronômetro
- [ ] Inglês técnico (docs e enunciados)

## 6. Checklist de entrega
- [ ] Todos os requisitos mapeados e marcados
- [ ] Projeto sobe do zero: `composer install`, `.env`, `key:generate`, `migrate --seed`, `npm run build`
- [ ] `APP_DEBUG=false` quando pedir produção; sem segredos no repositório
- [ ] Validação, status codes e autorização corretos
- [ ] Testes passando (se exigidos), Pint aplicado
- [ ] README com instruções de execução e credenciais de teste
- [ ] Último commit com tudo funcionando

## Plano em fases (sugestão)
1. **Base:** camadas 0 e 1
2. **Núcleo:** camadas 2, 3 e 5
3. **Aplicação:** camadas 4, 6, 7 e 10
4. **Refinamento:** camadas 8, 9, 11 e 12
5. **Integração:** camada 13
6. **Profundidade:** camada 14
7. **Simulados:** esta camada, repetidamente
