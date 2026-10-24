<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/view.ctp */

$this->layout = 'ajax';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <?= $aviso->aviso ?>
            <?php if ($aviso->banner): ?>
                <?= $this->Html->image($aviso->banner, ['class' => 'top-10 img-responsive img-rounded', 'alt' => $aviso->title]) ?>
            <?php endif; ?>
        </div>
        <div class="top-10 col-xs-12 col-sm-4">
            <div class="alert alert-info" role="alert">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <?= __('Enviado') ?> <?= $this->MyHtml->time($aviso->created) ?>
            </div>
            <?php if ($aviso->validade): ?>
                <div class="alert <?= $aviso->ativo ? 'alert-info' : 'alert-danger' ?>" role="alert">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                    <?= $aviso->ativo ? __('Válido até') : __('Venceu em') ?> <?= $this->MyHtml->date($aviso->validade) ?>
                </div>
            <?php endif; ?>
            <div class="alert alert-info" role="alert">
                <i class="fa fa-users" aria-hidden="true"></i>
                <?= $aviso->plano ? __('Enviado para todos do plano {0}', h($aviso->plano->title)) : __('Enviado para todos do sistema') ?>
            </div>
        </div>
    </div>
</div>
