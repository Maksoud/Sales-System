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
            <?= $this->Html->link(('<i class="fa fa-globe fa-fw" aria-hidden="true"></i> Regiões'), ['controller' => 'Regioes', 'action' => 'index'], ['class' => $regioes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-server fa-fw" aria-hidden="true"></i> Planos'), ['controller' => 'Planos', 'action' => 'index'], ['class' => $planos,'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-crosshairs fa-fw" aria-hidden="true"></i> Metas'), ['controller' => 'Metas', 'action' => 'index'], ['class' => $metas, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i> Comissões'), ['controller' => 'Comissoes', 'action' => 'index'], ['class' => $comissoes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-diamond fa-fw" aria-hidden="true"></i> Produtos'), ['controller' => 'Produtos', 'action' => 'index'], ['class' => $produtos, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> Usuários'), ['controller' => 'Usuarios', 'action' => 'index'], ['class' => $usuarios, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-archive fa-fw" aria-hidden="true"></i> Lista de Backups'), ['controller' => 'Pages', 'action' => 'list_backup'], ['class' => $backup, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-download fa-fw" aria-hidden="true"></i> Backup do Sistema'), ['controller' => 'Pages', 'action' => 'make_backup'], ['class' => 'list-group-item btn_modal', 'escape' => false, 'data-loading-text' => 'Carregando...', 'data-title' => 'Backup do Sistema']); ?>
            <?= $this->Html->link(('<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Log de Registros'), ['controller' => 'Registros', 'action' => 'index'], ['class' => $registros, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Log do Sistema'), ['controller' => 'Pages', 'action' => 'viewSystemLog'], ['target' => '_blank', 'class' => 'list-group-item', 'escape' => false, 'data-loading-text' => 'Carregando...', 'data-title' => 'Backup do Sistema']); ?>
            <?= $this->Html->link(('<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Log de Atualizações'), ['controller' => 'Pages', 'action' => 'viewUpdateLog'], ['target' => '_blank', 'class' => 'list-group-item', 'escape' => false, 'data-loading-text' => 'Carregando...', 'data-title' => 'Backup do Sistema']); ?>
        </div>
    </div>
</div>