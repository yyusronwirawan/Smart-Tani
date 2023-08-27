var $container = $('.map-js-container')
console.log($container.data('device'))
console.log($container.data('location'))

function initMap() {
    var device = $container.data('device')
    const map = new google.maps.Map(document.getElementById('mapJs'), {
        zoom: $container.data('zoom'),
        center: $('.map-js-container').data('location')[0],
        mapId: '2c1cc1d0308173cb'
    });
    // Create an array of alphabetical characters used to label the markers.
    const labels = device;
    // Add some markers to the map.
    // Note: The code uses the JavaScript Array.prototype.map() method to
    // create an array of markers based on a given "locations" array.
    // The map() method here has nothing to do with the Google Maps API.
    for (let i = 0; i < locations.length; i++) {
        const location = locations[i]
        console.log(location)
        new google.maps.Marker({
            position: location,
            map,
            title: labels[i]
        })
    }
    console.log(device)
}

const locations = $container.data('location')

function checkGeo(f) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(f, showError);
    } else {
        alert("Location is not supported by this device");
    }
}

$('#getLocation').on('click', function () {
    checkGeo(showPosition)
})

function showPosition(position) {
    var long = position.coords.longitude
    var lat = position.coords.latitude
    $('input#long').val(long)
    $('input#lat').val(lat)
}

$('.btn#mapPreview').on('click', function () {
    if (!$('input#long').val || !$('input#lat').val()) {
        alert('Input both longitude and latitude before using preview');
    } else {
        var img_url = "https://www.google.com/maps/embed/v1/place?q=" + $('input#lat').val() + "," + $('input#long').val() + "&key=AIzaSyBuA2OzJNAjDD_JBZ54SJAkfmONylNHOSo"
        $('.map-container').html('<iframe class="w-100 rounded" height="150" frameborder="0" style="border:0" src="' + img_url + '" allowfullscreen></iframe>');
    }
})

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
