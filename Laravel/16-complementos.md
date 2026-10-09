# Camada 16: Complementos

**Foco:** habilidades transversais e ecossistema que aumentam velocidade, clareza e confiança.

## 1. Ecossistema oficial (conhecer o que existe)
- [ ] **Sanctum, Fortify, Passport, Socialite, Cashier**
- [ ] **Horizon, Telescope, Pulse, Octane, Reverb, Scout, Pint, Pail, Sail, Herd, Forge, Cloud**
- [ ] **Livewire, Inertia**, starter kits
- [ ] Confirme na documentação o que é oficial e o que mudou na sua versão

## 2. Pacotes populares da comunidade
- [ ] **Spatie** (permission, medialibrary, activitylog, query-builder, data)
- [ ] **Filament** (painéis administrativos), Nova (pago), Debugbar
- [ ] Avaliar pacotes: manutenção, compatibilidade de versão, licença, segurança

## 3. Upgrades e versões
- [ ] Ler *release notes* e *upgrade guide*; ferramentas de upgrade (ex.: Laravel Shift, Rector)
- [ ] Política de suporte (correções de bug vs segurança) e planejar upgrades
- [ ] Dependência de versão de PHP (Laravel 13 → PHP 8.3+)
- [ ] Lidar com tutoriais de versões antigas (`Kernel.php`, `app/Http/Kernel`, `config/app.php` providers)

## 4. Arquitetura além do básico
- [ ] Actions, Services, DTOs, Value Objects, Repositories (quando valem e quando são exagero)
- [ ] Modularização (módulos/domínios), DDD leve
- [ ] Eventos de domínio e CQRS (noção)
- [ ] Multi-tenancy (noção)

## 5. Comparar para entender
- [ ] Laravel vs Symfony vs Slim: o que é do PHP e o que é do framework
- [ ] Eloquent (Active Record) vs Doctrine (Data Mapper)
- [ ] Laravel vs Node (Express/Nest): ciclo de vida, share-nothing, Octane
- [ ] Blade/Livewire vs React: onde a lógica de UI vive

## 6. Hábitos
- [ ] Ler a documentação oficial completa pelo menos uma vez (é excelente e curta por tópico)
- [ ] Acompanhar Laravel News e Laracasts; ler código de projetos reais
- [ ] Registrar o que aprendeu (caderno de bugs, comandos, snippets)
- [ ] Revisão espaçada das camadas 1 e 2
- [ ] Explicar o ciclo de vida a alguém em voz alta

## 7. Editor e terminal
- [ ] PhpStorm ou VS Code (Intelephense/Laravel extensions), `barryvdh/laravel-ide-helper` (autocomplete de facades/modelos)
- [ ] Atalhos, snippets, depurador (Xdebug), Git na linha de comando

## Autoavaliação
1. Consigo explicar o Laravel como "PHP comum + container + convenções"?
2. Consigo montar CRUD + API + auth + testes no tempo de um módulo?
3. Consigo decidir entre Inertia e API + SPA para um problema novo?

## Exercícios
- Atualizar um projeto de uma versão antiga para a atual seguindo o guia
- Criar um painel admin com Filament e depois reimplementar uma parte à mão
- Escrever um pacote Laravel local (provider + config + comando) e instalá-lo via Composer
- Montar sua cola de comandos `artisan` e snippets
