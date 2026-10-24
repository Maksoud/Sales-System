<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* Modal padrão: o conteúdo chega por AJAX via .btn_modal (data-title, data-tamanho) */
?>
<div id="modal_item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_item_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_item_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="modal_item_body" class="modal-body"></div>
        </div>
    </div>
</div>
