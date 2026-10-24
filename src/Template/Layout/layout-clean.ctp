<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <?= $this->elementExists('chat') ? $this->element('chat') : '' ?>
        <footer class="ss-footer">
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>