<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<<', ['tag' => 'li', 'disabledTag' => 'a']) ?>
        <?= $this->Paginator->prev('<', ['tag' => 'li', 'disabledTag' => 'a']) ?>
        <?= $this->Paginator->numbers(['tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'separator' => '']) ?>
        <?= $this->Paginator->next('>', ['tag' => 'li', 'disabledTag' => 'a']) ?>
        <?= $this->Paginator->last('>>', ['tag' => 'li', 'disabledTag' => 'a']) ?>
    </ul>
    <div style="margin-bottom: 40px; margin-top: -10px;">
        <?= $this->Paginator->counter('Página {{page}} de {{pages}}') ?>
    </div>
</div>