<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

$regioes = $planos = $metas = $comissoes = $produtos = $usuarios = $backup = $avisos = $registros = 'list-group-item ';
if ($this->request->url == 'regioes')               $regioes   .= 'active';
elseif ($this->request->url == 'planos')            $planos    .= 'active';
elseif ($this->request->url == 'metas')             $metas     .= 'active';
elseif ($this->request->url == 'comissoes')         $comissoes .= 'active';
elseif ($this->request->url == 'produtos')          $produtos  .= 'active';
elseif ($this->request->url == 'usuarios')          $usuarios  .= 'active';
elseif ($this->request->url == 'pages/list-backup') $backup    .= 'active';
elseif ($this->request->url == 'registros')         $registros .= 'active';
?>

<div class="hidden-xs col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <?= $this->Html->link(('<i class="fa fa-globe fa-fw" aria-hidden="true"></i> Regiões'), ['controller' => 'Pages', 'action' => 'regioesIndex'], ['class' => $regioes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-server fa-fw" aria-hidden="true"></i> Planos'), ['controller' => 'Pages', 'action' => 'planosIndex'], ['class' => $planos,'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-crosshairs fa-fw" aria-hidden="true"></i> Metas'), ['controller' => 'Pages', 'action' => 'metasIndex'], ['class' => $metas, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i> Comissões'), ['controller' => 'Pages', 'action' => 'comissoesIndex'], ['class' => $comissoes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-diamond fa-fw" aria-hidden="true"></i> Produtos'), ['controller' => 'Pages', 'action' => 'produtosIndex'], ['class' => $produtos, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> Usuários'), ['controller' => 'Pages', 'action' => 'usuariosIndex'], ['class' => $usuarios, 'escape' => false]); ?>
        </div>
    </div>
</div>