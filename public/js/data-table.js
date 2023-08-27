// Table Export
var $table = $('table');

$table.bootstrapTable({
    formatLoadingMessage: function(){
        return 'Loading'
    },
    formatNoMatches: function(){
        return 'Looks like we cannot find the data you are looking for'
    },
})

$table.bootstrapTable('destroy').bootstrapTable({
    exportDataType: 'all',
    exportTypes: ['csv', 'xlsx', 'pdf'],
});

// DateRange dateRange;

const today = new Date()
const lastMonth = new Date(today)

lastMonth.setMonth(lastMonth.getMonth() - 1)

today.toDateString()
lastMonth.toDateString()

$('input[name="daterange"]').daterangepicker({
    opens: 'left',
    maxDate: today,
    maxSpan: {
        month: 1
    },
    startDate: lastMonth,
    endDate: today
}, function (start, end, label) {
    var oldUrl = $table.data('url');
    var newStart = start.format('D-MM-YYYY')
    var newEnd = end.format('D-MM-YYYY')
    var newDate = {
        startDate: newStart,
        endDate: newEnd
    }
    var params = $.param(newDate)
    var newUrl = oldUrl.replace(oldUrl, oldUrl.split("?")[0] + '?' + params)

    $table.bootstrapTable('refresh', {
        url: newUrl
    })
});

function queryParams(params) {
    var options = $table.bootstrapTable('getOptions')
    if (!options.pagination) {
        params.limit = options.totalRows
    }
    return params
}
