# Progresso da migração

Atualize ao terminar cada parte: troque `[ ]` por `[x]`, preencha a data (AAAA-MM-DD) e anote
o que ficou de fora. Tipo: **I** index · **V** view · **F** formulário · **R** relatório ·
**E** especial/element.

## Fase 0: fundação

| Feito | Arquivo | Data | Observações |
|---|---|---|---|
| [x] | `Element/head.ctp` (fonte + `ss-theme.css` + viewport) | 2026-10-24 | Sem html5shiv/respond; título usa só `$title` (já traz "Sales-System") |
| [x] | `Layout/default.ctp` (topbar, navbar, flash, main) | 2026-10-24 | Avisos, contador da sessão, menus por perfil e "Ver como" mantidos; sino único |
| [x] | `Element/menus/*.ctp` (dev, admin, sm, master, vip, cliente, associado): estado ativo | 2026-10-24 | Closure `$atual('Controller', 'Controller/acao')` em cada menu (em `associado.ctp`, `$ativo` continua sendo o cadastro pendente) |
| [x] | `Element/Flash/*.ctp` + `Element/msg-alert.ctp` | 2026-10-24 | `msg-alert` lê `getQuery('action')` em vez de `$_GET` |
| [x] | `Element/modal.ctp` | 2026-10-24 | |
| [x] | `Element/footer.ctp` | 2026-10-24 | Selo Make2 deixou de ser fixo; scripts na mesma ordem |
| [x] | `Element/paginator-footer.ctp` + `paginator-footer-jquery.ctp` | 2026-10-24 | `paginator-footer` ainda não é usado por nenhuma tela; o `-jquery` é só um comentário, ficou como estava |
| [x] | Helpers: `FaturasHelper`, `PedidosHelper` (`statusLabel`, `etapas`), `UsuariosHelper` | 2026-10-24 | Cancelado em cinza; `Faturas::statusLabel($status, $vencimento)` mostra "Vencida" (passar o vencimento em `invoice-table.ctp` na migração do Financeiro); `etapas()` gera `ss-steps`; `Usuarios::plano()` gera `ss-plan`. Textos de `status()` não mudaram |
| [x] | `Layout/layout-clean.ctp`, `Layout/error.ctp` | 2026-10-24 | `layout-clean`: `lang="pt-BR"` e conteúdo em `<main id="conteudo">`; o login não mudou. `error`: `ss-topbar` só com o logo, `ss-container--narrow ss-page` com um `ss-card` e rodapé `ss-footer` sem scripts. Tem o próprio `<head>` (Bootstrap, Font Awesome, Inter, `ss-theme.css`): o `ErrorController` padrão do Cake não passa pelo `AppController`, então não há `$title` nem os helpers do projeto. **Ao subir o `?v=` do tema em `head.ctp`, suba também aqui.** Saíram `base.css`/`cake.css` e o link "Back" |
| [x] | `Layout/relatorio.ctp` | 2026-10-24 | Migrado com os relatórios (ver abaixo). Saiu o `<style>` inline |

Verificado em 2026-10-24 no navegador em 1280px e 375px: perfis Dev e Super Master, menu ativo,
menu do usuário, contador, modais (senha, avisos), menu recolhido no celular, sem rolagem horizontal.

Ajustes no tema feitos na migração de Produtos (2026-10-24, `ss-theme.css?v=2` em `head.ctp`):
- **Rodapé do modal:** o jQuery ignora o `</div>` que fecha o corpo nos templates, então o
  `.modal-footer` fica dentro do `.modal-body`. Margens negativas (`.modal-body .modal-footer`)
  o levam às bordas, e no celular `.modal-content` passou a `overflow: visible` (com `hidden` o
  rodapé sticky não ficava preso embaixo). Vale para todos os modais.
- **DataTables em `ss-card--flush`:** "Mostrando N registros", info e paginação ganharam padding
  e divisória.

Ajustes no tema feitos na migração de Pedidos (2026-10-24, `ss-theme.css?v=3` em `head.ctp`):
- `.ss-grid-auto > .ss-card + .ss-card` sem `margin-top` (a regra `.ss-card + .ss-card`
  desalinhava o primeiro card da grade).
- `.ss-totals li.is-total:first-child` sem divisória quando o total é a única linha.

## Módulos

### Início e acesso

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Pages/home.ctp` | E | 2026-10-24 | Dashboard. Faixa `ss-banner` (pendente), "Olá, {primeiro nome}" + selo do plano. Gestão: 4 `a.ss-stat` (Pedidos aguardando, Saques a pagar, Faturas vencidas, Recebido no mês) + cards Acesso rápido e Relatórios em `ss-shortcut`, todos na primária. Associado: "Solicitar saque" vira a ação primária do cabeçalho; saldos viram 2 `a.ss-stat` (levam a Meu extrato); `ss-split` com Acesso rápido e Minhas metas (novo `ss-goals`/`ss-progress`, sem `style="width"`; estado vazio `ss-empty`). Cliente: só Acesso rápido. Textos com só a 1ª maiúscula; ícones `fa-btc`→`fa-money`, Taxas `fa-ticket`, Comissões `fa-handshake-o`, Metas `fa-bullseye`, Avisos `fa-bell-o`. Selo "Debug mode" virou `ss-note`. **Avisos recentes e resumo da rede ficaram de fora**: o controller não envia esses dados |
| [x] | `Pages/login.ctp` | E | 2026-10-24 | `ss-auth` com labels visíveis, sem ícones nos campos nem fundo; `#form_entrar`, `.focus` no login, `autocomplete` username/current-password, `required`. Manutenção (`$liberado_temporariamente`) mostra `ss-alert--warning` no lugar do form; `?admin` lido por `getQuery` (antes `$_GET` com `=` no lugar de `==`, mesmo efeito). Saiu o `login.css` (o arquivo não existe) e o bloco comentado de "recuperar senha" |
| [x] | `Pages/modal_content.ctp` | E | 2026-10-24 | Modelo de conteúdo de modal (nenhuma tela o abre). Labels visíveis com `ss-required`/`ss-optional`, tooltips viraram `help-block`, `.focus` no título. Os dois botões continuam só fechando o modal: "Gravar" → "Salvar", ambos `type=button` (antes `type=cancel`, inválido) e sem a classe `scroll-modal` |
| [x] | `Pages/list_backup.ctp`, `Pages/make_backup.ctp` | I/F | 2026-10-24 | **Telas órfãs:** não há action no `PagesController` (nem `download`/`delete`) e `display` exige permissão, então foram conferidas renderizando o template pela linha de comando com dados de exemplo e injetando o HTML no painel. Lista: `ss-layout` com `navbar-side-system`, 5 colunas (seleção, Arquivo em `ss-mono`, Criação, Tamanho `ss-num`, ações Baixar/Excluir em ícones); a coluna `#` saiu; "Excluir selecionados" no cabeçalho do card; `ss-empty` quando `$backups` não vem (antes dava aviso de variável indefinida). Os `postLink` usam `block` e saem depois do `Form->end()` (o truque do `postLink('')` vazio saiu). Ids `#select_all` e `listRecord_*` mantidos. Gerar backup (modal): seções Cadastros (checkboxes, mesmos `name`) e Formato do arquivo em `ss-choices` (`name="radio"`, ids `radio-csv`/`radio-sql`, CSV marcado). Saíram `well`, `width-*`, títulos em caixa alta |
| [x] | `Error/error400.ctp`, `Error/error500.ctp` | E | 2026-10-24 | Fora do debug: `ss-empty` com ícone, título, uma frase e "Voltar ao início". 4xx pelo `$code`: 404 "Página não encontrada" (`fa-compass`, mostra o endereço em `ss-mono`), 401/403 "Acesso negado" (`fa-lock`), demais "Não foi possível abrir a página". 500: "Algo deu errado" (`fa-exclamation-triangle`), sem a mensagem técnica. Em debug nada mudou (layout `dev_error`) |

Páginas de erro, modelo de modal, backups e login (layout `layout-clean`) verificados em 2026-10-24
no navegador em 1280px, perfil Dev: 404 com debug desligado (`DEBUG=false`), modal de modelo pelo
`#modal_item` (foco no título, rodapé), lista e modal de backup com o HTML renderizado. O 500 não
foi provocado (usa o mesmo layout do 404) e o 375px não foi conferido nessas telas.

Início e acesso verificado em 2026-10-24 no navegador (1280px; 375px num iframe), perfis Dev,
Master e Cliente: métricas, atalhos (abrir relatório em modal), metas, Solicitar saque, login,
sem rolagem horizontal. O envio do login não foi testado (não há credenciais de teste no projeto).
Tema em `ss-theme.css?v=7`: `.ss-split > .ss-card + .ss-card` sem `margin-top` (o segundo card
da coluna lateral ficava 16px abaixo do primeiro).

### Pedidos (`OrdersController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Orders/index.ctp` | I | 2026-10-24 | Pedidos da loja. `ss-layout` com `navbar-side-pedidos`. 7 colunas: tipo foi para a linha de apoio (só quando não é Normal), junto do selo do plano. Nome do associado abre o pedido; ações na linha: ação do status (Informar valores / Registrar envio / Entrega feita) + ícones Faturas, Associado e Cancelar envio (só em T). Sem menu "Mais ações": o `ss-table-wrap` cortaria o dropdown |
| [x] | `Orders/my_orders.ctp` | I | 2026-10-24 | Identificação = nomes dos produtos (associado, para a gestão), com forma de pagamento na linha de apoio; coluna "Forma Pgto" saiu. Estado vazio diferente com e sem filtro |
| [x] | `Orders/store.ctp` | E | 2026-10-24 | Novo componente `ss-product` em `ss-grid-auto` + coluna `ss-split` (Entrega/Dados da bonificação, Forma de pagamento em `nav-tabs`, Resumo). Abas com rótulos curtos (Cartão, Transferência, Boleto); `#ajax-retorno` foi para o Resumo, acima do botão. Ganchos do `CalculaTotal` mantidos |
| [x] | `Orders/view.ctp` | V | 2026-10-24 | Modal, igual ao modelo de `visualizacao.md`. Totais com Produtos, Frete, ICMS (se > 0) e Total; seção Entrega some quando cancelado; Observações só se houver |
| [x] | `Orders/delivery.ctp` | F | 2026-10-24 | Modal sm. Form passou a `type => file` (o campo da NF não era enviado sem `multipart`). Datas lado a lado |
| [x] | `Orders/values.ctp` | F | 2026-10-24 | Modal sm. Dados fixos em `ss-dl` no topo (sai o `alert-info`). "Gravar e Enviar Fatura" → "Salvar e enviar fatura" |
| [x] | `Orders/report.ctp` | F | 2026-10-24 | Só os textos de "todos" dos selects. O visual vem de `Element/report-form.ctp`, que fica para a migração dos relatórios |
| [x] | `Element/navbar-side-pedidos.ctp` | E | 2026-10-24 | `ss-subnav` de status: Todos, Aguardando a empresa (M), Aguardando pagamento, Concluídos, Cancelados. Antes não era usado por nenhuma tela e apontava para o controller `Pedidos`, que não existe; agora fica em `Orders/index` e mantém os outros filtros ao trocar o status |

Pedidos verificado em 2026-10-24 no navegador (1280px e 375px), perfis Dev e Cliente: filtro
lateral, filtros, modal do pedido, Informar valores, Registrar envio (salvar), loja (cálculo do
total, aviso sem quantidade, troca de aba de pagamento, finalizar), Meus pedidos, sem rolagem
horizontal. `PedidosHelper::total()` mostra "Em cálculo" (em `ss-muted`) no lugar do antigo
"Aguardando / Frete+Impostos".

### Financeiro (`InvoicesController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Invoices/index.ctp` | I | 2026-10-24 | Extrato geral. `ss-layout` com `navbar-side-faturas` (tipo), métricas, `ss-segmented` de status acima do card. Tipo e status saíram do formulário de busca (vão como campos ocultos para não se perderem); com 6 campos, a busca usa labels visíveis. Título em minúsculas ("Solicitações de saque", "Extrato geral"). Regra dos 30 dias em `ss-help` abaixo do card |
| [x] | `Invoices/statement.ctp` | I | 2026-10-24 | Associado: "Solicitar saque" vira a ação primária do cabeçalho (`fa-money`) e os saldos viram 2 `ss-stat` (Disponível, Bloqueado). Gestão: `invoice-summary`. Regra do saldo em `ss-note`. Cliente (plano 6) sem saldos nem botão, como antes |
| [x] | `Invoices/view.ctp` | V | 2026-10-24 | Modal sm. `ss-record-header` + seções Valores, Referência e Observações. Boleto emitido vira `ss-alert`. Badge pelo novo `Faturas::situacao()`: a fatura paga mostra "Finalizado" (antes "Paga"/"Liberada") |
| [x] | `Invoices/withdraw.ctp` | F | 2026-10-24 | Modal sm. Saldos em `ss-dl`, aviso `ss-alert--warning` quando o disponível < R$ 50 (o botão continua desabilitado), conta de depósito em `ss-dl`. Gestão ganhou `.modal-footer` (Fechar + Ver solicitações de saque). "Cancelar" `type=button` |
| [x] | `Invoices/bank_details.ctp` | V | 2026-10-24 | Modal sm. Valor em `ss-totals`, dados bancários em `ss-dl` com `ss-mono`, e-mail do financeiro virou link `mailto` |
| [x] | `Invoices/report.ctp`, `payments_report.ctp`, `balances_report.ctp` | F | 2026-10-24 | Só os textos de "todos" dos selects (como em Pedidos). O visual vem de `Element/report-form.ctp` |
| [x] | `Element/invoice-summary.ctp` | E | 2026-10-24 | `ss-grid-stats` com 4 `a.ss-stat` (Faturas listadas, Pendentes, Finalizadas, Canceladas); cada uma filtra a lista pelo status mantendo os demais filtros |
| [x] | `Element/invoice-table.ctp` | E | 2026-10-24 | De 11 para 7 colunas: Código, Associado/Fatura, Pagamento, Vencimento, Valor, Status, ações. Tipo, comissão e referência (Origem #… para comissões, Pedido #… para as demais) foram para a linha de apoio; a data de cadastro saiu (está na view). Nome/tipo abre a fatura; "Visualizar" saiu. Ações: Baixar/Pagar saque (ghost) + ícones Associado e Cancelar (gestão), ou "Pagar agora" (associado). Créditos/débitos com `ss-pos`/`ss-neg` e sinal. Estado vazio `ss-empty` |
| [x] | `Element/navbar-side-faturas.ctp` | E | 2026-10-24 | `ss-subnav` de tipo: Todas, Saques, Taxas de inscrição, Pedidos, Comissões. Antes não era usado e apontava para o controller `Faturas`, que não existe; agora fica em `Invoices/index` e mantém os outros filtros ao trocar o tipo |

Financeiro verificado em 2026-10-24 no navegador (1280px e 375px), perfis Dev, Master e Cliente:
navegação por tipo, filtro de status, métricas, busca, estado vazio, modal da fatura, saque
(associado e gestão), dados para pagamento, Meu extrato, Extrato da empresa, sem rolagem
horizontal. Novo `FaturasHelper::situacao($fatura)`: "Em cálculo" (pedido em V), "Bloqueada"
(comissão pendente) ou `statusLabel($status, $vencimento)`, que já mostra "Vencida".

### Avisos (`NoticesController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Notices/index.ctp` | I | 2026-10-24 | `ss-layout` com `navbar-side-avisos`. 7 colunas: Código, Aviso (título abre a view; trecho da mensagem e ícone de imagem na linha de apoio), Destino (selo do plano ou "Todos"), Enviado, Validade ("Sem validade" em `ss-muted`), Status, ações (Editar e Excluir em ícones; "Visualizar" saiu). Destino saiu da busca (vai como campo oculto). Status "Vencido" (vermelho) virou "Encerrado" (cinza), pelo mapa. **A lista passa a abrir ordenada pelo código** (antes pela data de cadastro). Estado vazio diferente com e sem filtro |
| [x] | `Notices/form.ctp` | F | 2026-10-24 | Modal lg. Seções Mensagem, Envio, Mídia. Validade com calendário e ajuda "Em branco, o aviso não vence."; imagem e vídeo opcionais; imagem atual aparece na edição; o vídeo agora vem preenchido na edição. "Gravar"/"Enviar Aviso" → Salvar/Enviar aviso; Cancelar `type=button`; Excluir no rodapé (`postLink` com `block`) |
| [x] | `Notices/view.ctp` | V | 2026-10-24 | Modal. `ss-record-header` (título, status, código, data e hora); Mensagem (`ss-richtext` + `ss-figure`, link do YouTube se houver) à esquerda; Envio em `ss-dl` à direita. Saem os três `alert-info` |
| [x] | `Notices/pending.ctp` | E | 2026-10-24 | `ss-messages` com `is-unread`; texto em `ss-richtext`; "Descartar aviso" → "Marcar como lido" (mesmo efeito, só na tela); `ss-empty` quando não há avisos ou todos foram lidos |
| [x] | `Element/navbar-side-avisos.ctp` | E | 2026-10-24 | `ss-subnav` de destino: Todos os avisos, Para todos e um item por plano (SM, Master, VIP). Antes não era usado e apontava para o controller `Avisos`, que não existe; agora fica em `Notices/index` e mantém os outros filtros ao trocar o destino. Relógio removido |

Avisos verificado em 2026-10-24 no navegador (1280px e 375px), perfil Dev: filtro por destino,
busca, modal do aviso, edição (salvar), sino (marcar como lido até o estado vazio), sem rolagem
horizontal. Novo `AvisosHelper` (`situacao`, `statusLabel`, `destino`, `resumo`). Novas classes
`ss-richtext` e `ss-figure` (seção 16). Tema em `ss-theme.css?v=5`. O 375px foi conferido num
iframe (a janela do Chrome não redimensionou).

### Associados e rede (`UsersController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Users/index.ctp` | I | 2026-10-24 | Sistema > Usuários. `ss-layout` com `navbar-side-system` (Users saiu de `$legado`). De 9 para 7 colunas: Código, Usuário (avatar + nome, login · cidade/UF na linha de apoio), Plano, Patrocinador, Cadastro, Status, ações. Foto virou `ss-avatar--sm`; "Último acesso" foi para o cabeçalho da edição e para a view. Nome abre a edição; ações em ícones: Editar, Mudar plano (SM/Master/VIP) e Excluir (confirmação nova). Busca com "Todos os planos/status". **A lista passa a abrir ordenada pelo código** (antes pela data de cadastro), como as demais telas |
| [x] | `Users/view.ctp` | V | 2026-10-24 | Modal (aberto por Pedidos e Financeiro). `ss-record-header` com avatar, status e plano; seções Documento, Contato (e-mail com `mailto`), Endereço à esquerda; Rede, Saldos (só SM/Master/VIP) e Acesso à direita. Sem caixas `bg-primary/info/warning` |
| [x] | `Users/add.ctp` | F | 2026-10-24 | Modal lg. Aviso da taxa virou `ss-alert` no topo. Plano em `ss-choices` (com a taxa ou "Sem taxa de inscrição"; o 1º vem marcado, como o select antigo). Patrocinador: select para a gestão, `ss-dl` para o associado. Obrigatórios com `ss-required`, opcionais marcados. Ids dos radios: `planos_id_{id}` (o `name` continua `planos_id`) |
| [x] | `Users/profile.ctp` | F | 2026-10-24 | Serve também `edit` (gestão). `ss-record-header` (status e último acesso só na edição); CPF/CNPJ e patrocinador saíram do campo somente leitura para `ss-dl`. "Gravar" → "Salvar"; Cancelar `type=button` |
| [x] | `Users/password.ctp` | F | 2026-10-24 | Modal sm. Regra da senha virou `help-block` da nova senha; `autocomplete` current/new-password. "Alterar Senha" → "Alterar senha" |
| [x] | `Users/bank.ctp` | F | 2026-10-24 | Modal sm. Titular e CPF/CNPJ em `ss-dl` no topo; PIX opcional; regra do CPF em `ss-help` |
| [x] | `Users/change_plan.ctp` | F | 2026-10-24 | Modal sm. Associado e plano atual em `ss-dl`; planos em `ss-choices` com a taxa e "Plano atual" no card marcado |
| [x] | `Users/network.ctp` + `Element/network-node.ctp` | E | 2026-10-24 | Novos estilos `ss-net-node` (seção 17). Alerta com `ss-count`; estado vazio quando a rede não tem ninguém. Nó com indicados é botão com `aria-expanded` (borda tracejada quando fechado); nó sem indicados não é mais clicável. Pendente em amarelo (antes vermelho, fora do mapa de status). Saiu a classe `user-profile` do contêiner |
| [x] | `Users/report.ctp`, `Users/clients_report.ctp` | F | 2026-10-24 | Só os textos de "todos" dos selects. O visual vem de `Element/report-form.ctp` |

Associados e rede verificado em 2026-10-24 no navegador (1280px e 375px), perfil Dev: lista,
filtros, modal de edição, Mudar plano (salvar), Dados do associado (a partir de Pedidos), Minha
rede (abrir/fechar nós) e Novo usuário, sem rolagem horizontal. Uma extensão de senhas do Chrome
bloqueia capturas de tela com campo de senha aberto: Novo usuário foi conferido com o campo trocado
para texto; Alterar senha, Dados bancários e Meus dados só foram conferidos pela resposta do servidor
(sem erro), sem captura. Tema em `ss-theme.css?v=4`.

### Sistema

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Element/navbar-side-system.ctp` | E | 2026-10-24 | `ss-subnav`. Ícones: Metas `fa-bullseye`, Produtos `fa-cube`. A lista `$legado` e a barra antiga (`.sidebar` + `list-group`) foram apagadas com a migração dos backups (Pages era o último). Backups não ganhou item no menu: não há action para a lista |
| [x] | `Products/index.ctp` | I | 2026-10-24 | Novo `ProdutosHelper` (`statusLista`, `statusLabel($status, $loja)`). Ações: editar + excluir (ícones). Marca de comissões vai na linha de apoio + legenda `ss-note`. Coluna de ações sem ordenação (`data-orderable="false"`) |
| [x] | `Products/view.ctp` | V | 2026-10-24 | Modal (aberto a partir de Planos). Usa os textos da loja (Disponível / Fora de linha) |
| [x] | `Products/form.ctp` | F | 2026-10-24 | Seções Identificação, Venda, Imagem. "Gravar" → Salvar/Cadastrar; Cancelar `type=button`; Excluir no rodapé (`postLink` com `block`). Sem `Form->error()`: o form usa `create(null)` e não há erro de campo para mostrar |
| [x] | `Regions/index.ctp` | I | 2026-10-24 | 7 colunas: Código, Região (UF · N cidades na linha de apoio), Cidades, Exclusividade (associado responsável + selo do plano, ou "Aberta a todos" em `ss-muted`), Cadastro (`ss-hide-xs`), Atualização, ações (Editar e Excluir em ícones). Regra da exclusividade em `ss-note`. **A busca passou a filtrar** (região, UF ou cidade; antes o campo era ignorado). Estado vazio com e sem filtro |
| [x] | `Regions/form.ctp` (substitui `add.ctp` e `edit.ctp`) | F | 2026-10-24 | Modal. Na edição, código e responsável em `ss-dl` no topo. Seções Identificação e Cidades; o tooltip da exclusividade virou `help-block`. Cidades da região no novo `ss-chips` (remover funciona pelo `data-dismiss="alert"` do Bootstrap). País/Estado/Cidade e `#btn_add_cidade` continuam sem JS (já não funcionavam), com as mesmas opções de exemplo. Ids `#states`, `#cities`, `#lista_cidades` mantidos |
| [x] | `GoalPlans/index.ctp` | I | 2026-10-24 | Lista em cards (`ss-grid-auto`), como `listagem.md` sugere para planos: título, código, selo do plano, `ss-dl--grid` com Taxa de inscrição, Bonificação (qtd × produto, abre o produto em modal), Meta mínima de vendas (sempre —, o dado não existe) e Cadastro; rodapé com Editar e Excluir. Dev e Admin continuam fora |
| [x] | `GoalPlans/form.ctp` (substitui `add.ctp` e `edit.ctp`) | F | 2026-10-24 | Modal. Seções Plano e Bonificação pela inscrição; tooltips viraram `help-block`. Produtos reais no select (antes "opção 1..4"). O campo da meta continua `salesGoals` na inclusão e `saleGoals` na edição (nomes antigos mantidos). Saiu o `onkeyup` (o campo é `number` com `min`) |
| [x] | `SaleGoals/index.ctp` | I | 2026-10-24 | A frase única virou colunas: Código, Meta ("Indicar 10 novos VIP" / "Comprar 50 × produto", tipo com ícone na linha de apoio), Plano (selo), Prêmio, Cadastro, ações. Legenda de ícones removida (o tipo está escrito). Corrigida a `</div>` que faltava no fim do template |
| [x] | `SaleGoals/form.ctp` (substitui `add.ctp` e `edit.ctp`) | F | 2026-10-24 | Modal. Tipo em `ss-choices` (ids `tipo-i`/`tipo-v`, `name` `tipo`). Seções Plano e meta, Prêmio. **`#tipo_indicacao`/`#tipo_venda` agora alternam** com o tipo (script curto no template; antes "Vendas de" nunca aparecia). Nomes antigos mantidos: `benefit_products_id`/`howmuch` na inclusão, `benefits_products_id`/`qtganha` na edição. Planos e produtos reais nos selects |
| [x] | `SaleGoals/report.ctp` | F | 2026-10-24 | Só o texto de "todos" do select |
| [x] | `SaleCommissions/index.ctp` | I | 2026-10-24 | Busca em `ss-filters` com opções vazias por extenso ("Recebe: todos os planos", "Paga: todos os planos", "Todos os tipos"). Colunas: Código, Comissão (tipo; origem com ícone na linha de apoio: `fa-ticket` taxa, `fa-shopping-cart` pedidos), Percentual, Quem recebe ("N níveis acima de quem pagou"), Cadastro, ações. Legenda de 7 ícones trocada por `ss-note` explicando os níveis. **O filtro de tipo passou a funcionar**; valor e planos continuam sem efeito (as regras de exemplo não têm esses campos) |
| [x] | `SaleCommissions/form.ctp` (substitui `add.ctp` e `edit.ctp`) | F | 2026-10-24 | Modal. Na edição, código e "Regra atual" em `ss-dl`. Seções Planos e Comissão; tooltips viraram `help-block`; Multinível vem marcado para IM/VM. **O formulário pede valor em R$, mas as regras são em %**: na edição o valor vem vazio (antes R$ 1.234,56 fixo). Resolver quando o banco voltar |
| [x] | `SaleCommissions/report.ctp` | F | 2026-10-24 | Só os textos de "todos" dos selects |

Regiões, Planos, Metas e Comissões verificados em 2026-10-24 no navegador (1280px; 375px num iframe),
perfil Dev: listas, busca de regiões e filtro de tipo das comissões, modais de edição (regra, meta
de venda com troca de tipo, região com remoção de cidade), cadastrar região (flash), sem rolagem
horizontal. Excluir não foi clicado (abre `confirm`). Controllers: `add`/`edit` renderizam o `form`
com o registro de demonstração e as listas de planos/produtos; mensagens de flash específicas
("Região cadastrada." etc.). O botão salvar perdeu a classe `scroll-modal`, cujo JS chamava
`preventDefault()` no clique e impedia o envio. Tema em `ss-theme.css?v=8`:
- `ss-chips`/`ss-chip` (seção 7).
- Cards em `ss-grid-auto` com a mesma altura e rodapé embaixo.
- `.ss-table--stack.dataTable { width: 100% !important }` no celular: com uma coluna `ss-hide-xs`,
  o DataTables gravava `width: 0px` na tabela e o card ficava espremido.

Sistema > Produtos verificado em 2026-10-24 no navegador (1280px e 375px): subnav, filtros,
estado vazio, modal de edição e de inclusão (foco no nome), salvar, cadastrar, excluir pela
linha e pelo rodapé do modal (mensagem de confirmação nova), view em modal a partir de Planos,
Planos ainda com a barra antiga, sem rolagem horizontal.

### Relatórios (`ReportsController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Layout/relatorio.ctp` | E | 2026-10-24 | `ss-report-page` + `ss-container ss-page` com a folha `article.ss-report`; barra do bloco `report-toolbar` acima da folha; rodapé `hidden-print`. `Highcharts.setOptions` lê os tokens com a nova função `ssCor()` (cores, fonte, eixos, legenda), sem título interno nem créditos, `.`/`,` nos números e textos de exportação em português (corrigidos "Feb"/"Maio" dos meses curtos) |
| [x] | `Element/report-header.ctp`, `Element/report-form.ctp` | E | 2026-10-24 | Header: barra "Gerado por {nome} ({login}) · {plano} · em {data}" + Imprimir (`hidden-print`, via `$this->start('report-toolbar')`); cabeçalho da folha com logo 36px, título, "Período: X a Y" e **"Emitido em" novo, que sai na impressão**. Form: seções Período (De/Até) e Filtros (`ss-form-section`), datas com `autocomplete=off`; `ss-help` da nova aba; Cancelar `type=button` (era `reset`); "Gerar Relatório" → "Gerar relatório" com ícone. Ids, `name`s, `target=_blank`, `.datepicker .datemask` mantidos |
| [x] | `Reports/orders.ctp` | R | 2026-10-24 | Resumo por status (na ordem do fluxo, badges) + rosca; lista de 7 colunas: plano e tipo (se não Normal) na linha de apoio do associado; frete zerado vira —; `<tfoot>` com total do frete e do valor |
| [x] | `Reports/invoices.ctp` | R | 2026-10-24 | Resumo por tipo ganhou linha de total. Lista de 10 para 7 colunas: tipo e data de cadastro na linha de apoio, parcela abaixo da forma de pagamento; status por `Faturas::situacao()` (passa a mostrar Vencida, Em cálculo, Bloqueada) |
| [x] | `Reports/goals.ctp` | R | 2026-10-24 | Frase única dividida em Meta (com ícone do tipo) e Prêmio; barra `progress-bar` com `style` virou `ss-progress` em `ss-report-progress` (verde ao atingir); título com a contagem de metas atingidas |
| [x] | `Reports/commissions.ctp` | R | 2026-10-24 | Resumo + rosca (tooltip em R$ 1.234,56). Lista de 10 para 7 colunas: plano sob o beneficiário, percentual sob o tipo, fatura de origem sob o associado de origem. Novo `ComissoesHelper::statusLabel()` (Liberada verde / Bloqueada azul, como `situacao()`) |
| [x] | `Reports/associates.ctp` | R | 2026-10-24 | Resumo por plano ganhou linha de total; lista com Código, login sob o nome, status por `Usuarios::statusLabel()`, telefone vazio vira — |
| [x] | `Reports/clients.ctp` | R | 2026-10-24 | Cidade/UF e "desde" sob o nome, e-mail sob o telefone; `<tfoot>` com total de pedidos e do valor |
| [x] | `Reports/payments.ctp` | R | 2026-10-24 | Os três `panel` viraram `ss-stat` (Pagos, Aguardando pagamento, Cancelados, com a quantidade). Novo `FaturasHelper::saqueLabel()` (Pago / Aguardando pagamento / Cancelado). Agência e conta em `ss-mono`; `<tfoot>` com o valor total |
| [x] | `Reports/balances.ctp` | R | 2026-10-24 | Totais também em 3 `ss-stat` no topo; coluna Código; `<tfoot>` |
| [x] | `Reports/registrations.ctp` | R | 2026-10-24 | Colunas empilhadas com a cor de cada plano (`--ss-plan-*`); `<tfoot>` com o total por plano (antes só das taxas) |
| [x] | `Reports/taxes.ctp` | R | 2026-10-24 | Aviso de referência em `ss-note`; alíquota pelo `toPercentage`; "Não" em `ss-muted` |

Relatórios verificados em 2026-10-24 no navegador (1280px; 375px num iframe), perfil Dev: os 10
relatórios com e sem resultado (estado vazio), gráficos (rosca, colunas por plano), modal de filtros
a partir de Pedidos (calendário, envio por GET para nova aba), sem rolagem horizontal da página (no
celular as tabelas rolam dentro da caixa, como pede o guia). **A impressão não foi conferida numa
impressora/PDF**: as regras `@media print` da seção 19 só foram revisadas no código. Mudanças comuns:
- Sem a coluna de numeração (1, 2, 3...): a contagem vai no `ss-count` ao lado do título da seção.
- Datas em `dd/mm/aaaa` (`->format('d/m/Y')`); `MyHtml->date()` mostra "Hoje"/"22 de Outubro de 2026".
- Títulos com só a 1ª maiúscula ("Relatório de pedidos").
- Os títulos dos modais ("Relatório de Pedidos", no `data-title` dos botões de cada módulo) ficaram
  como estavam.
Tema em `ss-theme.css?v=9`: nova seção 19 (Relatórios).

### E-mail

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Layout/Email/html/default.ctp`, `Email/html/default.ctp` | E | 2026-10-24 | Tabelas de 600px com CSS inline (exceção à regra), valores dos tokens anotados no topo do layout: fundo `--ss-bg`, card branco com borda e raio 10px, logo, rodapé "© ano Sales-System · Acessar o painel". Parágrafos com margem inline; o conteúdo continua sem `h()`, como no template padrão do Cake. Nenhum código envia e-mail ainda: conferido só renderizando pela linha de comando. Links e logo usam URL completa (`Url->build(..., true)`); em envio pelo shell, configure `App.fullBaseUrl`. Os templates `text` não mudaram |

## Ordem sugerida

1. Fase 0.
2. Sistema > Produtos (serve de modelo para os demais cadastros).
3. Pedidos e Financeiro (telas mais usadas).
4. Associados e rede, Avisos.
5. Dashboard e login.
6. Demais cadastros do Sistema, relatórios, e-mail.

## Componentes criados durante a migração

| Data | Componente | Seção do CSS | Motivo |
|---|---|---|---|
| 2026-10-24 | `ss-product` (card de produto da loja) | 17. Peças do domínio | Loja precisava de imagem, preço, quantidade e subtotal por produto; nenhum card existente tinha campo de quantidade |
| 2026-10-24 | `ss-net-node` (pessoa na árvore da rede) | 17. Peças do domínio | O nó antigo empilhava itens com `clearfix` e `style`; precisava de avatar, nome, login, plano, status e contagem num card só, e de um estado sem clique para quem não tem indicados |
| 2026-10-24 | `ss-goals` / `ss-progress` (metas com barra de progresso) | 17. Peças do domínio | A barra do Bootstrap precisa de `style="width"`; o `<progress>` nativo recebe o valor sem estilo inline |
| 2026-10-24 | `ss-chips` / `ss-chip` (itens removíveis) | 7. Badges e selos | Cidades da região: o antigo `alert alert-info pull-left` com × não removia nada; precisava de item compacto com campo oculto e botão de remover |
| 2026-10-24 | `ss-report` (folha, cabeçalho, seções, resumo, gráfico, progresso) | 19. Relatórios | Os relatórios usavam `container`, `panel`, `bg-gray`, `font-*` e `style`; precisavam de folha para A4 com cabeçalho impresso, tabela + gráfico lado a lado e regras de impressão próprias |
| 2026-10-24 | `ss-richtext` e `ss-figure` (texto com HTML e imagem do aviso) | 16. Mensagens, avisos e estado vazio | A mensagem do aviso vem com `<p>`/`<strong>`: `ss-message-text` usa `pre-line` e é um `<p>`, o que quebrava o espaçamento; a imagem precisava de borda e raio dos tokens |
