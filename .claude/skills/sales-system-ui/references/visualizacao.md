# Visualização (view)

Telas que mostram um registro: `*/view.ctp`, `Users/profile.ctp`, `Notices/view.ctp`.
A maioria abre **em modal** (`btn_modal` + `$this->layout = 'ajax'`); algumas podem virar página.

## Como organizar a informação

Antes do markup, separe o registro em:

1. **Identificação**: o que é (título/nome), código, status, data principal.
2. **Seções** de dados que andam juntos: no pedido, por exemplo, *Itens*, *Valores*,
   *Pagamento*, *Entrega*, *Destinatário*. Título curto, de 1 a 2 palavras.
3. **Ações** sobre o registro (editar, baixar, cancelar, imprimir): uma primária.

Regras:
- Dados no formato **rótulo : valor** com `ss-dl`. Não escreva "**Tipo:** Normal<br>" solto.
- O mais importante primeiro: o que a pessoa abriu a tela para saber (status, valor, itens).
- Nada de caixas coloridas por seção (`bg-info`, `bg-primary`, `bg-yellow`). A separação é feita
  por título de seção e divisória.
- Seções com altura fixa (`min-height`) não são usadas: cada uma tem a altura do conteúdo.
- Valor ausente: `—`. Não esconda a linha se a ausência for informação ("Previsão de entrega: —").
- Texto de situação ("Frete e impostos em cálculo. Verifique mais tarde.") vira `ss-alert` no
  topo da view, não uma linha no meio dos dados.

## View em modal

```php
<?php
/* File: src/Template/Orders/view.ctp */
$this->layout = 'ajax';
$usuario = $pedido->usuario;
?>
<div class="ss-record-header">
    <div>
        <h3 class="ss-record-title">
            <?= __('Pedido') ?> <span class="ss-id">#<?= str_pad($pedido->id, 6, '0', STR_PAD_LEFT) ?></span>
            <?= $this->Pedidos->statusLabel($pedido->status) ?>
        </h3>
        <div class="ss-record-meta">
            <span><?= __('Feito em {0}', $this->MyHtml->time($pedido->created)) ?></span>
            <span><?= h($this->Pedidos->tipo($pedido->tipo)) ?></span>
        </div>
    </div>
    <div class="ss-cluster hidden-print">
        <a href="#" onclick="window.print(); return false;" class="btn btn-sm btn-default">
            <i class="fa fa-print" aria-hidden="true"></i> <?= __('Imprimir') ?>
        </a>
    </div>
</div>

<?php if ($pedido->status == 'V'): ?>
    <div class="ss-alert" role="status">
        <i class="fa fa-calculator ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body"><?= __('Frete e impostos em cálculo. O total aparece aqui assim que o cálculo terminar.') ?></div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-xs-12 col-md-8">

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Itens') ?></h4>
            <div class="ss-table-wrap">
                <table class="table ss-table ss-table--stack">
                    <thead>
                        <tr>
                            <th><?= __('Produto') ?></th>
                            <th class="ss-num"><?= __('Preço') ?></th>
                            <th class="ss-num"><?= __('Qtd.') ?></th>
                            <th class="ss-num"><?= __('Total') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pedido->pedidos_produtos as $item): ?>
                        <tr>
                            <td class="ss-cell-primary">
                                <div class="ss-cell-media">
                                    <?= $this->Html->image('produtos/' . $item->produto->imagem, ['class' => 'ss-thumb', 'alt' => '']) ?>
                                    <div>
                                        <span class="ss-cell-title"><?= h($item->produto->title) ?></span>
                                        <span class="ss-cell-sub"><?= h($item->produto->descricao) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="ss-num" data-label="<?= __('Preço') ?>">…</td>
                            <td class="ss-num" data-label="<?= __('Qtd.') ?>"><?= $item->quantidade ?></td>
                            <td class="ss-num" data-label="<?= __('Total') ?>">…</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <ul class="ss-totals ss-totals--end">
                <li><span><?= __('Subtotal') ?></span><span>…</span></li>
                <li><span><?= __('Frete') ?></span><span>…</span></li>
                <li class="is-total"><span><?= __('Total') ?></span><span><?= $this->Number->currency($pedido->total, 'BRL') ?></span></li>
            </ul>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Pagamento') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Forma') ?></dt>  <dd>…</dd>
                <dt><?= __('Parcelas') ?></dt> <dd>…</dd>
            </dl>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Andamento') ?></h4>
            <?= $this->Pedidos->etapas($pedido->status) ?>  <?php /* gera ss-steps */ ?>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Entrega') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Enviado em') ?></dt>  <dd>…</dd>
                <dt><?= __('Previsão') ?></dt>    <dd>…</dd>
                <dt><?= __('Rastreio') ?></dt>    <dd><span class="ss-mono">…</span></dd>
            </dl>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Destinatário') ?></h4>
            <address class="ss-address">
                <strong><?= h($usuario->nome) ?></strong> <span class="ss-muted">(<?= h($usuario->login) ?>)</span><br>
                <?= h($usuario->endereco) ?>, <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                <?= h($usuario->bairro) ?> · <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?> · CEP <?= h($usuario->cep) ?><br>
                <i class="fa fa-phone" aria-hidden="true"></i> <?= h($usuario->telefone) ?><br>
                <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= h($usuario->email) ?>
            </address>
        </section>
    </div>
</div>
```

Notas:
- O título do registro dentro do modal repete o código e o status mesmo que o `data-title` do
  modal já diga "Pedido": é a identificação que importa ao imprimir e ao rolar.
- As duas colunas (`col-md-8` + `col-md-4`) viram uma abaixo de 992px; o tema coloca a
  divisória entre elas automaticamente.
- Ações que **alteram** o registro (baixar, cancelar, editar) vão no `.modal-footer`, como num
  formulário: o template fecha o `.modal-body` com `</div>` e abre o rodapé
  (ver [formulario.md](formulario.md#formulário-em-modal)).
- Views simples (produto, aviso) usam só `ss-record-header` + uma `ss-dl` ou o texto.

## View em página

Para registros grandes que mereçam URL própria (perfil do associado, detalhe da rede):

```php
<div class="ss-container ss-page">
    <header class="ss-page-header">
        <div class="ss-page-header-main">
            <ol class="ss-breadcrumb"><li><?= $this->Html->link(__('Associados'), ['action' => 'index']) ?></li><li><?= h($usuario->nome) ?></li></ol>
            <h1 class="ss-page-title"><?= h($usuario->nome) ?> <?= $this->Usuarios->statusLabel($usuario->status) ?></h1>
            <p class="ss-page-subtitle"><span class="ss-plan ss-plan--<?= (int)$usuario->planos_id ?>">…</span> · <?= __('Desde {0}', …) ?></p>
        </div>
        <div class="ss-page-actions">
            <a class="btn btn-default" href="…"><i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __('Voltar') ?></a>
            <a class="btn btn-primary btn_modal" href="…"><i class="fa fa-pencil" aria-hidden="true"></i> <?= __('Editar') ?></a>
        </div>
    </header>

    <div class="ss-split">
        <div class="ss-stack">
            <section class="ss-card">
                <header class="ss-card-header"><h2 class="ss-card-title"><?= __('Dados pessoais') ?></h2></header>
                <div class="ss-card-body">
                    <dl class="ss-dl ss-dl--grid">
                        <div><dt><?= __('CPF') ?></dt><dd>…</dd></div>
                        <div><dt><?= __('Nascimento') ?></dt><dd>…</dd></div>
                        <div><dt><?= __('Telefone') ?></dt><dd>…</dd></div>
                    </dl>
                </div>
            </section>
            <section class="ss-card ss-card--flush">…tabela relacionada (pedidos, faturas)…</section>
        </div>
        <aside class="ss-stack">
            <section class="ss-card">…resumo / andamento…</section>
        </aside>
    </div>
</div>
```

## Lista de dados (`ss-dl`)

| Variante | Quando |
|---|---|
| `ss-dl` | Rótulo à esquerda, valor à direita. Até ~8 itens, coluna estreita (modal, lateral). |
| `ss-dl ss-dl--grid` | Rótulo em cima, valor embaixo, várias colunas. Muitos campos curtos (cadastro). Cada par fica numa `<div>`. |

Rótulos curtos, sem dois-pontos. Valores monetários com `ss-money`; códigos com `ss-mono`.

## Linha do tempo de status

`PedidosHelper::etapas()` deve gerar `ss-steps`:

```html
<ol class="ss-steps">
    <li class="is-done"><span class="ss-steps-title">Calculando frete e impostos</span></li>
    <li class="is-done"><span class="ss-steps-title">Aguardando pagamento</span></li>
    <li class="is-current"><span class="ss-steps-title">Em preparação para envio</span><span class="ss-steps-date">desde 22/10/2026</span></li>
    <li><span class="ss-steps-title">Aguardando entrega</span></li>
    <li><span class="ss-steps-title">Concluído</span></li>
</ol>
```

Concluído: todos `is-done`. Cancelado: etapas até onde chegou como `is-done` e um último item
`is-canceled` com o texto "Cancelado". Data em `ss-steps-date` quando existir.

## Valores e totais

- Lista de totais: `ss-totals` (à direita com `ss-totals--end`), último item `is-total`.
- Créditos e débitos (extrato, comissões): `ss-money ss-pos` / `ss-money ss-neg`, com sinal
  explícito (`+ R$ 10,00` / `− R$ 10,00`).
