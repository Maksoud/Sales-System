<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>

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

<div class="container-fluid">
    <div class="btn">
        <div class="btn pull-bottom-developed" style="background-color: rgba(255, 255, 255, 0.6);">
            <a href="http://www.make2.com.br" target="_blank">
                <?= $this->Html->image("logo-make2.png", ['alt' => 'Make2']); ?>
            </a>
        </div>
    </div>
</div>