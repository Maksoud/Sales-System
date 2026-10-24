<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/view.ctp */

//Visualização do aviso (modal)
$this->layout = 'ajax';
?>

<div class="ss-record-header">
    <div>
        <h3 class="ss-record-title">
            <?= h($aviso->title) ?>
            <?= $this->Avisos->statusLabel($aviso) ?>
        </h3>
        <div class="ss-record-meta">
            <span class="ss-id">#<?= str_pad($aviso->id, 6, '0', STR_PAD_LEFT) ?></span>
            <span><?= __('Enviado em {0}', $this->MyHtml->time($aviso->created)) ?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-8">
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Mensagem') ?></h4>
            <div class="ss-richtext"><?= $aviso->aviso ?></div>
            <?php if ($aviso->banner): ?>
                <?= $this->Html->image($aviso->banner, ['class' => 'ss-figure', 'alt' => $aviso->title]) ?>
            <?php endif; ?>
            <?php if ($aviso->youtube): ?>
                <p>
                    <a href="<?= h($aviso->youtube) ?>" class="ss-link-external" target="_blank" rel="noopener"><?= __('Ver vídeo no YouTube') ?></a>
                </p>
            <?php endif; ?>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Envio') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Destino') ?></dt>
                <dd><?= $aviso->plano ? $this->Avisos->destino($aviso) : __('Todos do sistema') ?></dd>
                <dt><?= __('Enviado') ?></dt>
                <dd><?= $this->MyHtml->tinyDate($aviso->created) ?></dd>
                <dt><?= __('Validade') ?></dt>
                <dd><?= $aviso->validade ? $this->MyHtml->tinyDate($aviso->validade) : '<span class="ss-muted">' . __('Sem validade') . '</span>' ?></dd>
            </dl>
        </section>
    </div>
</div>
