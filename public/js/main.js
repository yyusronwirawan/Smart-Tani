$(document).ready(function () {
    function removeWarning() {
        if ($('.invalid-feedback,.is-invalid').length) {
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
        }
    }

    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html")
        return doc.documentElement.textContent
    }

    new ClipboardJS('.btn');

    $('.carousel-indicators').click(false);

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    var addDevice = getUrlParameter('addDevice')
    var errorPane = getUrlParameter('errorPane')

    if (errorPane == 'true') {
        $('#settingsTab').tab('show')
    }

    if (addDevice == 'true') {
        $('#modelAddDeviceId').modal('show')
    }

    $('a#setupLink').on('click', function () {
        $('#setupTab').tab('show')
    })
})
