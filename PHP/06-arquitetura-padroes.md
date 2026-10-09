# Camada 6: Arquitetura e Padrões

**Foco:** organizar código para que cresça sem virar bagunça. É o que separa "funciona" de "profissional".

## 1. Princípios
- [ ] **SOLID:** responsabilidade única, aberto/fechado, Liskov, segregação de interfaces, inversão de dependência
- [ ] DRY, KISS, YAGNI
- [ ] Coesão e acoplamento
- [ ] Composição sobre herança
- [ ] Lei de Demeter (noção)

## 2. MVC e variações
- [ ] Model, View, Controller; responsabilidades reais de cada um
- [ ] "Controllers magros, regras no domínio/serviços"
- [ ] Front controller, router, dispatcher
- [ ] MVC vs MVVM vs ADR (Action-Domain-Responder)

## 3. Injeção de Dependência
- [ ] Passar dependências em vez de criá-las (construtor, setter)
- [ ] **Inversão de controle** e interfaces
- [ ] **Container de DI:** registro, resolução, *autowiring* por reflexão
- [ ] PSR-11
- [ ] Por que Singleton e estado global dificultam testes

## 4. Padrões de projeto úteis em PHP
- [ ] **Criacionais:** Factory, Builder, Singleton (e seus problemas)
- [ ] **Estruturais:** Adapter, Decorator, Facade, Proxy
- [ ] **Comportamentais:** Strategy, Observer, Command, Template Method, Chain of Responsibility (base do middleware)
- [ ] **Arquiteturais:** Repository, Service Layer, Unit of Work, DTO, Value Object

## 5. Arquiteturas maiores
- [ ] Arquitetura em camadas, Clean/Hexagonal (portas e adaptadores)
- [ ] Noções de DDD: entidades, agregados, linguagem ubíqua
- [ ] Eventos de domínio, filas e jobs
- [ ] Monólito modular vs microsserviços (trade-offs)
- [ ] Estrutura de pastas: por tipo vs por feature

## 6. Frameworks
- [ ] **Laravel:** ciclo de vida, container, service providers, Eloquent, middleware, Artisan
- [ ] **Symfony:** componentes, HttpKernel, DI container
- [ ] **Slim:** microframework e PSR-15
- [ ] Ler o ciclo de uma requisição dentro do framework
- [ ] Separar **o que é PHP** do **que é do framework**

## 7. Projeto-chave: mini-framework
- [ ] Request/Response, Router com parâmetros
- [ ] Container de DI com autowiring
- [ ] Pipeline de middleware
- [ ] Controllers, templates e tratamento de exceções

## Autoavaliação
1. Qual problema o container de DI resolve?
2. Por que Repository separa o domínio do banco?
3. Quando Singleton vira problema?
4. Como o middleware se relaciona com Chain of Responsibility?
5. O que o Laravel faz entre `public/index.php` e o controller?

## Exercícios
- Refatorar um CRUD com SQL dentro do controller para camadas (Controller → Service → Repository)
- Implementar um container com autowiring usando `ReflectionClass`
- Implementar 5 padrões em exemplos pequenos
- Construir o mini-framework e rodar um app sobre ele
- Ler o código de `Illuminate\Container` ou `Slim\App` e anotar o fluxo
