<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script>
            /* Cor de um token do tema (--ss-*), para os gráficos seguirem o ss-theme.css */
            function ssCor(token) {
                return getComputedStyle(document.documentElement).getPropertyValue(token).trim();
            }

            Highcharts.setOptions({
                colors: ['--ss-primary-600', '--ss-gray-500', '--ss-info-solid', '--ss-warning-solid', '--ss-primary-200', '--ss-gray-300'].map(ssCor),
                chart: {
                    backgroundColor: 'transparent',
                    style: { fontFamily: ssCor('--ss-font-sans') }
                },
                title: { text: null },
                credits: { enabled: false },
                legend: { itemStyle: { fontSize: '12px', fontWeight: '500', color: ssCor('--ss-text-2') } },
                xAxis: { lineColor: ssCor('--ss-border-strong'), tickColor: ssCor('--ss-border-strong'), labels: { style: { color: ssCor('--ss-text-muted') } } },
                yAxis: { gridLineColor: ssCor('--ss-border'), labels: { style: { color: ssCor('--ss-text-muted') } }, title: { style: { color: ssCor('--ss-text-muted') } } },
                navigation: {
                    buttonOptions: { theme: { fill: 'transparent', stroke: 'transparent' }, symbolStroke: ssCor('--ss-text-muted') }
                },
                lang: {
                    loading: 'Aguarde...',
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    exportButtonTitle: 'Exportar',
                    printButtonTitle: 'Imprimir',
                    contextButtonTitle: 'Exportar gráfico',
                    printChart: 'Imprimir gráfico',
                    rangeSelectorFrom: 'De',
                    rangeSelectorTo: 'Até',
                    rangeSelectorZoom: 'Período',
                    downloadPNG: 'Baixar imagem PNG',
                    downloadJPEG: 'Baixar imagem JPEG',
                    downloadPDF: 'Baixar documento PDF',
                    downloadSVG: 'Baixar imagem SVG',
                    resetZoom: 'Desfazer zoom',
                    thousandsSep: '.',
                    decimalPoint: ','
                }
            });
        </script>
    </head>
    <body class="ss-report-page">
        <main class="ss-container ss-page">
            <?= $this->fetch('report-toolbar') ?>
            <article class="ss-report">
                <?= $this->fetch('content') ?>
            </article>
        </main>
        <footer class="ss-footer hidden-print">
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>
