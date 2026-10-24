# Progresso da migração

Atualize ao terminar cada parte: troque `[ ]` por `[x]`, preencha a data (AAAA-MM-DD) e anote
o que ficou de fora. Tipo: **I** index · **V** view · **F** formulário · **R** relatório ·
**E** especial/element.

## Fase 0: fundação

| Feito | Arquivo | Data | Observações |
|---|---|---|---|
| [ ] | `Element/head.ctp` (fonte + `ss-theme.css` + viewport) | | |
| [ ] | `Layout/default.ctp` (topbar, navbar, flash, main) | | |
| [ ] | `Element/menus/*.ctp` (dev, admin, sm, master, vip, cliente, associado): estado ativo | | |
| [ ] | `Element/Flash/*.ctp` + `Element/msg-alert.ctp` | | |
| [ ] | `Element/modal.ctp` | | |
| [ ] | `Element/footer.ctp` | | |
| [ ] | `Element/paginator-footer.ctp` + `paginator-footer-jquery.ctp` | | |
| [ ] | Helpers: `FaturasHelper`, `PedidosHelper` (`statusLabel`, `etapas`), `UsuariosHelper` | | |
| [ ] | `Layout/layout-clean.ctp`, `Layout/error.ctp`, `Layout/relatorio.ctp` | | |

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
| [ ] | `Orders/index.ctp` | I | | Pedidos da loja |
| [ ] | `Orders/my_orders.ctp` | I | | |
| [ ] | `Orders/store.ctp` | E | | Loja |
| [ ] | `Orders/view.ctp` | V | | Modal |
| [ ] | `Orders/delivery.ctp` | F | | Envio |
| [ ] | `Orders/values.ctp` | F | | Frete e impostos |
| [ ] | `Orders/report.ctp` | F | | |
| [ ] | `Element/navbar-side-pedidos.ctp` | E | | Vira `ss-subnav` |

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
| [ ] | `Element/navbar-side-system.ctp` | E | | Vira `ss-subnav` |
| [ ] | `Products/index.ctp` | I | | Exemplo de referência em `listagem.md` |
| [ ] | `Products/view.ctp` | V | | |
| [ ] | `Products/form.ctp` | F | | Exemplo de referência em `formulario.md` |
| [ ] | `Regions/index.ctp`, `add.ctp`, `edit.ctp` | I/F | | |
| [ ] | `GoalPlans/index.ctp`, `add.ctp`, `edit.ctp` | I/F | | |
| [ ] | `SaleGoals/index.ctp`, `add.ctp`, `edit.ctp`, `report.ctp` | I/F | | |
| [ ] | `SaleCommissions/index.ctp`, `add.ctp`, `edit.ctp`, `report.ctp` | I/F | | |

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
| | | | |
