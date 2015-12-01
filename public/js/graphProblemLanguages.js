/**
 * Created by Marco on 01/12/15.
 */
$(function () {

    var cData =$('#containerGraph').data('cnorm');
    var javaData =$('#containerGraph').data('java');
    var pythonData =$('#containerGraph').data('python');
    var cPlusData =$('#containerGraph').data('cplus');

    console.log(cData);
    console.log(javaData);
    console.log(pythonData);
    console.log(cPlusData);
    $('#containerGraph').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Lenguajes de soluciones'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {

            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: "Lenguajes",
            colorByPoint: true,
            data: [{
                name: "C",
                y: cData,
                sliced: true,
                selected: true
            }, {
                name: "C++",
                y: cPlusData
            }, {
                name: "Python",
                y: pythonData
            }, {
                name: "Java",
                y: javaData
            }]
        }]
    });
});