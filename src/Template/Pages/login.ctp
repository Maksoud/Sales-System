<?php $this->layout = 'layout-clean'; ?>
<?= $this->Html->css('login.css?ver=1.1.4') ?>

<div class="container">    
    <div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
    	<div class="row">
    		<div id="bg-login" class="top-45 bottom-20 col-xs-12">
    			<div class="top-50 col-xs-12">
    				<?= $this->Html->image(
        				    "Reiniciando.png",
        				    [
        				        'alt'   => 'Reiniciando',
                                'class' => 'img-responsive center-block'
                            ]) ?>
    			</div>
    			
    			<div class="top-50 col-xs-12">
        			<div class="bottom-10 col-xs-12">
        				<?= $this->Flash->render() ?>
        			</div>
        			
        			<?= $this->Form->create('Usuario') ?>
        			
        			<?php $liberado_temporariamente = true; ?>
        			<?php if ((isset($_GET['admin']) && $_GET['admin'] = 'sim') || $liberado_temporariamente ): ?>
            			<div class="row">
                        	<div class="col-xs-12 col-sm-offset-1 col-sm-10">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" name="login" id="login" class="form-control" placeholder="Login do usuário">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                        </div>
                                        <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha do usuário">
                                    </div>
                                </div>
                                
                                <div class="row">
                                	<div class="col-xs-offset-6 col-xs-6 col-sm-offset-7 col-sm-5">
                                		<button type="submit" class="btn btn-primary btn-block">
                                            Entrar
                                        </button>
                                	</div>
                                </div>
                        		
                                <p class="top-15 bottom-30 text-right cinza">
                                    <?php /*
                                    <a>
                                        <small>
                                            Esqueci minha senha, <strong>preciso de ajuda</strong>
                                        </small>
                                    </a>
                                    */ ?>
                                </p>
                        	</div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                        	<div class="col-xs-12 col-sm-offset-1 col-sm-10">
                            	<div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sistema em manutenção, por gentileza tente acessar novamente mais tarde
                                </div>
                        	</div>
                        </div>
                    <?php endif; ?>
                    <?= $this->Form->end() ?>
                    
    			</div>
    		</div>
    	</div>
    </div>
</div>


<?php
/*
    RECUPERAR SENHA ANTIGO
    
<div id="form_recuperar_senha" class="top-20 bottom-30 col-xs-12 collapse">
    <h3 style="color: #286090;" class="top-30 bottom-20">
        <i class="fa fa-sign-in font-24" aria-hidden="true"></i>
        Não consegue entrar?
    </h3>
    <p>
        Para recuperar sua senha, preencha o campo abaixo com seu e-mail cadastrado. Você irá receber um link para criar uma nova senha.
    </p>
    
    <?= $this->Form->create('Usuario', ['url' => ['action' => 'reenviaSenha']]) ?>
    <?= $this->Form->input('email', ['label' => false, 'class' => 'top-20 form-control', 'placeholder' => "E-mail do usuário"]) ?>
    <?= $this->Form->button('Obter nova senha', ['type' => 'submit', 'class' => 'top-30 col-xs-12 col-sm-6 col-md-5 btn btn-primary pull-left', 'div' => false]) ?>
    <?= $this->Form->end() ?>
    
    <div class="top-30 col-xs-12 col-sm-offset-1 col-sm-5 col-md-6">
        <a id="btn_voltar_login" class="top-10 bottom-20 pull-right btn btn-link semPadding pull-rigth">
            Voltar para login
        </a>
    </div>
</div>
*/
?>