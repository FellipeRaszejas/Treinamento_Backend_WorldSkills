# Camada 4: Blade e Front-end

**Foco:** como o Laravel entrega interface: Blade (um compilador de templates), Vite integrado, e as pontes para JS (Livewire e Inertia).

## 1. Blade por dentro
- [ ] **Blade é compilado para PHP** e cacheado em `storage/framework/views` (hash do caminho do arquivo)
- [ ] Como: o `BladeCompiler` converte diretivas e `{{ }}` com expressões regulares em código PHP
- [ ] `{{ $x }}` (**escapa** com `e()`) vs `{!! $x !!}` (**cru**, perigo de XSS)
- [ ] Diretivas: `@if`, `@foreach`, `@forelse`, `@auth`, `@guest`, `@can`, `@csrf`, `@method`, `@error`, `@include`, `@stack/@push`
- [ ] `$loop`, `@php`, comentários `{{-- --}}`
- [ ] `php artisan view:clear`, `view:cache`
- [ ] Criar diretivas customizadas (`Blade::directive`)

## 2. Layouts e componentes
- [ ] Herança (`@extends/@section/@yield`) vs **componentes** (`<x-layout>`, slots)
- [ ] **Componentes de classe** e **anônimos**, props (`@props`), atributos (`$attributes->merge`)
- [ ] Slots nomeados, `{{ $slot }}`
- [ ] Organização de pastas (`resources/views/components`)

## 3. Vite no Laravel
- [ ] `vite.config.js` com `laravel-vite-plugin` (entradas em `resources/js` e `resources/css`)
- [ ] `@vite([...])` no Blade: em dev aponta para o servidor do Vite; em produção lê `public/build/manifest.json`
- [ ] `npm run dev` vs `npm run build`
- [ ] Erro "Vite manifest not found": assets não compilados
- [ ] Hot reload e CSS/JS próprios, Tailwind (padrão nos starter kits)

## 4. Livewire (UI reativa em PHP)
- [ ] Componentes que mantêm estado no servidor, requisições AJAX automáticas
- [ ] Propriedades, ações, validação, eventos
- [ ] Quando faz sentido e custos (round-trips)

## 5. Inertia (Laravel ↔ React/Vue)
- [ ] Páginas React/Vue servidas por controllers (`Inertia::render('Page', props)`)
- [ ] Sem API REST separada; roteamento no servidor; props e *shared data*
- [ ] Formulários, validação, redirects, `<Link>`
- [ ] Como difere de uma SPA com API (camada 13)

## 6. Starter kits
- [ ] Kits para **React**, **Vue** e **Livewire** (confirme na doc da sua versão)
- [ ] O que cada um instala (auth, layouts, Tailwind, Vite)
- [ ] Ler o código gerado para aprender (em vez de usar como caixa preta)

## 7. Outros
- [ ] Localização (`__()`, `lang/`), formatação de datas/números
- [ ] Mail com Blade/Markdown (camada 8)
- [ ] Acessibilidade e semântica nas views

## Autoavaliação
1. Onde fica o PHP gerado a partir de um template Blade?
2. Por que `{!! !!}` é perigoso?
3. Qual a diferença entre `@vite` em dev e em produção?
4. Livewire vs Inertia: quando escolher cada um?
5. Por que a edição do Blade "não aparece" às vezes?

## Exercícios
- Abrir um arquivo compilado em `storage/framework/views` e comparar com o `.blade.php`
- Criar uma diretiva Blade própria (`@money($valor)`)
- Montar um layout com componentes (`<x-card>`, `<x-button>`) e slots
- Ler o `manifest.json` gerado por `npm run build`
- Escrever um **mini-compilador Blade** (regex → PHP) com `{{ }}`, `@if`, `@foreach`
