;
(function($) {
    $(document).ready(function($) {
        
        $('#senha, #nova-senha').on('keyup', function() {
            var senha1 = $('#senha').val(),
                senha2 = $('#nova-senha').val();
            
            if ( senha2 ) {
                var retorno  = '<div class="alert alert-warning" role="alert">A senha, nos campos de Nova Senha, tem que serem iguais</div>';
                
                $('#ajax-retorno').html('');
                
                if ( senha1 == senha2 ) {
                    $('#btn-mudar-senha').removeAttr('disabled');
                }else{
                    $('#btn-mudar-senha').attr('disabled', 'disabled');
                    
                    $('#ajax-retorno').append(retorno);
                }
            }
            
        });
        
        if (typeof multiselect != 'undefined' && $.isFunction(multiselect)) {
            $('#bancos').multiselect({
                enableFiltering: true,
                enableClickableOptGroups: true,
                enableCaseInsensitiveFiltering: true,
                inheritClass: true,
                buttonContainer: '<div />',
                maxHeight: 300,
                maxWidth: 317,
                dropUp: false
            });
        };
        
        //** end code **//
    });
})(jQuery);