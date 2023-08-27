$('.select-date-range').on('change', function () {
    getDataChart()
})

var dataChart = []
var labelChart = []
var listChart = []
var currentChart = null

function varChart(ctx, label, data, title){
    currentChart = new Chart(ctx, {
        type: $('.chart-type').val(),
        data: {
            labels: label,
            datasets: [{
                backgroundColor: "#DFEBFD",
                borderColor: "#3A85FB",
                label: title,
                data: data
            }]
        },
        options: {
            aspectRatio: 1
        }
    })
    return currentChart
}

function renderChart(label, data) {
    $('.chart-canvas').each(function (i) {
        var ctx = this.getContext('2d')
        var title = $(this).attr('data-title')
        var dataArray = []

        $.each(data, function(i){
            dataArray.push(data[i][title])
        })

        if(i >= listChart.length){
            listChart[i] = varChart(ctx, label, dataArray, title)
        }
        else{
            listChart[i].destroy()
            listChart[i] = varChart(ctx, label, dataArray, title)
            // currentChart = null
        }
    })
}

function getDataChart() {
    var $loading = $('.chart-loading').hide();

    $.ajax({
        url: $('.form-date-range').attr('data-url'),
        data: {
            range: $('.select-date-range').val(),
        },
        dataType: 'json',
        beforeSend: function() {
            $loading.show()
            $('.chart-canvas').hide()
        },
        success: function (result) {
            $loading.hide()
            $('.chart-canvas').show()
            var dataChart = []
            var labelChart = []
            $.each(result.array, function (i, item) {
                var data = item.data
                var label = item.date
                dataChart.push(data)
                labelChart.push(label)
            })

            renderChart(labelChart, dataChart)
        }
    })
}



getDataChart()
