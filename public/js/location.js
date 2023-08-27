$('#getLocation').on('click', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Location is not supported by this device");
    }
})

function showPosition(position) {
    var long = position.coords.longitude
    var lat = position.coords.latitude
    $('input#long').val(long)
    $('input#lat').val(lat)

}
