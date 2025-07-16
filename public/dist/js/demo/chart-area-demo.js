// Set default font dan warna seperti Bootstrap
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Format angka
function number_format(number, decimals = 0, dec_point = ',', thousands_sep = '.') {
    number = (number + '').replace(',', '').replace(' ', '');
    let n = !isFinite(+number) ? 0 : +number,
        prec = Math.abs(decimals),
        sep = thousands_sep,
        dec = dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            let k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    if ((s[1] || '').length < prec) s[1] = (s[1] || '') + '0'.repeat(prec - s[1].length);
    return s.join(dec);
}

// Ambil data dari input hidden
const labels = JSON.parse(document.getElementById("chart-labels").value);
const values = JSON.parse(document.getElementById("chart-values").value);

// Inisialisasi chart
const ctx = document.getElementById("myAreaChart");
const myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: "Penjualan",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.2)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: values,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: { left: 10, right: 25, top: 25, bottom: 0 }
        },
        scales: {
            xAxes: [{
                gridLines: { display: false, drawBorder: false },
                ticks: { maxTicksLimit: 7 }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value) {
                        return 'Rp' + number_format(value);
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: { display: false },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    return 'Rp' + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});
