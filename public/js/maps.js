/**
 * Created by mnvoh on 8/7/15.
 */
var map;
var markersArray = [];

$(function() {
    var curLat = parseFloat($('input#clinicLat').val());
    var curLng = parseFloat($('input#clinicLng').val());

    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
        center: new google.maps.LatLng(35.696814, 51.3498186),
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(mapCanvas, mapOptions)

    // add a click event handler to the map object
    google.maps.event.addListener(map, "click", function(event)
    {
        // place a marker
        placeMarker(event.latLng);

        // display the lat/lng in your form's lat/lng fields
        document.getElementById("clinicLat").value = event.latLng.lat();
        document.getElementById("clinicLng").value = event.latLng.lng();
    });

    if(curLat !== NaN && curLng !== NaN) {
        placeMarker({lat: curLat, lng: curLng});
    }
});

function placeMarker(location) {
    // first remove all markers if there are any
    deleteOverlays();

    var marker = new google.maps.Marker({
        position: location,
        map: map
    });

    // add marker in markers array
    markersArray.push(marker);
}

// Deletes all markers in the array by removing references to them
function deleteOverlays() {
    if (markersArray) {
        for (i in markersArray) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }
}