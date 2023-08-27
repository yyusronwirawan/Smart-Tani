function readControl() {
    $('.device-status').each(function () {
        var $url = $(this).attr('data-url')
        var status = $(this).find('.device-toggle')
        var updated = $(this).find('.last-updated')
        var houseId = $(this).data('house')

        var $garden = $(this).find('.garden-toggle')
        var $lamp = $(this).find('.lamp-toggle')
        var $sensor = $(this).find('.lamp-sensor')
        var $lock = $(this).find('.door-lock')
        var $security = $(this).find('.door-security')
        $.ajax({
            url: $url,
            success: function (result) {
                var control = result.nilai
                switch (result.device_type) {
                    case 'door':
                        switch (control) {
                            case '1':
                                $lock.html('<i class="fa fa-lock" aria-hidden="true"></i>')
                                break
                            case '0':
                                $lock.html('<i class="fa fa-unlock text-secondary" aria-hidden="true"></i>')
                                break
                            default:
                                $lock.html('<i title="' + result.message + '" class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>')
                                break
                        }
                        switch (result.security) {
                            case '1':
                                $security.html('<i class="fa fa-shield" aria-hidden="true"></i>')
                                break
                            case '0':
                                $security.html('<i class="fa fa-shield text-secondary" aria-hidden="true"></i>')
                                break
                            default:
                                $security.html('<i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>')
                                break
                        }
                        break
                    case 'garden':
                        $garden.text(result.message)
                        break
                    case 'lamp':
                        $sensor.text(result.message)
                        switch (control) {
                            case '0':
                                $lamp.html('<i class="fas fa-lightbulb text-secondary"></i>')
                                break
                            case '1':
                                $lamp.html('<i class="fas fa-lightbulb"></i>')
                                break
                            default:
                                $lamp.html('<i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>')
                                break
                        }
                        default:
                            break
                }
                updated.data('updated', result.timestamp)
                $('.time-now').data('time', Math.round((new Date()).getTime() / 1000))
            },
            error: function (result) {
                console.log(result.message)
            },
        })
    })
}

setInterval(readControl, 5000)
