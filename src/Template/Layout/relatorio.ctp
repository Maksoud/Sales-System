<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script>
            Highcharts.setOptions({
                lang: {
                loading: 'Aguarde...',
                months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                shortMonths: ['Jan', 'Feb', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                exportButtonTitle: "Exportar",
                printButtonTitle: "Imprimir",
                rangeSelectorFrom: "De",
                rangeSelectorTo: "Até",
                rangeSelectorZoom: "Periodo",
                downloadPNG: 'Download imagem PNG',
                downloadJPEG: 'Download imagem JPEG',
                downloadPDF: 'Download documento PDF',
                downloadSVG: 'Download imagem SVG',
                resetZoom: "Resetar Zoom"
                // resetZoomTitle: "Reset,
                // thousandsSep: ".",
                // decimalPoint: ','
                }
          });
        </script>
        <style>
        body{background: none;}
        </style>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <footer>
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>