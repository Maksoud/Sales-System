<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <?= $this->element('chat') ?>
        <footer>
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>