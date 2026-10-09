# Camada 3: Composer e Ecossistema

**Foco:** entender como o PHP carrega código de terceiros e do próprio projeto. A maioria dos "Class not found" nasce aqui.

## 1. Composer
- [ ] `composer.json`: `require`, `require-dev`, `autoload`, `autoload-dev`, `scripts`, `config`
- [ ] `composer.lock`: o que garante; **versionar sempre** em aplicações
- [ ] `install` vs `update` vs `require`; `composer.lock` ausente vs presente
- [ ] Semver e constraints (`^`, `~`, `>=`)
- [ ] Packagist, repositórios privados, `vendor/`
- [ ] `composer dump-autoload -o`, `composer audit`, `composer outdated`

## 2. Autoload
- [ ] O problema que ele resolve (adeus `require` em cascata)
- [ ] `spl_autoload_register` e o que acontece em `new Classe()` / `use`
- [ ] **PSR-4:** namespace ↔ diretório (`App\Models\User` → `src/Models/User.php`)
- [ ] Classmap vs PSR-4 vs `files`
- [ ] Case-sensitivity em Linux (nome de arquivo ≠ nome da classe)
- [ ] `vendor/autoload.php` e `vendor/composer/autoload_*.php`

## 3. PSRs (PHP-FIG)
- [ ] PSR-1/12: estilo; PSR-4: autoload; PSR-3: logger
- [ ] PSR-7/17: mensagens HTTP; PSR-15: middleware; PSR-18: cliente HTTP
- [ ] PSR-11: container; PSR-6/16: cache

## 4. Pacotes comuns
- [ ] Monolog, Guzzle, Symfony components (HttpFoundation, Console, Routing), vlucas/phpdotenv
- [ ] Carbon, Twig, PHPMailer ou Symfony Mailer, Ramsey UUID
- [ ] Avaliar um pacote: manutenção, downloads, licença, segurança

## 5. Supply chain
- [ ] Revisar dependências, evitar pacotes abandonados
- [ ] `composer audit` no CI, fixar versões, lockfile no repositório
- [ ] Cuidado com scripts de pacotes

## Autoavaliação
1. O que o Composer gera em `vendor/autoload.php`?
2. Como `App\Service\Mailer` é encontrada pelo PSR-4?
3. Por que `Class not found` pode aparecer só em Linux?
4. Diferença entre `composer install` e `composer update`?

## Exercícios
- **Escrever seu próprio autoloader PSR-4** com `spl_autoload_register`
- Criar e publicar (local) um pacote com `composer.json` próprio
- Quebrar o autoload de propósito (namespace errado, nome de arquivo) e ler o erro
- Rodar `composer audit` em um projeto antigo
