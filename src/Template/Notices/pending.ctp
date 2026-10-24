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

<div class="container-fluid lista-avisos">
    <?php foreach ($avisos as $aviso): ?>
        <div class="row aviso-item">
            <div class="col-xs-12 col-sm-9">
                <h4>
                    <i class="fa fa-share text-danger" aria-hidden="true"></i>
                    <?= h($aviso->title) ?>
                    <br><small><?= $this->MyHtml->time($aviso->created) ?></small>
                </h4>
                <?= $aviso->aviso ?>
            </div>
            <div class="top-10 col-xs-12 col-sm-3">
                <button type="button" class="btn btn-primary btn-xs btn-block btn-descartar" title="<?= __('O aviso sai desta lista de pendentes') ?>">
                    <i class="fa fa-check-square-o" aria-hidden="true"></i> <?= __('Descartar aviso') ?>
                </button>
            </div>
            <?php if ($aviso->banner): ?>
                <div class="top-10 col-xs-12">
                    <?= $this->Html->image($aviso->banner, ['class' => 'img-responsive img-rounded', 'alt' => $aviso->title]) ?>
                </div>
            <?php endif; ?>
            <div class="col-xs-12"><hr></div>
        </div>
    <?php endforeach; ?>

    <div class="alert alert-info avisos-vazio" role="alert" <?= $avisos ? 'style="display:none"' : '' ?>>
        <?= __('Nenhum aviso no momento.') ?>
    </div>
</div>

<script>
    //Descarta o aviso apenas na tela (demonstração sem banco de dados)
    $('.lista-avisos .btn-descartar').on('click', function () {
        $(this).closest('.aviso-item').fadeOut(300, function () {
            $(this).remove();
            if (!$('.lista-avisos .aviso-item').length) $('.avisos-vazio').show();
        });
    });
</script>
