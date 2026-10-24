<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* Paginação: fica dentro do card da tabela, logo após ela */
?>
<div class="ss-table-footer">
    <span class="ss-pagination-info"><?= $this->Paginator->counter(__('{{start}}–{{end}} de {{count}}')) ?></span>
    <ul class="pagination">
        <?= $this->Paginator->prev('<i class="fa fa-angle-left" aria-hidden="true"></i><span class="sr-only">' . __('Anterior') . '</span>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers(['modulus' => 4]) ?>
        <?= $this->Paginator->next('<i class="fa fa-angle-right" aria-hidden="true"></i><span class="sr-only">' . __('Próxima') . '</span>', ['escape' => false]) ?>
    </ul>
</div>
