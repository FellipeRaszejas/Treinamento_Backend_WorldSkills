# Camada 16: Regras de Negócio, Validação e CRUD Completo (independente de framework)

**Foco:** a parte que mais diferencia quem "faz CRUD" de quem constrói sistemas corretos: **onde cada regra vive, como garantir que ela nunca seja burlada e como o sistema se comporta sob erro e concorrência**. Nível: básico a avançado.

## 1. O que é "regra de negócio"
- [ ] Diferença entre **regra de negócio** (do domínio: "pedido pago não pode ser editado") e **regra técnica** (formato, tamanho, tipo)
- [ ] **Invariante:** condição que **sempre** deve ser verdadeira ("saldo nunca negativo", "estoque ≥ 0")
- [ ] Ler um enunciado e **extrair as regras explícitas e implícitas** (o que o texto não diz mas o negócio exige)
- [ ] Documentar regras (tabela: regra → onde é garantida → como é testada)

## 2. Níveis de validação (aprender a separar)
| Nível | Pergunta | Exemplos | Onde |
|---|---|---|---|
| **1. Sintática** | O dado tem a forma certa? | tipo, tamanho, formato de e-mail/CPF | Camada de entrada (request) |
| **2. Semântica** | Os dados fazem sentido entre si? | data fim ≥ data início | Entrada/domínio |
| **3. De negócio** | O sistema permite isso agora? | estoque suficiente, plano ativo, estado válido | Domínio/serviço |
| **4. De integridade** | O banco garante? | `UNIQUE`, `FOREIGN KEY`, `NOT NULL`, `CHECK` | Banco de dados |
- [ ] **Regra de ouro:** validação no front é só conveniência; **o servidor valida tudo**, e **o banco é a última barreira**
- [ ] Nunca confiar apenas em verificação em PHP para unicidade: use **constraint no banco** (há condição de corrida)
- [ ] Mensagens de erro por campo e erros "globais"; formato consistente para o front

## 3. CRUD além do básico
- [ ] **Create:** valores padrão, campos calculados, quem é o dono, idempotência (evitar duplicar com duplo clique)
- [ ] **Read:** listagem com **filtros, busca, ordenação e paginação**; limites; só os campos necessários; ordenação estável
- [ ] **Update:** total vs parcial (`PUT` vs `PATCH`); **concorrência otimista** (campo `version`/`updated_at`) para evitar sobrescrever alterações alheias
- [ ] **Delete:** **soft delete** vs físico; efeitos em cascata; registros que não podem ser apagados (histórico, financeiro)
- [ ] **Restaurar**, arquivar, **auditoria** (quem/quando/o quê)
- [ ] **Operações em lote** (bulk), import/export CSV, uploads
- [ ] Relacionamentos: criar/atualizar entidades filhas na mesma operação, sincronizar N:N

## 4. Modelando o domínio
- [ ] **Entidades** (identidade) vs **Value Objects** (valor, imutáveis: `Money`, `Email`, `Period`)
- [ ] **Enums** para estados e tipos (em vez de strings soltas)
- [ ] **Máquina de estados:** estados válidos e transições permitidas (`rascunho → publicado → arquivado`); onde validar a transição
- [ ] **Exceções de domínio** (`InsufficientStock`, `InvalidTransition`) com mensagens úteis e mapeamento para códigos HTTP (409/422)
- [ ] Não permitir objetos em estado inválido (validar na criação, construtores/fábricas)
- [ ] **Dinheiro:** inteiros em centavos ou `bcmath`; moeda; arredondamento definido pela regra
- [ ] **Datas:** UTC no banco, timezone na exibição; períodos; "fim do dia"; feriados/dias úteis como regra explícita

## 5. Transações, consistência e concorrência
- [ ] **ACID:** o que a transação garante; `BEGIN/COMMIT/ROLLBACK`
- [ ] **Operação multi-passo atômica:** tudo ou nada
- [ ] **Condições de corrida** clássicas: estoque, saldo, número sequencial, "verificar e depois gravar"
- [ ] **Soluções:** constraint `UNIQUE`; `SELECT ... FOR UPDATE` (lock pessimista); update atômico (`UPDATE ... SET qtd = qtd - 1 WHERE qtd >= 1`); versionamento (otimista); fila serial
- [ ] **Idempotência:** repetir a operação não duplica efeito (chave de idempotência, `UNIQUE` em token)
- [ ] **Efeitos colaterais após o commit:** e-mail/webhook só depois que os dados estão salvos
- [ ] Deadlocks e como reduzi-los (ordem consistente de acesso)

## 6. Onde colocar cada coisa (arquitetura)
- [ ] Controller: HTTP em, HTTP out
- [ ] Camada de entrada: valida **forma** e autoriza
- [ ] **Service/Action/Domínio:** executa regras de negócio e orquestra
- [ ] Repositório/ORM: persistência
- [ ] Banco: constraints como defesa final
- [ ] Evitar regra de negócio em: view, controller, JS do front, trigger escondido sem documentação
- [ ] **Uma regra, um lugar:** se está em dois, um deles diverge

## 7. Tratamento de erros
- [ ] Erros **esperáveis** (validação, regra violada, não encontrado, sem permissão) vs **inesperados** (bug, banco fora do ar)
- [ ] Códigos HTTP coerentes: 400, 401, 403, 404, 409, 422, 429, 500
- [ ] Não vazar detalhes internos; registrar no log com contexto
- [ ] Mensagens para o usuário vs mensagens para o desenvolvedor

## 8. Testar regras de negócio
- [ ] Um teste por regra (caminho feliz **e** violação)
- [ ] **Valores-limite** (zero, máximo, exatamente no limite, um acima)
- [ ] Testes de concorrência (dois processos) para regras críticas
- [ ] Testes de transição de estado (permitidas e proibidas)
- [ ] Dados de teste que representam casos reais

## Autoavaliação
1. Qual a diferença entre validar um e-mail e validar que "o plano do cliente permite esta ação"?
2. Por que "checar se o e-mail existe e depois inserir" não garante unicidade?
3. Como impedir que dois pedidos simultâneos vendam o último item?
4. Onde garantir que um pedido pago não pode ser editado?
5. Por que `PATCH` e `PUT` têm regras diferentes?
6. O que fazer quando a operação grava no banco e falha ao enviar o e-mail?

## Exercícios
- Pegar um enunciado de projeto (WorldSkills/SENAI) e produzir a **tabela de regras** (regra, nível de validação, onde é garantida, teste)
- Implementar uma máquina de estados de pedido com enum e transições, e testar todas as proibidas
- Reproduzir uma venda duplicada do último item com dois processos e corrigir com update atômico e com lock
- Implementar concorrência otimista com campo `version` e retornar 409 em conflito
- Implementar um CRUD completo com filtros, ordenação, paginação, soft delete, restore e auditoria
