# Sales-System

Painel de gestão de vendas, comissões e metas da rede **Reiniciando**, feito em **CakePHP 3.4**.

Produção: <http://reiniciando.com.br/Sales-System/>

> **Estado atual:** demonstração funcional, sem banco de dados. Todas as telas dos 6 perfis
> funcionam com **dados simulados** gerados por `src/Lib/DemoData.php`: uma rede de 35 usuários,
> cerca de 80 pedidos e 270 faturas (taxas, pedidos, comissões e saques) coerentes entre si, com
> datas relativas ao dia atual. Formulários e ações (salvar, baixar, cancelar, excluir) apenas
> simulam a gravação e exibem uma mensagem "(demonstração: nenhum dado foi alterado)".

## Módulos

| Controller | Telas |
|---|---|
| `OrdersController` | Loja, Meus Pedidos, Pedidos da Loja, detalhes, envio, frete e impostos |
| `InvoicesController` | Extrato Geral, Saques, Taxas, Faturas de Pedidos e de Comissões, Meu Extrato, Solicitar Saque |
| `NoticesController` | Avisos (gestão) e o sino de avisos pendentes do cabeçalho |
| `UsersController` | Minha Rede, Cadastrar Associado, Meus Dados, senha, dados bancários, Sistema > Usuários |
| `ProductsController` | Sistema > Produtos |
| `ReportsController` | Relatórios para impressão: pedidos, faturas, metas, comissões, associados, clientes, pagamentos, saldos, cadastros e impostos |

Para ligar ao banco no futuro, troque as chamadas a `DemoData` nos controllers por consultas ao ORM;
os campos das entidades seguem o esquema do projeto de origem (`mineralli.sql`).

---

## Requisitos

| Item | Versão / observação |
|---|---|
| PHP | 7.4 (testado). Funciona em PHP 8 graças às correções em `vendor/` |
| Extensões PHP | `intl`, `mbstring`, `openssl`, `pdo_mysql`, `simplexml` |
| Servidor web | Apache com `mod_rewrite` e `AllowOverride All`. Ex.: XAMPP, Laragon, WAMP |
| MySQL | 5.6+ (opcional por enquanto, veja [Banco de dados](#banco-de-dados)) |

Para conferir as extensões instaladas: `php -m`

---

## Instalação local

### 1. Clone o projeto dentro da pasta do servidor web

```bash
# Exemplo com XAMPP
cd C:/xampp/htdocs
git clone <url-do-repositorio> Sales-System
```

**Não precisa rodar `composer install`.** A pasta `vendor/` já vem no repositório
(veja [Por que o vendor/ está no Git](#por-que-o-vendor-está-no-git)).

### 2. Crie o arquivo de configuração

O `config/app.php` não fica no Git porque guarda o salt e as senhas. Crie o seu a partir do exemplo:

```bash
cp config/app.default.php config/app.php
```

Gere um salt aleatório:

```bash
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Abra o `config/app.php`, procure `__SALT__` e troque pelo valor gerado.

Os pontos que você pode precisar ajustar estão marcados com **`[AJUSTE]`** no arquivo:

| # | Chave | O que colocar |
|---|---|---|
| 1 | `debug` | `true` em desenvolvimento, `false` em produção |
| 2 | `Security.salt` | O valor gerado acima. Único por instalação; nunca publique |
| 3 | `EmailTransport` / `Email` | Servidor SMTP e remetente. Só se for enviar e-mail |
| 4 | `Datasources.default` | Host, usuário, senha e nome do banco MySQL |

Esses valores também podem vir de variáveis de ambiente: `DEBUG`, `SECURITY_SALT`,
`DATABASE_URL` e `EMAIL_TRANSPORT_DEFAULT_URL`.

### 3. Permissões de escrita

O servidor web precisa gravar em `tmp/` e `logs/`. No Windows normalmente já funciona.
No Linux:

```bash
chmod -R 775 tmp logs
chown -R www-data:www-data tmp logs   # ajuste o usuário do Apache
```

### 4. Acesse

Abra no navegador o endereço da pasta, por exemplo:

```
http://localhost/Sales-System/
```

O `.htaccess` da raiz encaminha tudo para `webroot/`, então não é preciso apontar o
Apache para a pasta `webroot`.

**Alternativa sem Apache**, usando o servidor embutido do CakePHP:

```bash
php bin/cake.php server
# abre em http://localhost:8765
```

---

## Banco de dados

Hoje **o sistema abre sem banco configurado**: as consultas estão comentadas nos controllers
(`src/Controller/*Controller.php`), que enviam listas vazias para as telas.

Quando as consultas forem reativadas, o banco precisará das tabelas usadas pelos models:

| Tabela | Model |
|---|---|
| `regions` | `RegionsTable` |
| `goal_plans` | `GoalPlansTable` |
| `sale_goals` | `SaleGoalsTable` |
| `sale_commissions` | `SaleCommissionsController` (model ainda não criado) |
| `usuarios` | Login (`Auth` em `AppController`) |

O repositório ainda não tem o script de criação dessas tabelas. `config/schema/` contém apenas
os SQLs padrão do CakePHP (sessões e i18n).

---

## Tipos de acesso (perfis)

O painel muda conforme o perfil. Na barra do menu, o seletor **"Ver como"** troca o perfil
da sessão atual para testes:

| ID | Perfil | Nome exibido |
|---|---|---|
| 1 | `Dev` | Desenvolvedor |
| 2 | `Admin` | Administrador |
| 3 | `SM` | Super Master |
| 4 | `Master` | Master |
| 5 | `VIP` | VIP |
| 6 | `Cliente` | Cliente |

Os IDs ficam em `config/bootstrap.php`. Os nomes ficam em `AppController::planos()`.
Os menus de cada perfil ficam em `src/Template/Element/menus/`.

---

## Estrutura

```
config/
  app.default.php     Exemplo de configuração (versionado)
  app.php             Sua configuração local (NÃO versionado)
  bootstrap.php       Inicialização e IDs dos perfis
  routes.php          Rotas (/, /login, /logout + rotas padrão)
src/
  Controller/         Pages, Orders, Invoices, Notices, Users, Products, Reports e Sistema
  Lib/DemoData.php    Dados simulados usados enquanto não há banco
  Model/Table/        Models do ORM
  Template/           Views (.ctp). Layout principal: Template/Layout/default.ctp
webroot/              Arquivos públicos (css, js, img, fontes)
vendor/               Dependências (com correções para PHP 7.4/8)
tmp/, logs/           Cache, sessões e logs (conteúdo ignorado pelo Git)
```

---

## Por que o vendor/ está no Git

O projeto usa CakePHP 3.4, anterior ao PHP 8. Alguns arquivos em `vendor/cakephp/cakephp/`
foram corrigidos à mão, principalmente para trocar a sintaxe `$texto{0}`, removida no PHP 8,
por `$texto[0]`.

Rodar `composer install` ou `composer update` **reinstalaria o CakePHP original e desfaria
essas correções**. Se precisar mexer nas dependências, confira depois com `git diff vendor/`
e reaplique as correções.

---

## Produção

Antes de publicar:

1. `debug` igual a `false` no `config/app.php`.
2. Um **salt próprio do servidor**, diferente do usado em desenvolvimento.
3. Permissão de escrita em `tmp/` e `logs/` para o usuário do Apache.
4. Se o servidor usar PHP-FPM e alguma pasta estática der 404, confira se o `.htaccess` tem
   `DirectoryIndex index.html index.php`.

---

## Problemas comuns

| Sintoma | Causa provável |
|---|---|
| Página em branco ou erro de `config/app.php` | O arquivo não foi criado. Veja o passo 2 da instalação |
| Erro 404 em todas as páginas menos a inicial | `mod_rewrite` desligado ou `AllowOverride None` no Apache |
| "Warning: session_start(): headers already sent" | Avisos de depreciação do PHP. Já são ocultados em `webroot/index.php` e no `errorLevel` do `app.php` |
| Erro de permissão ao gravar cache ou sessão | `tmp/` e `logs/` sem permissão de escrita |
| `composer` falha com "Unknown package has no name defined" | O `composer.phar` do projeto é antigo (1.x). Não é necessário para rodar o sistema |
