# Camada 13: Preparação Específica para WorldSkills

**Foco:** transformar conhecimento em desempenho sob pressão. Os documentos oficiais da sua edição prevalecem sobre este mapa.

## 1. Conhecer a competição
- [ ] Ler o **Technical Description** e os **Test Projects** de edições anteriores (WorldSkills / SENAI)
- [ ] Entender o **marking scheme**: onde estão os pontos e como são medidos
- [ ] Mapear módulos típicos (back-end, correção de bugs, integração com front, banco, segurança) e seus pesos
- [ ] Regras: ferramentas e documentação permitidas, internet, tempo, formato de entrega

## 2. Habilidades que pontuam
- [ ] Ler requisitos com precisão (pontuação por requisito literal)
- [ ] CRUD completo, relacionamentos e regras de negócio
- [ ] API REST consistente e documentada
- [ ] Validação e tratamento de erros
- [ ] **Segurança básica:** prepared statements, hash de senha, escape, autorização
- [ ] Modelagem e SQL corretos; integridade
- [ ] Código limpo, organizado e consistente (PSR-12)
- [ ] Integração com o front-end
- [ ] **Correção de bugs em código alheio** (Camada 10)
- [ ] Git e entrega ordenada

## 3. Gestão de tempo
- [ ] Ler o projeto inteiro antes de codar
- [ ] Planejar em blocos e priorizar pelo peso na pontuação
- [ ] Fazer funcionar primeiro, refinar depois
- [ ] Testar a cada etapa (`curl`/Postman), commits frequentes
- [ ] Reservar os últimos minutos para revisão e checklist (dados de seed, instruções, `.env.example`)

## 4. Rotina de treino
- [ ] Simulados cronometrados com projetos anteriores
- [ ] Repetir o mesmo projeto até ficar fluido
- [ ] **Esqueleto próprio** (estrutura, front controller, router, PDO helper, autoload), se as regras permitirem
- [ ] Caderno de bugs e de erros de ambiente (Camada 10)
- [ ] Treinar sem autocompletar pesado/IA quando as regras exigirem
- [ ] Praticar em ambiente desconhecido e com tempo reduzido
- [ ] Dominar editor, terminal e atalhos

## 5. Preparo mental e logístico
- [ ] Sono, alimentação e pausas
- [ ] Conferir o ambiente da competição (SO, versões de PHP/MySQL/Composer/Node)
- [ ] Inglês técnico para enunciados e documentação
- [ ] Comunicação e feedback com Expert/treinador

## Checklist de entrega
- [ ] Todos os requisitos do enunciado mapeados e marcados
- [ ] Banco com schema e dados de seed funcionando do zero
- [ ] Sem `display_errors` vazando detalhes; sem credenciais no código
- [ ] Validações e códigos HTTP corretos
- [ ] README/instruções de execução
- [ ] Último commit com tudo funcionando

## Plano em fases (sugestão)
1. **Base:** Camadas 0, 1 e 3
2. **Núcleo:** Camadas 2, 4 e 5
3. **Aplicação:** Camadas 6, 7 e 8 em projeto próprio
4. **Refinamento:** Camadas 9, 10 e 11
5. **Integração:** Camada 12
6. **Simulados:** esta camada, repetidamente
