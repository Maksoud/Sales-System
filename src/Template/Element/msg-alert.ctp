<?php if ( isset( $_GET['action'] ) && $_GET['action'] == 'ok' ): ?>
    <div class="row">
        <div id="ajax-sucesso-retorno" class="col-xs-12">
            <div class="alert alert-success" onclick="this.classList.add('hidden')" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-check" aria-hidden="true"></i> Registro gravado com sucesso
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ( isset( $_GET['action'] ) && $_GET['action'] == 'deleted' ): ?>
    <div class="row">
        <div id="ajax-sucesso-retorno" class="col-xs-12">
            <div class="alert alert-warning" onclick="this.classList.add('hidden')" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-check" aria-hidden="true"></i> Registro excluído com sucesso
            </div>
        </div>
    </div>
<?php endif; ?>
