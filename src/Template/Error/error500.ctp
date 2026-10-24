<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

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
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;

if (!Configure::read('debug')) {
    $this->assign('title', __('Algo deu errado'));
}
?>
<div class="ss-empty">
    <div class="ss-empty-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
    <h1 class="ss-empty-title"><?= __('Algo deu errado') ?></h1>
    <p class="ss-empty-text"><?= __('Não foi possível concluir a ação. Tente de novo em alguns minutos.') ?></p>
    <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> ' . __('Voltar ao início'), '/',
            ['class' => 'btn btn-primary', 'escape' => false]) ?>
</div>
