<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-warning" onclick="this.classList.add('hidden')">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= $message ?>
</div>
