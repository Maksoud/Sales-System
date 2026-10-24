<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/pending.ctp */

//Avisos pendentes do usuário (modal do sino no cabeçalho)
$this->layout = 'ajax';
?>

<div class="lista-avisos">
    <?php if ($avisos): ?>
    <ul class="ss-messages">
        <?php foreach ($avisos as $aviso): ?>
        <li class="ss-message is-unread aviso-item">
            <span class="ss-message-icon"><i class="fa fa-bell-o" aria-hidden="true"></i></span>
            <div class="ss-message-body">
                <div class="ss-message-head">
                    <h3 class="ss-message-title"><?= h($aviso->title) ?></h3>
                    <span class="ss-message-meta"><?= $this->MyHtml->tinyDate($aviso->created) ?></span>
                </div>
                <div class="ss-message-text ss-richtext"><?= $aviso->aviso ?></div>
                <?php if ($aviso->banner): ?>
                    <?= $this->Html->image($aviso->banner, ['class' => 'ss-figure', 'alt' => $aviso->title]) ?>
                <?php endif; ?>
                <div class="ss-message-actions">
                    <button type="button" class="btn btn-sm btn-default btn-descartar" title="<?= __('O aviso sai desta lista de pendentes') ?>">
                        <i class="fa fa-check" aria-hidden="true"></i> <?= __('Marcar como lido') ?>
                    </button>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="ss-empty avisos-vazio" <?= $avisos ? 'style="display:none"' : '' ?>>
        <div class="ss-empty-icon"><i class="fa fa-bell-o" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum aviso no momento') ?></p>
        <p class="ss-empty-text"><?= __('Quando a administração enviar um aviso, ele aparece aqui.') ?></p>
    </div>
</div>

<script>
    //Descarta o aviso apenas na tela (demonstração sem banco de dados)
    $('.lista-avisos .btn-descartar').on('click', function () {
        $(this).closest('.aviso-item').fadeOut(150, function () {
            $(this).remove();
            if (!$('.lista-avisos .aviso-item').length) {
                $('.lista-avisos .ss-messages').remove();
                $('.avisos-vazio').show();
            }
        });
    });
</script>
