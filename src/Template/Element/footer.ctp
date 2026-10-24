<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>
<div class="ss-container ss-spread">
    <span>&copy; <?= date('Y') ?> Reiniciando</span>
    <a href="http://www.make2.com.br" target="_blank" rel="noopener" title="Make2">
        <?= $this->Html->image('logo-make2.png', ['alt' => __('Desenvolvido por Make2')]) ?>
    </a>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Plugin jQuery -->
<?= $this->Html->script('jquery.mask.min') ?>
<?= $this->Html->script('jquery.maskMoney') ?>
<?= $this->Html->script('jquery.countdownTimer.min') ?>

<!-- Bootstrap -->
<?= $this->Html->script('bootstrap.min') ?>
<?= $this->Html->script('bootstrap-datepicker.min') ?>
<?= $this->Html->script('bootstrap-datepicker.pt-BR.min') ?>

<!-- Extras -->
<?= $this->Html->script('reiniciando.js') ?>
<?= $this->Html->script('maksoud-custom.js') ?>
<?= $this->Html->script('jquery.dataTables.min') ?>
