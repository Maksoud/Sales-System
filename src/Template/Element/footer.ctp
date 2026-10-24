<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>
<div class="ss-container ss-spread">
    <span>&copy; <?= date('Y') ?> Sales-System</span>
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
