# Formulários (add / edit)

Telas de inclusão e edição: `*/add.ctp`, `*/edit.ctp`, `*/form.ctp`, `Users/password.ctp`,
`Users/bank.ctp`, `Invoices/withdraw.ctp`, `Element/report-form.ctp` etc.
Quase todos abrem **em modal**. Inclusão e edição compartilham o mesmo template sempre que
possível (como `Products/form.ctp`).

## Como organizar os campos

1. **Agrupe** em seções (`ss-form-section`) com título curto: *Dados pessoais*, *Contato e
   acesso*, *Endereço*, *Valores*. Formulários com até 5 campos não precisam de seção.
2. **Ordene** do mais importante ao menos importante, e na ordem em que a pessoa pensa
   (CEP antes do endereço, quando houver busca de CEP).
3. **Largura conforme o conteúdo**: campos curtos (CEP, UF, número, valor, quantidade) não
   ocupam a linha inteira. Use a grade:

| Campo | Colunas (dentro de modal-lg) |
|---|---|
| Nome, e-mail, endereço, descrição | `col-xs-12 col-sm-8` ou `col-sm-12` |
| CPF/CNPJ, telefone, data, select | `col-xs-12 col-sm-4` ou `col-sm-6` |
| Valor, quantidade, ordem | `col-xs-6 col-sm-4` |
| CEP | `col-xs-12 col-sm-3` |
| Número, UF | `col-xs-6 col-sm-2` |

Em `modal-sm` todos os campos ocupam `col-xs-12`.

4. **Um campo por informação.** Não junte "Nome (login)" em um campo somente leitura; mostre
   dados fixos como texto (`ss-dl`) no topo do formulário.

## Campo

```php
<div class="form-group <?= $this->Form->isFieldError('title') ? 'has-error' : '' ?>">
    <label for="title" class="ss-required"><?= __('Nome') ?></label>
    <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
            'value' => $produto ? $produto->title : '', 'aria-describedby' => 'title-help']) ?>
    <span class="help-block" id="title-help"><?= __('Aparece na loja e nas faturas.') ?></span>
    <?= $this->Form->error('title') ?>
</div>
```

Regras:
- **Label sempre visível**, acima do campo, ligado por `for`/`id`. Sem asterisco no texto:
  obrigatório recebe `ss-required` no label (o asterisco é gerado pelo CSS) e `required` no campo.
  Opcional, quando a maioria é obrigatória: `<span class="ss-optional">(opcional)</span>` no label.
- `.focus` no primeiro campo (o JS coloca o cursor nele).
- Ajuda curta em `help-block`, abaixo. Erro depois da ajuda, gerado por `Form->error()`.
  Para sair com a classe do tema, configure o template uma vez em `AppView::initialize()`:
  `$this->Form->templates(['error' => '<span class="ss-error">{{content}}</span>']);`
  (no CakePHP 3.4 `templates()` ainda é o método disponível).
- Placeholder só como exemplo (`Ex.: 01310-100`).
- Máscaras pelas classes existentes (`valuemask`, `cpfmask`, `cepmask`, `phonemask`...).
  `valuemask` já alinha à direita.

### Tipos

```php
<!-- Valor em reais -->
<div class="input-group">
    <span class="input-group-addon">R$</span>
    <?= $this->Form->text('valor', ['class' => 'form-control valuemask', 'id' => 'valor', 'inputmode' => 'decimal']) ?>
</div>

<!-- Data -->
<div class="input-group">
    <?= $this->Form->text('dtvencimento', ['class' => 'form-control datepicker datemask', 'id' => 'dtvencimento',
            'placeholder' => 'dd/mm/aaaa', 'autocomplete' => 'off', 'inputmode' => 'numeric']) ?>
    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
</div>

<!-- Select: opção vazia descritiva -->
<?= $this->Form->select('status', $lista, ['class' => 'form-control', 'id' => 'status', 'empty' => __('Selecione')]) ?>

<!-- Checkbox -->
<div class="checkbox">
    <label><?= $this->Form->checkbox('comissoes', ['checked' => true]) ?> <?= __('Gera comissões para a rede') ?></label>
</div>

<!-- Arquivo -->
<label for="imagem"><?= __('Imagem') ?> <span class="ss-optional">(opcional)</span></label>
<?= $this->Form->file('imagem', ['id' => 'imagem', 'accept' => 'image/*']) ?>
<span class="help-block"><?= __('JPG ou PNG, até 2 MB.') ?></span>

<!-- Somente leitura: mostre como texto, não como campo -->
<dl class="ss-dl">
    <dt><?= __('Patrocinador') ?></dt><dd><?= h($usuario->nome) ?> <span class="ss-muted">(<?= h($usuario->login) ?>)</span></dd>
</dl>
```

Use os `inputmode` (`numeric`, `decimal`, `tel`, `email`) e `autocomplete` corretos para o
teclado certo no celular.

### Escolha entre opções com descrição (plano, forma de pagamento)

Substitui `lista-planos` / `item-plano`:

```php
<ul class="ss-choices" role="radiogroup" aria-label="<?= __('Plano') ?>">
    <?php foreach ($planos as $id => $plano): ?>
    <li>
        <label class="ss-choice">
            <input type="radio" name="planos_id" value="<?= $id ?>" <?= $id == $atual ? 'checked' : '' ?> required>
            <span class="ss-choice-card">
                <i class="fa fa-certificate" aria-hidden="true"></i>
                <span class="ss-choice-title"><?= h($plano['nome']) ?></span>
                <span class="ss-choice-desc"><?= $this->Number->currency($plano['valor'], 'BRL') ?></span>
            </span>
        </label>
    </li>
    <?php endforeach; ?>
</ul>
```

### Formulário em etapas

Para o cadastro de associado ou outro fluxo longo, `ss-stepper` no topo:

```html
<ol class="ss-stepper">
    <li class="is-done"><span>Plano</span></li>
    <li class="is-current"><span>Dados pessoais</span></li>
    <li><span>Endereço</span></li>
</ol>
```

Botões no rodapé: "Voltar" (`btn-default`, à esquerda com `ss-footer-start`) e
"Continuar"/"Cadastrar" (primário).

## Formulário em modal

Convenção do projeto: o template abre o form dentro do `.modal-body`, **fecha o corpo do modal**
com `</div>` e abre o `.modal-footer`, onde ficam os botões e o `Form->end()`.

```php
<?php
/* File: src/Template/Products/form.ctp */
$this->layout = 'ajax';
$url = $produto ? ['action' => 'edit', $produto->id] : ['action' => 'add'];
?>
<?= $this->Form->create(null, ['url' => $url, 'type' => 'file', 'novalidate' => false]) ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Identificação') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">…nome…</div>
            <div class="col-xs-12 col-sm-4 form-group">…status…</div>
            <div class="col-xs-12 form-group">…descrição…</div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Venda') ?></h4>
        <p class="ss-form-section-desc"><?= __('Preço e posição do produto na loja.') ?></p>
        <div class="row">
            <div class="col-xs-6 col-sm-4 form-group">…preço…</div>
            <div class="col-xs-6 col-sm-4 form-group">…ordem…</div>
            <div class="col-xs-12 form-group">…checkbox comissões…</div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Imagem') ?></h4>
        <div class="ss-cell-media">
            <?php if ($produto): ?>
                <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'ss-thumb ss-thumb--lg', 'alt' => '']) ?>
            <?php endif; ?>
            <div class="form-group ss-mb-0 ss-grow">…input file…</div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($produto): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $produto->id],
                ['confirm' => __('Excluir o produto {0}? Esta ação não pode ser desfeita.', $produto->title),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($produto ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
```

- `postLink` dentro de outro `<form>` gera form aninhado: use `'block' => true` e imprima
  `$this->fetch('postLink')` depois do `Form->end()`.
- "Cancelar" é `type="button"` (o `reset` antigo apagava o que foi digitado sem fechar).
- O rodapé fica fixo no celular; não coloque campos nele.

## Formulário em página

Quando o formulário não cabe num modal ou precisa de URL própria:

```php
<div class="ss-container ss-container--narrow ss-page">
    <header class="ss-page-header">
        <div class="ss-page-header-main">
            <ol class="ss-breadcrumb"><li><?= $this->Html->link(__('Produtos'), ['action' => 'index']) ?></li><li><?= __('Novo') ?></li></ol>
            <h1 class="ss-page-title"><?= __('Novo produto') ?></h1>
        </div>
    </header>
    <?= $this->Form->create(…) ?>
    <section class="ss-card">
        <div class="ss-card-body">
            …ss-form-section…
        </div>
        <div class="ss-form-actions">
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
            <?= $this->Form->button(__('Cadastrar'), ['class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
        </div>
    </section>
    <?= $this->Form->end() ?>
</div>
```

## Validação e retorno

- Erro de campo: `has-error` no `.form-group` + mensagem `ss-error` abaixo do campo.
- Vários erros ou erro geral: um `ss-alert ss-alert--danger` no topo do formulário com o resumo
  ("Confira os 3 campos destacados.").
- Sucesso: Flash (`$this->Flash->success(__('Produto salvo.'))`), exibido pelo layout.
  Retornos por `?action=ok|deleted` (`msg-alert.ctp`) seguem o mesmo visual.
- Em modo demonstração, a mensagem "(demonstração: nenhum dado foi alterado)" continua no texto
  do flash.

## Formulário de relatório

`Element/report-form.ctp` e afins (modal `sm`): período (duas datas lado a lado em
`col-xs-6`), filtros em `col-xs-12`, rodapé com "Cancelar" e "Gerar relatório"
(`fa-file-text-o`). Abre o resultado em nova aba quando for para impressão.
