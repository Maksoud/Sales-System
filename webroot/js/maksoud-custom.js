/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
;
(function($) {
    $(document).ready(function($) {

        var context = $('#logo').attr('data-url');
        
        //MONEY, PHONE, DATE MASK
        var mask = {            
            money: function() {                
                var el = this
                ,exec = function(v) {
                    v = v.replace(/\D/g, '');
                    v = new String(Number(v));
                    var len = v.length;

                    if (len == 1) {
                        v = v.replace(/(\d)/, '0,0$1');
                    }                   
                    else if (len == 2) {
                        v = v.replace(/(\d)/, '0,$1');
                    }                   
                    else if (len > 2 && len <= 5) {
                        v = v.replace(/(\d{2})$/, ',$1');
                    }
                    else if (len > 5) {
                       v = v.replace(/(\d{2})$/, ',$1').replace(/\d(?=(?:\d{3})+(?:\D|$))/g, '$&.');
                    }
                    return v;
                };

                setTimeout(function() {
                    el.value = exec(el.value);
                },1);
            },
            phone: function() {
                var phone, element;
                element = $(this);
                phone = element.val().replace(/\D/g, '');
                var len = phone.length;
                
                if (len > 10) {
                    element.inputmask("(99) 99999-9999");
                } else {
                    element.inputmask("(99) 9999-9999#");
                }
            },
            date: function() {
                var date, element;
                element = $(this);
                date = element.val().replace(/\D/g, '');
                element.inputmask("99/99/9999");
            }
        };        
        
        /**********************************************************************/
        
        //Máscara de telefone
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
          },
          spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
              }
          };
        //$('.sp_celphones').mask(SPMaskBehavior, spOptions);
        
        /**********************************************************************/
        
        //Formata valor para padrão brasileiro (9.999,00)
        function Real(v)
        {
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0,0$1');
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, '0,$1');
            }                   
            else if (len > 2 && len <= 5) {
                v = v.replace(/(\d{2})$/, ',$1');
            }
            else if (len > 5) {
               v = v.replace(/(\d{2})$/, ',$1').replace(/\d(?=(?:\d{3})+(?:\D|$))/g, '$&.');
            }
            return v;
        };
        //Formata valor para padrão americano (9999.00)
        function Dolar(v)
        {
            v = v.replace(/\D/g, '');
            v = new String(Number(v));
            var len = v.length;

            if (len == 1) {
                v = v.replace(/(\d)/, '0.0$1');
            }                   
            else if (len == 2) {
                v = v.replace(/(\d)/, '0.$1');
            }                   
            else if (len > 2) {
                v = v.replace(/(\d{2})$/, '.$1');
            }
            return v;
        };
        
        /******************************************************************/
        //Função calcular valor total e frete do pedido
        
        var form_loja_liberado = false;
        
        function CalculaTotal()
        {
            var valor_total      = 0,
                valor_unitario   = 0,
                quantidade       = 0,
                valor_total_prod = 0,
                forma_pagamento  = 'A';
            
            form_loja_liberado = false;
            
            $('.item_produto').each(function() {
                valor_unitario = Number( Dolar( $(this).find('.valor_unit').html() ) );
                quantidade = Number( $(this).find('input[type="number"]').val() );
                
                valor_total_prod = valor_unitario * quantidade;
                valor_total += valor_total_prod;
                
                valor_total_prod = Number(valor_total_prod).toFixed(2);
                valor_total_prod = Real(valor_total_prod);
                $(this).find('.valor_total_prod').html(valor_total_prod);
                
                if ( quantidade > 0 ) form_loja_liberado = true;
            });
            
            forma_pagamento = $('select[id=forma_pagamento] option:selected').val();
            
            if ( forma_pagamento == 'A' ) valor_total = valor_total - (valor_total * 0.1); //10% de desconto para pagamento à vista
            
            valor_total = Number(valor_total).toFixed(2);
            valor_total = Real(valor_total);
            
            $('#valor_total').html(valor_total);
        }
        
        $('.item_produto input[type=number]').on('change', function() {
            CalculaTotal();
        });
        
        $('#form-loja').on('submit', function(e) {
            if ( !form_loja_liberado ) {
                var btn_close_alert = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
                    retorno  = '<div class="alert alert-danger" role="alert">' + btn_close_alert + 'Por favor informe uma quantidade para qualquer um dos produtos disponíveis</div>';
                
                $('#ajax-retorno').html(''); //limpar a div que aparece os retornos
                $('#ajax-retorno').append(retorno); //informar msg principal de erro
                
                e.preventDefault();
            }
        });
        
        /**********************************************************************/
        //Mascaras
        $('.cpfmask').mask('000.000.000-00');
        $('.cnpjmask').mask('00.000.000/0000-00');
        
        $('.datemask').mask('00/00/0000');
        $('.phonemask').mask(SPMaskBehavior, spOptions);
        $('.cepmask').mask('00000-000');
        $('.ordermask').mask('00.00.00.00', {'translation': {0: {pattern: /[0-9]/}}});
        $('.moneymask').mask('000.000.000.000,00', {reverse: true});
        $('.valuemask').maskMoney({showSymbol: false, symbol: "R$ ", decimal: ",", thousands: "."});
        
        //ativar tooltip
        $('[data-toggle="tooltip"]').tooltip();
        
        
        //tudo que ativar fora, se quiser dentro do modal tem que ativar abaixo tb
        $('#modal_item').on('shown.bs.modal', function () {
            
            //Mascaras
            $('.cpfmask').mask('000.000.000-00');
            $('.cnpjmask').mask('00.000.000/0000-00');
            
            $('.datemask').mask('00/00/0000');
            $('.phonemask').mask(SPMaskBehavior, spOptions);
            $('.cepmask').mask('00000-000');
            $('.ordermask').mask('00.00.00.00', {'translation': {0: {pattern: /[0-9]/}}});
            $('.moneymask').mask('000.000.000.000,00', {reverse: true});
            $('.valuemask').maskMoney({showSymbol: false, symbol: "R$ ", decimal: ",", thousands: "."});
            
            //ativar tooltip
            $('[data-toggle="tooltip"]').tooltip();
            
        });
        
        //controlar start ajax
        $(document).ajaxStart(function() {
            $('.bg_ajax').removeClass('hide');
        });
        
        //controlar end ajax
        $(document).ajaxComplete(function() {
            $('.bg_ajax').addClass('hide');
        });
        
        //funcao para envio de form via ajax (post)
        $(document).on('submit', '.ajax', function(e) {
            
            var url   = context + $(this).attr('data-url'); //url para envio do form
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data, status) {
                    var btn_close_alert = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    
                    //caso já tenha dado algum erro, remover as class de erro
                    $('.has-error').removeClass('has-error');
                    
                    if ( data['status'] == 'error' ) {
                        var retorno  = '<div class="alert alert-danger" role="alert">' + btn_close_alert + data['mensagem'] + '</div>';
                        
                        $('#ajax-retorno').html(''); //limpar a div que aparece os retornos
                        $('#ajax-retorno').append(retorno); //informar msg principal de erro
                        
                        console.log('/*******************/');
                        console.log(data['mensagem']);
                        
                        //ir buscar as msgs secundarias com os erros ocorridos
                        for( var key in data['errors'] ) {
                            
                            $('[name=' + key + ']').focus().parent().addClass('has-error');
                            
                            for( var key2 in data['errors'][key] ) {
                                $('[name=' + key + ']').parent().append('<span class="help-block"><small>' + data['errors'][key][key2] + '</small></span> ');
                                
                                console.log(data['errors'][key][key2]);
                            }
                        }
                        
                        console.log('/*******************/');
                        
                    } else {
                        var retorno = '<div class="alert alert-success" role="alert">' + btn_close_alert + data['mensagem'] + '</div>';
                        
                        //$('#ajax-sucesso-retorno').html(''); //limpar a div que aparece os retornos
                        //$('#ajax-sucesso-retorno').append(retorno); //informar msg principal de sucesso
                        //$('#modal_item').modal('hide'); //fecha modal
                        window.location.href = window.location.href.replace( /[\?#].*|$/, "?action=ok" );
                    }
                },
                error: function (xhr, desc, err) {
                    var btn_close_alert = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
                        retorno  = '<div class="alert alert-danger" role="alert">' + btn_close_alert + xhr['responseText'] + '</div>';
                    
                    $('#ajax-retorno').html(''); //limpar a div que aparece os retornos
                    $('#ajax-retorno').append(retorno); //informar msg principal de erro
                    
                    console.log('/*******************/');
                    console.log(xhr);
                    console.log(desc);
                    console.log(err);
                    console.log('/*******************/');
                }
            });
            
            e.preventDefault();
        });
        
        //** end code **//
    });
})(jQuery);