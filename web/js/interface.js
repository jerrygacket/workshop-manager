let baseUri = window.location.origin;

var chartZone = document.getElementById('chartZone');

charts = getSalesCharts();
setCharts(charts);

function setCharts(charts) {
    if (charts.length === 0) {
        return;
    }
    // clearList(document.getElementById('FormPrinterSelect'));
    while (document.getElementById('FormPrinterSelect').length > 0) {
        document.getElementById('FormPrinterSelect').remove(document.getElementById('FormPrinterSelect').length - 1)
    }
    charts.forEach(el => {
        let div = document.createElement('option');
        div.className = 'col-md-3';
        div.innerHTML = '<div class="chart-container"><canvas id="chart-'+el.id+'"></canvas></div>';
        chartZone.append(div);
        document.body.append(div);
    });
}

