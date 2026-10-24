<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/list_backup.ctp */

//Arquivos de backup. Ainda não há action no PagesController que envie $backups;
//sem a lista, a tela mostra o estado vazio.
$backups = isset($backups) ? $backups : [];
$total = count($backups);
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Backups') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Arquivos de backup') ?></h1>
                    <p class="ss-page-subtitle"><?= __n('{0} arquivo', '{0} arquivos', $total, $total) ?></p>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <?= $this->Form->create('Backup') ?>
            <section class="ss-card ss-card--flush">
                <?php if ($total): ?>
                <div class="ss-card-header">
                    <h2 class="ss-card-title"><?= __('Arquivos') ?></h2>
                    <?= $this->Form->button('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir selecionados'),
                            ['type' => 'submit', 'class' => 'btn btn-sm ss-btn-danger-soft']) ?>
                </div>

                <div class="ss-table-wrap">
                    <table class="table ss-table ss-table--stack" id="adjustable">
                        <thead>
                            <tr>
                                <th class="ss-col-id hidden-print" data-orderable="false">
                                    <label for="select_all" class="sr-only"><?= __('Selecionar todos') ?></label>
                                    <?= $this->Form->checkbox('select_all', ['id' => 'select_all', 'hiddenField' => false]) ?>
                                </th>
                                <th><?= __('Arquivo') ?></th>
                                <th><?= __('Criação') ?></th>
                                <th class="ss-num"><?= __('Tamanho') ?></th>
                                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($backups as $backup): ?>
                            <tr>
                                <td class="ss-col-id hidden-print" data-label="<?= __('Selecionar') ?>" data-order="<?= h($backup['file']) ?>">
                                    <label for="listRecord_<?= h($backup['file']) ?>" class="sr-only"><?= __('Selecionar {0}', h($backup['file'])) ?></label>
                                    <?= $this->Form->checkbox('record[' . $backup['file'] . ']', ['id' => 'listRecord_' . $backup['file'],
                                            'hiddenField' => false, 'value' => $backup['file']]) ?>
                                </td>
                                <td class="ss-cell-primary">
                                    <span class="ss-cell-title ss-mono"><?= h($backup['file']) ?></span>
                                </td>
                                <td data-label="<?= __('Criação') ?>"><?= h($backup['modifield']) ?></td>
                                <td class="ss-num" data-label="<?= __('Tamanho') ?>" data-order="<?= sprintf('%.2F', $backup['size']) ?>">
                                    <?= $this->Number->precision($backup['size'], 2) ?> KB
                                </td>
                                <td class="ss-actions">
                                    <?= $this->Html->link('<i class="fa fa-download" aria-hidden="true"></i>',
                                            ['action' => 'download', $backup['file']],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon', 'target' => '_blank',
                                             'title' => __('Baixar'), 'aria-label' => __('Baixar {0}', $backup['file']), 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                            ['action' => 'delete', $backup['file']],
                                            ['confirm' => __('Excluir o arquivo {0}? Esta ação não pode ser desfeita.', $backup['file']),
                                             'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                             'aria-label' => __('Excluir {0}', $backup['file']), 'escape' => false, 'block' => true]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-database" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhum arquivo de backup') ?></p>
                    <p class="ss-empty-text"><?= __('Os backups gerados aparecem aqui para baixar ou excluir.') ?></p>
                </div>
                <?php endif; ?>
            </section>
            <?= $this->Form->end() ?>
            <?= $this->fetch('postLink') ?>
        </div>
    </div>
</div>
