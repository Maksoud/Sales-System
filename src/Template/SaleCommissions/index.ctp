<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleCommissions/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total = count($data);
$planosRede = [3 => __('Super Master'), 4 => __('Master'), 5 => __('VIP')];
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Comissões') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Comissões') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} regra encontrada', '{0} regras encontradas', $total, $total)
                            : __n('{0} regra cadastrada', '{0} regras cadastradas', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Nova comissão'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Nova comissão'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <div class="ss-stack">
                <section class="ss-card ss-card--flush">
                    <div class="ss-card-header">
                        <button type="button" class="btn btn-default ss-filters-toggle" data-toggle="collapse"
                                data-target="#filtros" aria-expanded="false" aria-controls="filtros">
                            <i class="fa fa-sliders" aria-hidden="true"></i> <?= __('Filtros') ?>
                            <?php if ($temFiltro): ?><span class="ss-filters-count">!</span><?php endif; ?>
                        </button>
                        <div id="filtros" class="ss-filters-panel collapse">
                            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'ss-filters']) ?>
                                <div class="form-group ss-filters-grow">
                                    <label for="f-valor" class="sr-only"><?= __('Valor') ?></label>
                                    <?= $this->Form->text('valor', ['id' => 'f-valor', 'class' => 'form-control valuemask',
                                            'inputmode' => 'decimal', 'placeholder' => __('Valor (ex.: 4.950,00)'),
                                            'value' => $this->request->getQuery('valor')]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="f-from" class="sr-only"><?= __('Plano que recebe') ?></label>
                                    <?= $this->Form->select('from_plans_id', $planosRede,
                                            ['id' => 'f-from', 'class' => 'form-control', 'empty' => __('Recebe: todos os planos'),
                                             'value' => $this->request->getQuery('from_plans_id')]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="f-to" class="sr-only"><?= __('Plano que paga') ?></label>
                                    <?= $this->Form->select('to_plans_id', $planosRede,
                                            ['id' => 'f-to', 'class' => 'form-control', 'empty' => __('Paga: todos os planos'),
                                             'value' => $this->request->getQuery('to_plans_id')]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="f-type" class="sr-only"><?= __('Tipo') ?></label>
                                    <?= $this->Form->select('type', $this->Comissoes->tipos,
                                            ['id' => 'f-type', 'class' => 'form-control', 'empty' => __('Todos os tipos'),
                                             'value' => $this->request->getQuery('type')]) ?>
                                </div>
                                <input type="hidden" name="iniciar_busca" value="true">
                                <div class="ss-filters-actions">
                                    <?= $this->Html->link(__('Limpar'), ['action' => 'index'],
                                            ['class' => 'btn btn-link', 'id' => 'btn-resetar-form', 'style' => 'display:none;']) ?>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?>
                                    </button>
                                </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>

                    <?php if ($total): ?>
                    <div class="ss-table-wrap">
                        <table class="table ss-table ss-table--stack" id="adjustable">
                            <thead>
                                <tr>
                                    <th class="ss-col-id"><?= __('Código') ?></th>
                                    <th><?= __('Comissão') ?></th>
                                    <th class="ss-num"><?= __('Percentual') ?></th>
                                    <th><?= __('Quem recebe') ?></th>
                                    <th><?= __('Cadastro') ?></th>
                                    <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $comissao): ?>
                                <?php
                                    $tipo   = $this->Comissoes->tipo($comissao->tipo);
                                    $origem = $comissao->origem == 'T'
                                        ? ['fa-ticket', __('Sobre a taxa de inscrição')]
                                        : ['fa-shopping-cart', __('Sobre os pedidos da loja (sem frete)')];
                                    $casas  = $comissao->porcentagem == (int)$comissao->porcentagem ? 0 : 1;
                                ?>
                                <tr>
                                    <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $comissao->id ?>">
                                        <span class="ss-id">#<?= str_pad($comissao->id, 6, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td class="ss-cell-primary">
                                        <?= $this->Html->link(h($tipo), ['action' => 'edit', $comissao->id],
                                                ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Editar comissão'),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <span class="ss-cell-sub">
                                            <i class="fa <?= $origem[0] ?> fa-fw" aria-hidden="true"></i> <?= $origem[1] ?>
                                        </span>
                                    </td>
                                    <td class="ss-num" data-label="<?= __('Percentual') ?>" data-order="<?= $comissao->porcentagem ?>">
                                        <?= $this->Number->toPercentage($comissao->porcentagem, $casas) ?>
                                    </td>
                                    <td data-label="<?= __('Quem recebe') ?>" data-order="<?= $comissao->nivel ?>">
                                        <?= __n('{0} nível acima de quem pagou', '{0} níveis acima de quem pagou', $comissao->nivel, $comissao->nivel) ?>
                                    </td>
                                    <td data-label="<?= __('Cadastro') ?>" data-order="<?= $comissao->created->format('Ymd') ?>">
                                        <?= $this->MyHtml->tinyDate($comissao->created) ?>
                                    </td>
                                    <td class="ss-actions">
                                        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                ['action' => 'edit', $comissao->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                                 'aria-label' => __('Editar {0}', $tipo), 'data-title' => __('Editar comissão'),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                                ['action' => 'delete', $comissao->id],
                                                ['confirm' => __('Excluir a comissão {0}? Esta ação não pode ser desfeita.', $tipo),
                                                 'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                                 'aria-label' => __('Excluir {0}', $tipo), 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="ss-empty">
                        <div class="ss-empty-icon"><i class="fa fa-handshake-o" aria-hidden="true"></i></div>
                        <?php if ($temFiltro): ?>
                            <p class="ss-empty-title"><?= __('Nenhuma comissão encontrada') ?></p>
                            <p class="ss-empty-text"><?= __('Ajuste os filtros ou cadastre uma nova.') ?></p>
                            <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                        <?php else: ?>
                            <p class="ss-empty-title"><?= __('Nenhuma comissão cadastrada') ?></p>
                            <p class="ss-empty-text"><?= __('Cadastre as regras de comissão da rede.') ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </section>

                <div class="ss-note">
                    <span class="ss-note-title"><?= __('Níveis') ?></span>
                    <?= __('1 nível acima é o patrocinador de quem pagou a taxa ou o pedido; 2 níveis acima, o patrocinador dele, e assim por diante.') ?>
                </div>
            </div>
        </div>
    </div>
</div>
