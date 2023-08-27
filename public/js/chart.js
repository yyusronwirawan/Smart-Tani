$('form .select-date-range').on('change', function () {
    var element = $(this).closest('.form-date-range-container').siblings()
    var range = $(this).val()
    getDataChart(element, range)
})

$('button.chart-refresh').on('click', function () {
    var element = $(this).parent().siblings()
    var range = element.find('.select-date-range:checked').val()
    getDataChart(element, range)
})

var dataChart = []
var labelChart = []
var listChart = {}
var currentChart = null

function varChart(ctx, label, data) {
    currentChart = new Chart(ctx, {
        type: 'line',
        // data: data,
        data: {
            labels: label,
            datasets: data
        },
        options: {
            aspectRatio: 1,
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0,
                    }
                }]
            }
        }
    })
    return currentChart
}


function renderChart(e, data) {
    e.find('.chart-canvas').each(function (i) {
        var parentArray = []
        var parentParentArray = []
        var dataArray = []
        var ctx = this.getContext('2d')
        var dataset = $(this).attr('data-title')
        dataArray = []

        data.datasets.forEach(function (i) {
            dataArray = []
            i.data.forEach(function (item) {
                dataArray.push(item[dataset])
            })
            parentArray = {
                backgroundColor: "rgba(0, 0, 0, 0)",
                borderColor: i.borderColor,
                borderWidth: 3,
                label: i.label,
                data: dataArray,
                pointRadius: 0,
                pointHitRadius: 4,
                lineTension: 0.2,
            }
            parentParentArray.push(parentArray)
        })

        var key = $(this).closest('.chart-container').parent().data('id') + dataset


        if (!(key in listChart))
            listChart[key] = varChart(ctx, data.labels, parentParentArray)
        else {
            listChart[key].destroy()
            listChart[key] = varChart(ctx, data.labels, parentParentArray)
        }
    })
}

function getDataChart(element, range) {
    var chart = element
    var $loading = chart.find('.chart-loading').hide()
    var $refresh = chart.find('.chart-refresh').hide()
    var $error = chart.find('.chart-error').hide()
    var $canvas = chart.find('.chart-canvas').hide()
    var $url = chart.find('.chart-canvas').data('url').replace('&amp;', '&')
    // var $range = chart.find('form .select-date-range:checked')
    console.log(range)

    $.ajax({
        url: $url,
        data: {
            range: range,
        },
        dataType: 'json',
        beforeSend: function () {
            $error.hide()
            $loading.show()
            $refresh.hide()
            $canvas.hide()
        },
        success: function (result) {
            $canvas.show()
            renderChart(element, result)
        },
        error: function (result) {
            $error.show().html('<i class="fas fa-exclamation-triangle"></i> ' + result.responseJSON.message)
        },
        complete: function () {
            $refresh.show()
            $loading.hide()
        }
    })
}

$('.chart-container').each(function () {
    var element = $(this)
    var range = element.find('form .select-date-range').val()
    getDataChart(element, range)
})
