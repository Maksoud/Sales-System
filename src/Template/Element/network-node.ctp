<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/network-node.ctp */

/**
 * Pessoa na árvore da Minha Rede e, recursivamente, seus indicados.
 * Variáveis: $usuario, $nivel (0 = raiz). Só o primeiro nível abaixo da raiz começa aberto.
 * Quem tem indicados é um link (.rede-pessoa) que abre/fecha a lista; quem não tem é só um card.
 */
use App\Lib\DemoData;

$filhos = DemoData::filhos($usuario->id);
$aberto = $nivel < 1;

ob_start();
?>
    <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'ss-avatar ss-avatar--sm', 'alt' => '']) ?>
    <span class="ss-net-node-body">
        <span class="ss-net-node-name"><?= h($usuario->nome) ?></span>
        <span class="ss-net-node-login"><?= h($usuario->login) ?></span>
        <span class="ss-net-node-meta">
            <?= $this->Usuarios->plano($usuario) ?>
            <?php if ($usuario->status != 'A'): ?>
                <?= $this->Usuarios->statusLabel($usuario->status) ?>
            <?php endif; ?>
            <?php if ($filhos): ?>
                <span title="<?= __('Indicados diretos') ?>">
                    <i class="fa fa-sitemap" aria-hidden="true"></i> <?= count($filhos) ?>
                    <span class="sr-only"><?= __('indicados diretos') ?></span>
                </span>
            <?php endif; ?>
        </span>
    </span>
<?php $card = ob_get_clean(); ?>

<li>
    <?php if ($filhos): ?>
        <a href="#" class="rede-pessoa ss-net-node" data-id="<?= $usuario->id ?>" role="button"
           aria-expanded="<?= $aberto ? 'true' : 'false' ?>" title="<?= __('Abrir ou fechar os indicados') ?>"><?= $card ?></a>
        <ul <?= $aberto ? '' : 'style="display:none"' ?>>
            <?php foreach ($filhos as $filho): ?>
                <?= $this->element('network-node', ['usuario' => $filho, 'nivel' => $nivel + 1]) ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <span class="ss-net-node" data-id="<?= $usuario->id ?>"><?= $card ?></span>
    <?php endif; ?>
</li>
