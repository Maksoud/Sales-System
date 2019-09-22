;
(function($) {
    $(document).ready(function($) {
        /**********************************************************************/
        //EVITA MULTIPLOS CADASTROS AO SER PRESSIONADO DIVERSAS VEZES O BOTÃO GRAVAR
        $('input[type="submit"]').on('click', function() {
            $(this).attr('id', 'submit');
            setTimeout(function () {$('#submit').attr('type', 'button');}, 100); //possibilita as validações de preenchimento
            setTimeout(function () {$('#submit').attr('type', 'submit');}, 2000);//impossibilita o clique múltiplo
        });
        /**********************************************************************/
        
        //CONTROLA VISUALIZAÇÃO DE SENHA NO LOGIN
        $('#btn_esqueci_senha, #btn_voltar_login').on('click', function() {
            $('#form_entrar').collapse('toggle');
            $('#form_recuperar_senha').collapse('toggle');
        });
        
        //visualizar senha no login
        var ver_senha = false;

        $('#form_entrar .add-on').on('click', function () {
            if (!ver_senha) {
                $('#login_senha').attr('type', 'text');
                $('.fa-eye').removeClass('fa-eye').addClass('fa-eye-slash');
                ver_senha = true;
            } else {
                $('#login_senha').attr('type', 'password');
                $('.fa-eye-slash').removeClass('fa-eye-slash').addClass('fa-eye');
                ver_senha = false;
            }

            return false;
        });
        /**********************************************************************/
        //CONTROLA O RELÓGIO DO SISTEMA
        /*
        var myVar = setInterval(myTimer, 1000);
        
        function myTimer() {
            var d = new Date();
            document.getElementById("timer").innerHTML = d.toLocaleTimeString();
        }
        */
        /**********************************************************************/
        //CONTROLA O SCROLLDOWN 
        $(".scroll").click(function(event) {		
            event.preventDefault();
            $('html,body').animate({
                scrollTop:$(this.hash).offset().top + 1000
            }, 800);
        });
        
        $(".scroll-modal").click(function(event) {		
            event.preventDefault();
            $('#modal_item').animate({
                scrollTop:$(this.hash).offset().top + 500
            }, 800);
        });
        /**********************************************************************/
        //EVITA MULTIPLOS CADASTROS AO SER PRESSIONADO DIVERSAS VEZES O BOTÃO GRAVAR
        $('input[type="submit"]').on('click', function() {
            $(this).attr('id', 'submit');
            setTimeout(function () {$('#submit').attr('type', 'button');}, 100); //possibilita as validações de preenchimento
            setTimeout(function () {$('#submit').attr('type', 'submit');}, 2000);//impossibilita o clique múltiplo
        });
        /**********************************************************************/
        //AJUSTA VISUAL DA TABELA INDEX (LISTAGENS) PARA CONDENSADO QUANDO A TELA POSSUIR TAMANHO PEQUENO
        function sizeOfThings() {
            var windowWidth = window.innerWidth;
            //var windowHeight = window.innerHeight;
            //var screenWidth = screen.width;
            //var screenHeight = screen.height;
            
            if (windowWidth < 1305) {
                $("#adjustable").addClass("table-condensed");
            } else {
                $("#adjustable").removeClass("table-condensed");
            }
            
            //document.querySelector('.window-size').innerHTML = windowWidth + 'x' + windowHeight;
            //document.querySelector('.screen-size').innerHTML = screenWidth + 'x' + screenHeight;
        };
        
        sizeOfThings();

        window.addEventListener('resize', function () {
            sizeOfThings();
        });
        /**********************************************************************/
        //controle abrir modal
        $('.btn_modal').on('click', function(e) {
            var this_js = $(this),
                btn     = this_js.button('loading'),
                url     = this_js.attr('href'),
                titulo  = this_js.attr('data-title'),
                tamanho = this_js.attr('data-tamanho'),
                img     = this_js.attr('data-img');
            
            if ( tamanho == 'sm' )
                $('#modal_item .modal-lg').removeClass('modal-lg').addClass('modal-sm');
            else
                $('#modal_item .modal-sm').removeClass('modal-sm').addClass('modal-lg');
            
            $('#modal_item_body').html(''); //limpar modal
            $('#modal_item_title').html(''); //limpar titulo do modal
            $('#modal_item_title').append(titulo); //colocar o novo titulo do modal
            
            if ( img ) {
                url_img  = '<div class="container-fluid">';
                url_img += '    <div class="col-xs-12">';
                url_img += '        <img class="img-responsive center-block" src="' + this_js.find('img').attr('src') + '">';
                url_img += '    </div>';
                url_img += '</div>';
                
                $('.modal-body').append(url_img);
                btn.button('reset'); //voltar estado do btn
                $('#modal_item').modal('toggle'); //abrir modal
                
            }else{
                $.get(url,
                        { titulo: titulo },
                        function(data) {
                            $('.modal-body').append(data); //colocar no modal o formulario de edicao
                        }
                     )
                .done(function() {
                    btn.button('reset'); //voltar estado do btn
                    $('#modal_item').modal('toggle'); //abrir modal com o formulario
                })
                .fail(function() {
                    confirm('Desculpe, ocorreu um erro. Por favor atualize a pagina e tente novamente.');
                    location.reload();
                });
            }

            e.preventDefault();
        });

        //colocar o ponteiro no primeiro campo
        $('#modal_item').on('shown.bs.modal', function () {
            $('.focus').focus();
        });
        
        /**********************************************************************/
        //MULTISELECT ON SHIFT IN CHECKBOX
        var lastChecked = null;
        var handleChecked = function(e) {
            if (lastChecked && e.shiftKey) {
                var i = $('input[type="checkbox"]').index(lastChecked);
                var j = $('input[type="checkbox"]').index(e.target);
                var checkboxes = [];
                if (j > i) {
                    checkboxes = $('input[type="checkbox"]:gt('+ (i-1) +'):lt('+ (j-i) +')');
                } else {
                    checkboxes = $('input[type="checkbox"]:gt('+ j +'):lt('+ (i-j) +')');
                }
                if (!$(e.target).is(':checked')) {
                    $(checkboxes).removeAttr('checked');
                } else {
                    $(checkboxes).attr('checked', 'checked');
                }
            }
            lastChecked = e.target;
            // Other click action code.
        };
        
        $('input[type=checkbox]').click(handleChecked);
        
        //select all checkboxes
        $("#select_all").change(function() { 
            //change all "input[type=checkbox]" checked status
            $('input[type=checkbox]').prop('checked', $(this).prop("checked")); 
        });
        
        $('input[type=checkbox]').change(function() { 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (false == $(this).prop("checked")) { //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('input[type=checkbox]:checked').length == $('input[type=checkbox]').length ) {
                $("#select_all").prop('checked', true);
            }
        });
        /**********************************************************************/
        
        // esconder|mostrar botao de resetar a busca
        var query     = location.search.slice(1),
            partes    = query.split('&'),
            dados_get = [];
            
        partes.forEach(function (parte) {
            var chaveValor = parte.split('='),
                chave = chaveValor[0],
                valor = chaveValor[1];
            
            dados_get[chave] = valor;
        });
        
        if ( dados_get['iniciar_busca'] ) $('#btn-resetar-form').toggle('slow');
        
        
        //paginacao
        $('#adjustable').DataTable({
            'order': [[ 0, 'desc' ]],
            'searching': false,
            'language': {
                'lengthMenu': 'Mostrando _MENU_ registros por página',
                'zeroRecords': 'Nada encontrado',
                'info': 'Mostrando página _PAGE_ de _PAGES_',
                'infoEmpty': 'Nenhum registro disponível',
                'infoFiltered': '(Filtrado de _MAX_ registros no total)',
                //'sSearch': 'Localizar:',
                'oPaginate': {
                    'sNext': 'Próximo',
                    'sPrevious': 'Anterior'
                }
            }, 'lengthMenu': [10, 20, 30]
        });
        
        //controle forma de pagamento loja virtual
        $('#tipos_de_pagamentos a').on('show.bs.tab', function(e) {
            var tipo_escolhido = $(e.target).attr('href');
            
            if ( tipo_escolhido == '#forma_cartao' )
                $('#forma_pagamento_opcao1').prop( 'checked', true );
            else if ( tipo_escolhido == '#forma_deposito' )
                $('#forma_pagamento_opcao5').prop( 'checked', true );
            else if ( tipo_escolhido == '#forma_boleto' )
                $('#forma_pagamento_opcao6').prop( 'checked', true );
        });
        
        //** end code **//
    });
})(jQuery);
