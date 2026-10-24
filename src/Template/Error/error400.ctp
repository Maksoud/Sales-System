<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;

//Erros 4xx: o 404 é o mais comum; 401/403 são falta de acesso
$codigo = isset($code) ? (int)$code : 404;
if ($codigo === 401 || $codigo === 403) {
    $icone  = 'fa-lock';
    $titulo = __('Acesso negado');
    $texto  = __('Você não tem permissão para abrir esta página. Entre com outro login ou volte ao início.');
} elseif ($codigo === 404) {
    $icone  = 'fa-compass';
    $titulo = __('Página não encontrada');
    $texto  = __('O endereço {0} não existe ou foi movido.', '<span class="ss-mono">' . h($url) . '</span>');
} else {
    $icone  = 'fa-exclamation-triangle';
    $titulo = __('Não foi possível abrir a página');
    $texto  = __('O pedido não pôde ser atendido. Confira o endereço e tente de novo.');
}
if (!Configure::read('debug')) {
    $this->assign('title', $titulo);
}
?>
<div class="ss-empty">
    <div class="ss-empty-icon"><i class="fa <?= $icone ?>" aria-hidden="true"></i></div>
    <h1 class="ss-empty-title"><?= $titulo ?></h1>
    <p class="ss-empty-text"><?= $texto ?></p>
    <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> ' . __('Voltar ao início'), '/',
            ['class' => 'btn btn-primary', 'escape' => false]) ?>
</div>
