<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/network.ctp */

$this->layout = 'ajax';
?>

<?php if ($total): ?>
    <div class="ss-alert" role="status">
        <i class="fa fa-sitemap ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body ss-spread">
            <span><?= __('Toque em uma pessoa para abrir ou fechar os indicados abaixo dela.') ?></span>
            <span class="ss-nowrap"><span class="ss-count"><?= $this->Number->format($total) ?></span> <?= __n('pessoa na rede', 'pessoas na rede', $total) ?></span>
        </div>
    </div>

    <div class="minha-rede">
        <ul>
            <?= $this->element('network-node', ['usuario' => $raiz, 'nivel' => 0]) ?>
        </ul>
    </div>

    <script>
        $('.minha-rede').on('click', '.rede-pessoa', function (e) {
            e.preventDefault();
            var aberto = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', aberto ? 'false' : 'true').next('ul').toggle(150);
        });
    </script>
<?php else: ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-sitemap" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Ninguém na rede ainda') ?></p>
        <p class="ss-empty-text"><?= __('Os associados cadastrados por você aparecem aqui.') ?></p>
    </div>
<?php endif; ?>
