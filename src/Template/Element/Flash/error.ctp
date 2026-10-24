<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
$classe = 'alert-danger';
if (!empty($params['class'])) {
    $classe .= ' ' . $params['class'];
}
?>
<div class="alert <?= h($classe) ?>" role="alert" onclick="this.classList.add('hidden');">
    <button type="button" class="close" data-dismiss="alert" aria-label="<?= __('Fechar') ?>">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-times-circle" aria-hidden="true"></i> <?= $message ?>
</div>
