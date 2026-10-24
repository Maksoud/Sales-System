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
 */
use App\Lib\DemoData;

$filhos = DemoData::filhos($usuario->id);
?>

<li>
    <a href="#" class="rede-pessoa" data-id="<?= $usuario->id ?>" title="<?= $filhos ? __('Clique para abrir/fechar os indicados') : __('Ninguém abaixo') ?>">
        <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'img-circle', 'style' => 'height: 40px; width: 40px;', 'alt' => '']) ?>
        <div>
            <?= h($usuario->nome) ?>
            <div class="clearfix"></div>
            <small><?= $this->Usuarios->plano($usuario) ?></small>
            <?php if ($filhos): ?>
                <div class="clearfix"></div>
                <small class="text-cinza"><i class="fa fa-sitemap" aria-hidden="true"></i> <?= count($filhos) ?></small>
            <?php endif; ?>
            <?php if ($usuario->status != 'A'): ?>
                <div class="clearfix"></div>
                <small class="label label-<?= $usuario->status == 'P' ? 'danger' : 'default' ?>"><?= mb_strtoupper($this->Usuarios->status($usuario->status)) ?></small>
            <?php endif; ?>
        </div>
    </a>
    <?php if ($filhos): ?>
        <ul <?= $nivel >= 1 ? 'style="display:none"' : '' ?>>
            <?php foreach ($filhos as $filho): ?>
                <?= $this->element('network-node', ['usuario' => $filho, 'nivel' => $nivel + 1]) ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</li>
