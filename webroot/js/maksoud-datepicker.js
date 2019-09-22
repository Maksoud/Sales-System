/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
;
(function($) {
    $(document).ready(function($) {

        $('#dtinicial').on('change', function() {
            var pieces = $('#dtinicial').val().split('/');
            pieces.reverse();
            var reversed = pieces.join('/');
            
            $('#dtfinal').datepicker('setStartDate', new Date(reversed));
            $('#dtfinal').val("");
        });
        
        //controle do campo de data, mostrar ano e depois o mes para selecionar *sem dia
        $('input.datepicker').datepicker({
            orientation: 'top',
            format: "dd/mm/yyyy",
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true
        });
        
        //data de hoje
        var today = new Date(),
            dd    = today.getDate(),
            mm    = today.getMonth() + 1, //January is 0!
            yyyy  = today.getFullYear();
            
        if (dd < 10) dd = '0' + dd;
        
        if (mm < 10) mm = '0' + mm;
        
        today = dd + '/' + mm + '/' + yyyy;
        
        //campo de data valido de hoje para frente
        $('input.datepicker_hoje').datepicker({
            orientation: 'top',
            format: "dd/mm/yyyy",
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true,
            startDate: today
        });
        
        $('.controldate').bind('focusout', function() {
            var today = new Date(),
                dd    = today.getDate(),
                mm    = today.getMonth() + 1, //January is 0!
                yyyy  = today.getFullYear();
                
            if (dd < 10) {
                dd = '0' + dd;
            }
            
            if (mm < 10) {
                mm = '0' + mm;
            }
            
            today = dd + '/' + mm + '/' + yyyy;
            //document.write(today);
        });
        
    });
})(jQuery);