# Camada 17: Fluxo CRUD Completo (Migration + FormRequest + Policy + Service)

**Foco:** juntar as quatro peças que você já usa no dia a dia e entender **o papel de cada uma, onde ela atua no ciclo da requisição e como estudá-la na documentação**.

> **Importante:** Migration, FormRequest e Policy são recursos **do Laravel**, descritos na documentação oficial. **Service não é um recurso do Laravel**: é um padrão de organização (uma classe PHP comum). Por isso a documentação do Laravel **não** ensina Service; você aprende o padrão aqui, na camada 6 do mapa de PHP (SOLID, DI) e na camada 2 deste mapa (container).

## 1. Papel de cada peça

| Peça | O que é | Quando atua | Comando | O que estudar na doc (laravel.com/docs) |
|---|---|---|---|---|
| **Migration** | Versiona o schema do banco em código | Antes de tudo (`artisan migrate`), fora da requisição | `make:migration`, `make:model -m` | *Database: Migrations* (criar tabelas, colunas, índices, chaves estrangeiras) |
| **FormRequest** | Autoriza e valida a entrada **antes** do controller | Início da requisição, ao resolver o parâmetro do controller | `make:request` | *Validation → Form Request Validation* |
| **Policy** | Regras "este usuário pode fazer isto neste recurso?" | Chamada pelo FormRequest, controller, middleware ou Blade | `make:policy --model=Post` | *Authorization → Creating Policies / Writing Policies / Authorizing Actions Using Policies* |
| **Service** | Regra de negócio e orquestração (transações, vários models, e-mails/jobs) | Dentro do controller, depois da validação e da autorização | `make:class` (Laravel recente) ou criar o arquivo | Não há página. Veja *Service Container → Automatic Injection* |

## 2. Fluxo integrado (decorar)
```
Requisição POST /posts
 → Middleware (auth, throttle...)
 → Route + Controller resolvido pelo container
 → StorePostRequest é instanciado e executado ANTES do método:
      authorize()  → chama a Policy      (falha: 403)
      rules()      → valida a entrada    (falha: 422 JSON ou redirect com $errors)
 → Controller::store(StorePostRequest $request, PostService $service)
      $service->create($request->user(), $request->validated())
          → DB::transaction → Model::create (Eloquent) → tabela criada pela Migration
 → Response (redirect / JsonResource)
```
Regra de ouro: **cada camada faz uma coisa**. Controller recebe e responde; FormRequest valida/autoriza; Policy decide permissão; Service executa a regra de negócio; Model/Eloquent persiste.

## 3. Ordem de construção (um recurso novo)
1. **Migration** (e Model/Factory/Seeder): `php artisan make:model Post -mfs` → editar → `migrate`
2. **Model:** `$fillable`, `casts`, relacionamentos
3. **Policy:** `php artisan make:policy PostPolicy --model=Post` → preencher `viewAny/view/create/update/delete`
4. **FormRequests:** `make:request StorePostRequest` e `UpdatePostRequest`
5. **Service:** `app/Services/PostService.php` com os métodos de negócio
6. **Controller:** `make:controller PostController --resource`, enxuto
7. **Rotas:** `Route::resource` (ou `apiResource`) + middleware `auth`
8. **Resource/View** (JSON ou Blade/Inertia)
9. **Testes** (Feature): sucesso, validação (422), não autorizado (403), visitante (401/redirect)

## 4. Exemplo mínimo de referência (leia, depois reescreva de memória)

**Migration**
```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->text('body');
    $table->timestamps();
});
```

**Policy** (`app/Policies/PostPolicy.php`; é descoberta automaticamente por convenção de nome, confirme na doc da sua versão)
```php
public function update(User $user, Post $post): bool
{
    return $user->id === $post->user_id;
}
```

**FormRequest**
```php
class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('post'));
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body'  => ['required', 'string'],
        ];
    }
}
```

**Service** (classe PHP comum, sem registro necessário: o container faz autowiring)
```php
class PostService
{
    public function update(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            $post->update($data);
            return $post->refresh();
        });
    }
}
```

**Controller**
```php
public function update(UpdatePostRequest $request, Post $post, PostService $service)
{
    $post = $service->update($post, $request->validated());

    return new PostResource($post);
}
```

## 5. Decisões: o que vai onde
- [ ] **Validação** de formato/regras de entrada → FormRequest (`rules`)
- [ ] **Autorização** ("pode?") → Policy, **chamada** pelo FormRequest/controller/rota
- [ ] **Regra de negócio** (calcular, orquestrar, transação, disparar job/e-mail) → Service
- [ ] **Persistência simples** (CRUD puro) → pode ficar no controller ou no Eloquent; **não crie Service só por criar** (YAGNI)
- [ ] **Consultas reutilizáveis** → scopes do Eloquent
- [ ] Service **não** recebe `Request`; recebe dados já validados (`validated()`), DTO ou models
- [ ] Service **não** valida entrada nem retorna `Response`; retorna dados/models e lança exceções de domínio
- [ ] Service é resolvido por **injeção** (construtor/método), não com `new` nem Facade escondida
- [ ] Interface + binding no Provider só quando houver mais de uma implementação ou necessidade de trocar em teste

## 6. Pegadinhas (as que mais quebram)
- [ ] **Laravel 11+:** o `Controller` base não traz o trait `AuthorizesRequests`, então `$this->authorize()` pode não existir. Use `Gate::authorize('update', $post)` ou adicione o trait
- [ ] Ordem: o FormRequest roda **antes** do controller; se `authorize()` retornar `false`, o controller nem executa (403)
- [ ] Em `authorize()` do FormRequest, o model vem de `$this->route('post')` (já resolvido pelo route model binding, se o parâmetro tiver o nome certo)
- [ ] Use **`$request->validated()`**, nunca `$request->all()`, para criar/atualizar (mass assignment)
- [ ] Policy não registrada/nome fora da convenção → sempre 403 (cheque auto-discovery ou `Gate::policy`)
- [ ] Migration já executada em produção **não se edita**: crie outra migration
- [ ] `foreignId()->constrained()` assume tabela `users` pelo nome da coluna (`user_id`); nomes diferentes exigem parâmetro
- [ ] Transação no Service: efeitos colaterais (e-mail/job) devem ocorrer **depois do commit** (`afterCommit`)
- [ ] Policy para ações sem model (`create`, `viewAny`) recebe só o `User`

## 7. Como estudar na documentação (método)
1. Abrir a página, ler o **sumário** e identificar as seções que você usa (criar, regras, mensagens)
2. Testar **cada exemplo** em um projeto de teste (não só ler)
3. Rodar `php artisan make:... --help` para ver as opções do gerador
4. Ler o código gerado pelo `make:` e **entender cada linha** (inclusive os comentários)
5. Ao terminar cada página, **reescrever o exemplo de memória** em outro recurso
6. Anotar no seu caderno: o que faz, quando usar, a pegadinha

## 8. Checklist de domínio ("consigo sem consultar")
- [ ] Criar tabela com FKs, índices e `unique` em uma migration, e reverter com `down()`
- [ ] Alterar tabela existente com migration nova
- [ ] FormRequest com `rules`, `messages`, `attributes`, `prepareForValidation`, `authorize`
- [ ] Regras com `Rule::unique(...)->ignore($id)`, `exists`, `in`, `Enum`
- [ ] Policy completa (`viewAny`, `view`, `create`, `update`, `delete`, `restore`, `forceDelete`) e `before()` para admin
- [ ] Usar a Policy em: FormRequest, controller (`Gate::authorize`), middleware (`can:`), Blade (`@can`)
- [ ] Service com transação, injetado em controller, job e comando artisan
- [ ] Testar o fluxo inteiro com Pest/PHPUnit (200/201, 422, 403, 401)

## Autoavaliação
1. Em que momento exato o FormRequest é executado em relação ao controller?
2. Por que `authorize()` retornar `false` gera 403 e não 422?
3. Qual a diferença entre validação e autorização?
4. Por que o Service não deve receber o `Request`?
5. Quando **não** vale a pena criar um Service?
6. Como o Laravel injeta o `PostService` sem eu registrá-lo em lugar nenhum?

## Exercícios
- Recurso `Post` completo (migration, model, policy, 2 FormRequests, service, controller, rotas, testes), do zero e **sem copiar**
- Repetir com outro recurso (`Comment`) cronometrado, depois com outro, até ficar automático
- Adicionar uma regra de negócio que justifique um Service (ex.: publicar post → notificar seguidores em fila, tudo em transação)
- Escrever os 4 testes do fluxo: sucesso, 422, 403 (outro usuário), 401 (visitante)
- Trocar o Service por uma interface + binding e testar com um *fake*
