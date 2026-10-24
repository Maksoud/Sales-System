<?php
/**
 * Mensagem de retorno após gravar/excluir (?action=ok | ?action=deleted).
 * Mantém o id #ajax-sucesso-retorno usado pelo JS.
 */
$retorno = $this->request->getQuery('action');
$mensagens = [
    'ok'      => ['alert-success', 'fa-check-circle', __('Registro gravado com sucesso.')],
    'deleted' => ['alert-warning', 'fa-check-circle', __('Registro excluído com sucesso.')],
];
?>
<?php if (isset($mensagens[$retorno])): list($classe, $icone, $texto) = $mensagens[$retorno]; ?>
    <div id="ajax-sucesso-retorno" class="ss-flash">
        <div class="alert <?= $classe ?>" role="status" onclick="this.classList.add('hidden')">
            <button type="button" class="close" data-dismiss="alert" aria-label="<?= __('Fechar') ?>">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fa <?= $icone ?>" aria-hidden="true"></i> <?= $texto ?>
        </div>
    </div>
<?php endif; ?>
