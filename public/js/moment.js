function update() {
    $('.last-updated').each(function () {
        var relative = moment($(this).data('updated'), "DD/MM/YYYY HH:mm:ss").locale('id').fromNow()
        $(this).text(relative)
    })
    $('.time-now').text(moment($(".time-now").data('time'), "X").locale('id').fromNow())
    $('.current-time').text(moment().locale('id').format('MMMM Do YYYY, h:mm:ss a'))
}

function resetTimeNow(){
    var momentNow = moment(now(), "x").locale('id').fromNow()
    $('time-now').text(momentNow)
    console.log(momentNow)
}

$('.date-created').text(moment($('.date-created').attr('data-created'), "YYYY-MM-DD").locale('id').format('MMMM Do YYYY'))

setInterval(update, 1000);
