# Fundamentos

Todos os valores abaixo existem como variáveis em `webroot/css/ss-theme.css` (seção 1).
Nos componentes use os **papéis** (`--ss-text`, `--ss-border`...) e não os números da escala.

## Cores

### Primária: verde-petróleo

Escolhida por combinar com o verde já usado no painel e ficar distinta do verde de "sucesso".

| Token | Hex | Uso |
|---|---|---|
| `--ss-primary-50`  | `#effaf7` | Fundo de item ativo (menu lateral, dropdown, cartão de escolha marcado) |
| `--ss-primary-100` | `#d3efe7` | Seleção de texto, halo do passo atual |
| `--ss-primary-200` | `#a6dccd` | Borda de card ao passar o mouse |
| `--ss-primary-500` | `#179a80` | Borda de campo em foco |
| `--ss-primary-600` | `#0f7f6a` | **Botão primário**, item ativo, paginação ativa |
| `--ss-primary-700` | `#0c6656` | Links, hover do primário, texto sobre fundo `-50` |
| `--ss-primary-800` | `#0a5146` | Hover de link |

### Neutros

| Token | Hex | Papel |
|---|---|---|
| `--ss-gray-0`   | `#ffffff` | `--ss-surface` (cards, modais, campos) |
| `--ss-gray-25`  | `#f8faf9` | `--ss-surface-2` (cabeçalho de tabela, rodapé de card/modal, campo somente leitura) |
| `--ss-gray-50`  | `#f2f5f4` | `--ss-bg` (fundo da página), hover discreto |
| `--ss-gray-100` | `#e6ebea` | `--ss-border` (divisórias, bordas de card) |
| `--ss-gray-200` | `#d5dcda` | `--ss-border-strong` (bordas de campo e botão) |
| `--ss-gray-300` | `#b9c3c0` | Hover de borda, separadores de breadcrumb |
| `--ss-gray-400` | `#8f9c98` | Placeholder (nunca texto de conteúdo) |
| `--ss-gray-500` | `#66756f` | `--ss-text-muted` (rótulos, legendas, metadados) |
| `--ss-gray-700` | `#36413e` | `--ss-text-2` (texto secundário, botões default) |
| `--ss-gray-900` | `#17201d` | `--ss-text` (texto principal, títulos) |

### Semânticas

Cada uma tem `fg` (texto/ícone), `bg` (fundo suave), `bd` (borda) e `solid` (preenchido).

| Tom | fg | bg | bd | solid | Quando usar |
|---|---|---|---|---|---|
| success | `#1a7f37` | `#eaf7ee` | `#b7e2c4` | `#1f9246` | Concluído, pago, ativo, gravado com sucesso |
| warning | `#8f5300` | `#fff6e0` | `#f3d38c` | `#e09b00` | Pendente, aguardando, atenção |
| danger  | `#b42318` | `#fdecea` | `#f5c2bd` | `#d92d20` | Erro, vencido, exclusão, bloqueio |
| info    | `#175cd3` | `#eef4ff` | `#c7d7fe` | `#2e6fe0` | Informação neutra, em cálculo, dica |

Regras:
- Texto colorido sempre com o `fg` sobre `bg` ou branco (contraste AA).
- `solid` só em botão de perigo, contador de alerta e preenchimentos pequenos.
- Valores positivos/negativos: `ss-pos` (success-fg) e `ss-neg` (danger-fg). Valores comuns ficam
  na cor do texto, **sem** verde.

### Cores dos planos

Usadas apenas no selo `ss-plan` (ver componentes).

| Plano | id | Token | Hex |
|---|---|---|---|
| Dev | 1 | `--ss-plan-dev` | `#475467` |
| Admin | 2 | `--ss-plan-admin` | `#6941c6` |
| Super Master (SM) | 3 | `--ss-plan-sm` | `#0e7090` |
| Master | 4 | `--ss-plan-master` | `#b54708` |
| VIP | 5 | `--ss-plan-vip` | `#c11574` |
| Cliente | 6 | `--ss-plan-cliente` | `#66756f` |

## Tipografia

- **Família:** Inter (Google Fonts, pesos 400, 500, 600), com `system-ui` de reserva.
  Código/IDs: `--ss-font-mono` (fontes do sistema).
- **Números:** valores, quantidades e datas em tabela usam `font-variant-numeric: tabular-nums`
  (já incluído em `ss-num`, `ss-money`, `ss-stat-value`, `ss-totals`).
- **Pesos:** 400 texto, 500 rótulos/botões/links de menu, 600 títulos e destaques. Não use 700+.

| Token | Tamanho | Uso |
|---|---|---|
| `--ss-text-xs`   | 12px | Rótulo de métrica, badge, ajuda, metadados, cabeçalho de seção em view |
| `--ss-text-sm`   | 13px | Labels de campo, texto secundário, botão pequeno |
| `--ss-text-base` | 14px | Texto padrão, células, botões |
| `--ss-text-md`   | 16px | Título de card e de modal, total do pedido |
| `--ss-text-lg`   | 18px | Título de registro (view), título de página no celular |
| `--ss-text-xl`   | 22px | Título de página, valor de métrica |
| `--ss-text-2xl`  | 28px | Reservado (login, números de destaque) |

Cabeçalho de tabela: 11,5px, maiúsculas, espaçamento .04em, `--ss-text-muted`.
Altura de linha: 1.5 no texto, 1.2–1.3 em títulos.

## Espaçamento, forma e sombra

Base de 4px: `--ss-space-1` 4 · `-2` 8 · `-3` 12 · `-4` 16 · `-5` 20 · `-6` 24 · `-8` 32 · `-10` 40.

| Situação | Valor |
|---|---|
| Entre campos do formulário | 16px (`.form-group`) |
| Padding de card / modal | 20px (16px no celular) |
| Entre cards e blocos da página | 16px (`ss-stack`) ou 24px (`ss-stack-lg`) |
| Entre título da página e conteúdo | 20px |
| Gutter lateral da página | 24px (16px no celular) |

Raios: `--ss-radius-sm` 4px (tooltip, itens pequenos) · `--ss-radius` 6px (botões, campos, alertas)
· `--ss-radius-lg` 10px (cards, modais, dropdowns) · `--ss-radius-pill` (badges, contadores).

Sombras: `--ss-shadow-sm` em cards e campos; `--ss-shadow` no hover de card clicável;
`--ss-shadow-lg` só em camadas flutuantes (dropdown, modal, datepicker). Foco: `--ss-focus`.

Altura de controles: 38px (42px no celular, via `--ss-control-h`).

## Pontos de quebra (Bootstrap 3)

| Nome | Largura | Comportamento |
|---|---|---|
| xs | < 768px | Celular: menu recolhido, tabelas empilhadas, filtros recolhidos, modal em tela cheia |
| sm | ≥ 768px | Tablet: menu horizontal, navegação lateral visível |
| md | ≥ 992px | Desktop: métricas em 4 colunas, view com coluna lateral |
| lg | ≥ 1200px | Desktop largo: conteúdo limitado a 1320px |

## Ícones (Font Awesome 4.7)

Sempre `fa-fw` em menus e listas para alinhar. Um ícone por ação; não repita o ícone em todos os
itens de uma tabela se o texto já basta.

| Ação / entidade | Ícone |
|---|---|
| Novo / incluir | `fa-plus` |
| Ver | `fa-eye` |
| Editar | `fa-pencil` |
| Excluir | `fa-trash-o` |
| Mais ações | `fa-ellipsis-h` |
| Buscar | `fa-search` |
| Filtros | `fa-sliders` |
| Limpar filtros | `fa-times` |
| Imprimir | `fa-print` |
| Relatório | `fa-file-text-o` |
| Baixar / exportar | `fa-download` |
| Voltar | `fa-arrow-left` |
| Confirmar / baixar fatura | `fa-check` |
| Cancelar registro | `fa-ban` |
| Início | `fa-home` |
| Rede / indicados | `fa-sitemap` |
| Associado / usuário | `fa-user` · cadastrar `fa-user-plus` · vários `fa-users` |
| Pedidos | `fa-shopping-cart` · loja `fa-cart-plus` |
| Faturas / extrato | `fa-file-text-o` |
| Saques | `fa-money` (substitui o antigo `fa-btc`) |
| Taxas de inscrição | `fa-ticket` |
| Comissões | `fa-handshake-o` |
| Metas | `fa-bullseye` |
| Produtos | `fa-cube` |
| Avisos | `fa-bell-o` |
| Relatórios (menu) | `fa-bar-chart` |
| Sistema / configurações | `fa-cog` |
| Envio / entrega | `fa-truck` |
| Dados bancários | `fa-university` |
| Senha | `fa-lock` |
| Sair | `fa-sign-out` |
| Sucesso · aviso · erro · info | `fa-check-circle` · `fa-exclamation-triangle` · `fa-times-circle` · `fa-info-circle` |

Não use `fa-spin` fora do indicador de carregamento.

## Textos e formatos

**Tom:** português claro e direto, frases curtas, sem caixa alta para ênfase.
Títulos e botões com só a primeira letra maiúscula ("Novo produto", não "Novo Produto").

| Elemento | Padrão |
|---|---|
| Ação de criar | "Novo produto", "Nova fatura", "Cadastrar associado" |
| Salvar formulário | "Salvar" (edição) / "Cadastrar" (inclusão). Não usar "Gravar". |
| Fechar sem salvar | "Cancelar" |
| Excluir | "Excluir" (não "Apagar"). Confirmação: "Excluir o produto {nome}? Esta ação não pode ser desfeita." |
| Botão carregando | `data-loading-text="Salvando..."` / "Carregando..." |
| Sucesso | "Produto salvo." · "Fatura baixada." (frase curta, no passado) |
| Erro | O que houve + o que fazer: "Não foi possível salvar. Confira os campos destacados." |
| Lista vazia | Título "Nenhum pedido encontrado" + dica "Ajuste os filtros ou cadastre um novo." |
| Placeholder | Exemplo de preenchimento ("Ex.: 01310-100"), nunca substitui o label |

| Dado | Formato | Como gerar |
|---|---|---|
| Moeda | `R$ 1.234,56` | `$this->Number->currency($v, 'BRL')` dentro de `ss-money`/`ss-num` |
| Data | `24/10/2026` | `$this->MyHtml->date($d)` |
| Data curta em tabela | `24/10/26` ou `24 out` | `$this->MyHtml->tinyDate($d)` |
| Data e hora | `24/10/2026 14:32` | `$this->MyHtml->time($d)` |
| Código do registro | `#000123` | `'#' . str_pad($id, 6, '0', STR_PAD_LEFT)` dentro de `ss-id` |
| Quantidade | `1.234` | `$this->Number->format($n)` |
| Percentual | `12,5%` | `$this->Number->toPercentage($n, 1)` |
| Vazio | `—` | Travessão em `ss-muted`, nunca célula em branco |
