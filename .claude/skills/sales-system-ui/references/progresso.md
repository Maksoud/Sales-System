# Progresso da migração

Atualize ao terminar cada parte: troque `[ ]` por `[x]`, preencha a data (AAAA-MM-DD) e anote
o que ficou de fora. Tipo: **I** index · **V** view · **F** formulário · **R** relatório ·
**E** especial/element.

## Fase 0: fundação

| Feito | Arquivo | Data | Observações |
|---|---|---|---|
| [x] | `Element/head.ctp` (fonte + `ss-theme.css` + viewport) | 2026-10-24 | Sem html5shiv/respond; título usa só `$title` (já traz "Reiniciando") |
| [x] | `Layout/default.ctp` (topbar, navbar, flash, main) | 2026-10-24 | Avisos, contador da sessão, menus por perfil e "Ver como" mantidos; sino único |
| [x] | `Element/menus/*.ctp` (dev, admin, sm, master, vip, cliente, associado): estado ativo | 2026-10-24 | Closure `$atual('Controller', 'Controller/acao')` em cada menu (em `associado.ctp`, `$ativo` continua sendo o cadastro pendente) |
| [x] | `Element/Flash/*.ctp` + `Element/msg-alert.ctp` | 2026-10-24 | `msg-alert` lê `getQuery('action')` em vez de `$_GET` |
| [x] | `Element/modal.ctp` | 2026-10-24 | |
| [x] | `Element/footer.ctp` | 2026-10-24 | Selo Make2 deixou de ser fixo; scripts na mesma ordem |
| [x] | `Element/paginator-footer.ctp` + `paginator-footer-jquery.ctp` | 2026-10-24 | `paginator-footer` ainda não é usado por nenhuma tela; o `-jquery` é só um comentário, ficou como estava |
| [x] | Helpers: `FaturasHelper`, `PedidosHelper` (`statusLabel`, `etapas`), `UsuariosHelper` | 2026-10-24 | Cancelado em cinza; `Faturas::statusLabel($status, $vencimento)` mostra "Vencida" (passar o vencimento em `invoice-table.ctp` na migração do Financeiro); `etapas()` gera `ss-steps`; `Usuarios::plano()` gera `ss-plan`. Textos de `status()` não mudaram |
| [ ] | `Layout/layout-clean.ctp`, `Layout/error.ctp`, `Layout/relatorio.ctp` | | `layout-clean` só ganhou `class="ss-footer"` no `<footer>` (usa o mesmo footer). Restante fica para login, erros e relatórios |

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
| [ ] | `Pages/home.ctp` | E | | Dashboard |
| [ ] | `Pages/login.ctp` | E | | |
| [ ] | `Pages/modal_content.ctp` | E | | |
| [ ] | `Pages/list_backup.ctp`, `Pages/make_backup.ctp` | I/E | | |
| [ ] | `Error/error400.ctp`, `Error/error500.ctp` | E | | |

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
| [ ] | `Invoices/index.ctp` | I | | Extrato geral, saques, taxas, faturas |
| [ ] | `Invoices/statement.ctp` | I | | Meu extrato |
| [ ] | `Invoices/view.ctp` | V | | |
| [ ] | `Invoices/withdraw.ctp` | F | | Solicitar saque (modal sm) |
| [ ] | `Invoices/bank_details.ctp` | V | | |
| [ ] | `Invoices/report.ctp`, `payments_report.ctp`, `balances_report.ctp` | F | | |
| [ ] | `Element/invoice-summary.ctp` | E | | Vira `ss-grid-stats` |
| [ ] | `Element/invoice-table.ctp` | E | | |
| [ ] | `Element/navbar-side-faturas.ctp` | E | | |

### Avisos (`NoticesController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [ ] | `Notices/index.ctp` | I | | |
| [ ] | `Notices/form.ctp` | F | | |
| [ ] | `Notices/view.ctp` | V | | |
| [ ] | `Notices/pending.ctp` | E | | Sino do cabeçalho, `ss-messages` |
| [ ] | `Element/navbar-side-avisos.ctp` | E | | |

### Associados e rede (`UsersController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [ ] | `Users/index.ctp` | I | | Sistema > Usuários |
| [ ] | `Users/view.ctp` | V | | |
| [ ] | `Users/add.ctp` | F | | Cadastrar associado |
| [ ] | `Users/profile.ctp` | F | | Meus dados |
| [ ] | `Users/password.ctp` | F | | Modal sm |
| [ ] | `Users/bank.ctp` | F | | Modal sm |
| [ ] | `Users/change_plan.ctp` | F | | `ss-choices` |
| [ ] | `Users/network.ctp` + `Element/network-node.ctp` | E | | Minha rede |
| [ ] | `Users/report.ctp`, `Users/clients_report.ctp` | F | | |

### Sistema

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [x] | `Element/navbar-side-system.ctp` | E | 2026-10-24 | `ss-subnav`. Ícones: Metas `fa-bullseye`, Produtos `fa-cube`. Telas ainda não migradas continuam com a barra antiga pela lista `$legado` no próprio element (Regions, GoalPlans, SaleGoals, SaleCommissions, Users, Pages): **retire o controller da lista ao migrar a tela** |
| [x] | `Products/index.ctp` | I | 2026-10-24 | Novo `ProdutosHelper` (`statusLista`, `statusLabel($status, $loja)`). Ações: editar + excluir (ícones). Marca de comissões vai na linha de apoio + legenda `ss-note`. Coluna de ações sem ordenação (`data-orderable="false"`) |
| [x] | `Products/view.ctp` | V | 2026-10-24 | Modal (aberto a partir de Planos). Usa os textos da loja (Disponível / Fora de linha) |
| [x] | `Products/form.ctp` | F | 2026-10-24 | Seções Identificação, Venda, Imagem. "Gravar" → Salvar/Cadastrar; Cancelar `type=button`; Excluir no rodapé (`postLink` com `block`). Sem `Form->error()`: o form usa `create(null)` e não há erro de campo para mostrar |
| [ ] | `Regions/index.ctp`, `add.ctp`, `edit.ctp` | I/F | | |
| [ ] | `GoalPlans/index.ctp`, `add.ctp`, `edit.ctp` | I/F | | |
| [ ] | `SaleGoals/index.ctp`, `add.ctp`, `edit.ctp`, `report.ctp` | I/F | | |
| [ ] | `SaleCommissions/index.ctp`, `add.ctp`, `edit.ctp`, `report.ctp` | I/F | | |

Sistema > Produtos verificado em 2026-10-24 no navegador (1280px e 375px): subnav, filtros,
estado vazio, modal de edição e de inclusão (foco no nome), salvar, cadastrar, excluir pela
linha e pelo rodapé do modal (mensagem de confirmação nova), view em modal a partir de Planos,
Planos ainda com a barra antiga, sem rolagem horizontal.

### Relatórios (`ReportsController`)

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [ ] | `Element/report-header.ctp`, `Element/report-form.ctp` | E | | Fazer antes dos relatórios |
| [ ] | `Reports/orders.ctp` | R | | |
| [ ] | `Reports/invoices.ctp` | R | | |
| [ ] | `Reports/goals.ctp` | R | | |
| [ ] | `Reports/commissions.ctp` | R | | |
| [ ] | `Reports/associates.ctp` | R | | |
| [ ] | `Reports/clients.ctp` | R | | |
| [ ] | `Reports/payments.ctp` | R | | |
| [ ] | `Reports/balances.ctp` | R | | |
| [ ] | `Reports/registrations.ctp` | R | | |
| [ ] | `Reports/taxes.ctp` | R | | |

### E-mail

| Feito | Tela | Tipo | Data | Observações |
|---|---|---|---|---|
| [ ] | `Layout/Email/html/default.ctp`, `Email/html/default.ctp` | E | | CSS inline (exceção à regra), cores dos tokens |

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
