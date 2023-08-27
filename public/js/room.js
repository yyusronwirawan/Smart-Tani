//Rooms
function rooms() {
    $.ajax({
        url: getRooms(),
        dataType: 'json',
        success: function (result) {
            $.each(result, function (i, item) {
                $('#room').append($('<option>', {
                    value: item.toLowerCase(),
                    text: item
                }))
            })
            $('#room').val(dataRooms())
        }
    })
}

function getRooms() {
    var roomUrl = $('.form-control#room').attr('data-url')
    return roomUrl
}

function dataRooms() {
    var room = $('.form-control#room').attr('data-room')
    return room
}

rooms();
