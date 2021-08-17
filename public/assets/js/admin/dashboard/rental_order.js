
function showStationsDetails(date)
{
    let url = Routing.generate('admin_rent_details_ajax', {
        'date': date,
    });

    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (data) { // Remove current options
            $('#equipment_details').html('');

            listStationsEquipmentsRentalOrderDetails(data['equipments_ details']);
            listAvailableEquipmentsPerStation(data['equipments_available']);
        },
        error: function (err) {
            alert("An error ocurred while loading data ...");
        }

    });
}

function listStationsEquipmentsRentalOrderDetails($equipments)
{
    if( $equipments.length === 0 ) {
        $('#equipment_details').append('<h3> No rental orders for today ! :( </h3>');
        return false;
    }

    $.each($equipments, function(station,types) {
        $('#equipment_details').append('<h3> Equipments booked at '+ station+'</h3>').append('<ul>');
        $.each(types, function(key,value) {
            $('#equipment_details').append('<li>' + value['type']+ ' x ' +value['count'] +'</li>');
        });
    });
}

function listAvailableEquipmentsPerStation($equipments)
{
    $('#equipment_details').append('<hr>')
        .append('<h3> Equipments Available</h3>')
        .append('<ul>');
    $.each($equipments, function(key,count) {
        $('#equipment_details').append('<li>' + key + ': ' + count +'</li>');
    });
    $('#equipment_details').append('</ul>');
}