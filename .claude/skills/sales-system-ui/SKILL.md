---
name: sales-system-ui
description: Padrão visual do Sales-System (painel Sales-System/Mineralli, CakePHP 3.4 + Bootstrap 3.3.6 + Font Awesome 4.7). Use sempre que for criar, refazer ou ajustar o visual de qualquer tela, template .ctp, element, layout, menu, modal, alerta, tabela, formulário ou CSS deste projeto, ou quando o pedido for "atualizar o visual", "aplicar o padrão", "migrar a tela X para o novo layout". Define cores, fontes, componentes e os modelos de listagem (index), visualização (view) e formulários (add/edit).
---

# Sales-System UI

Identidade visual única do painel. Cada chamada desta skill migra **uma parte** do sistema
(um módulo, uma tela ou um element) para o padrão, sem mudar o comportamento.

## Onde está cada coisa

| Arquivo | Conteúdo |
|---|---|
| `webroot/css/ss-theme.css` | **Fonte da verdade.** Tokens e todos os componentes `ss-*`. Também reestiliza as classes do Bootstrap 3 (`.btn`, `.label`, `.alert`, `.table`, `.form-control`, `.modal`, `.dropdown-menu`...). |
| [references/fundamentos.md](references/fundamentos.md) | Cores, tipografia, espaçamento, ícones, textos e formatos (data, moeda, código). |
| [references/componentes.md](references/componentes.md) | Markup de cada componente: botões, links, badges, alertas, notas, cards, métricas, menus, modal, paginação, mensagens, estado vazio. |
| [references/listagem.md](references/listagem.md) | Modelo das telas **index**. |
| [references/visualizacao.md](references/visualizacao.md) | Modelo das telas **view** (em modal e em página). |
| [references/formulario.md](references/formulario.md) | Modelo dos formulários **add/edit**. |
| [references/telas-especiais.md](references/telas-especiais.md) | Layout base (cabeçalho, menu, rodapé), dashboard, login, relatórios, rede. |
| [references/status.md](references/status.md) | Mapa de status para badge de cada entidade. |
| [references/progresso.md](references/progresso.md) | Lista de telas e o que já foi migrado. **Atualize ao final de cada migração.** |
| `preview/styleguide.html` | Guia visual. Abra no navegador para ver todos os componentes. |

Leia só as referências que a tarefa pede. Para migrar uma listagem, por exemplo:
`fundamentos.md` + `listagem.md` + `componentes.md` (as seções usadas) + `status.md`.

## Princípios

1. **Limpo e organizado.** Fundo cinza-claro, conteúdo em cards brancos, uma cor de destaque
   (verde-petróleo `--ss-primary-600`). Cor forte só em status, ação principal e alertas.
2. **Hierarquia clara.** Cada tela tem um título, no máximo **uma** ação primária e as demais
   ações como secundárias, discretas ou dentro de um menu "Mais".
3. **Agrupar a informação.** Dados relacionados ficam juntos em seções com título curto.
   Nada de blocos coloridos (`bg-primary`, `bg-info`, `bg-yellow`) para separar conteúdo.
4. **Celular primeiro.** Tudo funciona a partir de 360px: tabelas viram cards, filtros recolhem,
   modais ocupam a tela, alvos de toque com 40px ou mais.
5. **Sem exageros.** Sem gradientes, sombras pesadas, animações chamativas ou ícones girando.
   Transições de no máximo 150ms.
6. **Consistência acima de criatividade.** Se o componente existe em `componentes.md`, use-o
   exatamente como está. Se não existe, veja "Componente novo" abaixo.

## Regras obrigatórias

- **Só tokens.** Cores, raios, sombras e espaçamentos vêm das variáveis `--ss-*`. Nenhum hex novo
  nos templates ou no CSS.
- **Nada de `style=""`** nos templates, exceto `display:none` controlado por JS.
- **Não use os utilitários antigos** em markup novo: `top-*`, `bottom-*`, `left-*`, `right-*`,
  `font-*`, `width-*`, `opacity-*`, `bg_cinza`, `bg-yellow`, `bg-blue`, `box`, `box-panel`,
  `painel-cinza`, `text-azul`, `text-verde`, `noPadding`, `aSemUnderline`. Remova-os da tela migrada.
- **Bootstrap 3.3.6.** Grid `col-xs-* / col-sm-* / col-md-*`, `pull-right`, `hidden-xs`,
  `sr-only`. Classes do Bootstrap 4/5 (`d-flex`, `mb-3`, `card`, `badge-*`) **não existem** aqui.
  Para flex e espaçamento use `ss-stack`, `ss-cluster`, `ss-spread`.
- **Font Awesome 4.7** (`fa fa-*`). Ícones decorativos com `aria-hidden="true"`; botão só com
  ícone exige `title` e `aria-label`.
- **Preserve os ganchos de JS** (não renomeie nem remova): `btn_modal` e os atributos `data-title`,
  `data-tamanho`, `data-loading-text`, `data-img`; `#modal_item`, `#modal_item_title`,
  `#modal_item_body`, `.modal-body`; `#adjustable` (DataTables, ordena pela 1ª coluna desc);
  `#btn-resetar-form` e o campo oculto `iniciar_busca`; `#ajax-retorno`, `#ajax-sucesso-retorno`;
  máscaras `.valuemask .moneymask .phonemask .cpfmask .cnpjmask .cepmask .datemask .ordermask`;
  `.datepicker`, `.datepicker_hoje`, `.focus`, `.bg_ajax`, `#countdown`, `#timer`, `#logo`;
  e todo `id`/`name` de campo de formulário.
- **Não mude comportamento.** URLs, nomes de campos, variáveis do controller, regras de permissão
  por perfil e textos legais continuam iguais. A migração é de apresentação. Se algo da lógica
  atrapalhar o layout, pergunte antes de mexer no controller.
- **PHP/Cake:** textos com `__()`, dados com `h()`, links com `$this->Html->link(..., ['escape' => false])`
  quando houver ícone, exclusão com `$this->Form->postLink` e `confirm`.
- **CSS novo só em `ss-theme.css`**, na seção certa. Não edite `bootstrap*.css`, `dashboard2.css`
  nem `reiniciando.css` (são legado; o tema os sobrepõe).

## Fase 0: fundação (uma vez só)

Antes da primeira tela, confira se a base já foi aplicada:

```bash
grep -n "ss-theme" src/Template/Element/head.ctp
```

Se não aparecer nada, aplique a fundação descrita em
[telas-especiais.md › Layout base](references/telas-especiais.md#layout-base) nesta ordem:

1. `Element/head.ctp`: carregar a fonte Inter e o `ss-theme.css` **por último**; trocar a meta
   viewport para `width=device-width, initial-scale=1` (sem `user-scalable=no`).
2. `Layout/default.ctp`: cabeçalho `ss-topbar` + menu `ss-navbar`, área de flash, `<main>`.
3. `Element/menus/*.ctp`: estado ativo do item do menu.
4. `Element/Flash/*.ctp`, `Element/msg-alert.ctp`, `Element/modal.ctp`, `Element/footer.ctp`,
   `Element/paginator-footer.ctp`.
5. Helpers `FaturasHelper`, `UsuariosHelper`, `PedidosHelper`: `statusLabel()` conforme
   [status.md](references/status.md).
6. Marcar a Fase 0 como feita em `progresso.md`.

Ao ligar o tema, as telas antigas já herdam fontes, cores, botões, tabelas e alertas novos.
A migração de cada parte reorganiza a estrutura.

## Fluxo para migrar uma parte

1. **Delimitar.** Identifique os arquivos da parte pedida (ex.: "Produtos" =
   `Template/Products/*.ctp` + `Element/navbar-side-system.ctp` se só ele usa). Abra
   `progresso.md` para ver o que já foi feito e o que é compartilhado.
2. **Entender os dados.** Leia o template atual e a action do controller: quais variáveis chegam,
   quais campos existem, quais perfis veem o quê.
3. **Classificar cada tela:** listagem, visualização, formulário, relatório ou especial. Siga o
   modelo correspondente na referência. Telas abertas por `btn_modal` usam `$this->layout = 'ajax'`
   e seguem a variante "em modal".
4. **Organizar a informação** antes de escrever markup: o que é identificação (título, código,
   status), o que é dado principal, o que é secundário, quais ações existem e qual é a principal.
5. **Reescrever o template** com os componentes da skill. Mantenha os ganchos de JS.
6. **Verificar:**
   - `php -l` em cada `.ctp` alterado.
   - Se o servidor local estiver rodando, abrir a tela em 1280px e em 375px (celular)
     e testar: abrir modal, salvar, filtrar, paginar, ordenar, imprimir quando houver.
   - Passar pelo checklist abaixo.
7. **Registrar** em `progresso.md` (tela, data, observações) e, se criou componente, documentar.

## Componente novo

Só crie se nenhum componente existente resolve. Então:
1. Escreva o CSS em `ss-theme.css` (prefixo `ss-`, só tokens, versão celular junto).
2. Documente markup e uso em `componentes.md`.
3. Adicione um exemplo em `preview/styleguide.html`.

## Checklist de entrega

- [ ] Um título por tela (`ss-page-title` ou título do modal) e no máximo uma ação primária.
- [ ] Nenhum `style=""`, utilitário antigo ou cor fora dos tokens.
- [ ] Status sempre como badge, pelo mapa de `status.md`.
- [ ] Valores com `ss-num`/`ss-money`, datas no formato padrão, códigos com `ss-id`.
- [ ] Tabela com `ss-table--stack` e `data-label` em cada `<td>`, ou justificativa para rolagem.
- [ ] Estado vazio (`ss-empty`) quando a lista pode vir sem registros.
- [ ] Formulário com labels visíveis, obrigatórios marcados, ajuda e erros no padrão.
- [ ] Funciona em 375px sem rolagem horizontal da página.
- [ ] Ganchos de JS preservados; modais, máscaras, datepicker e DataTables funcionando.
- [ ] `progresso.md` atualizado.
