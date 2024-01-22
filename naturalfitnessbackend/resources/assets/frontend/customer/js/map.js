var map;
var postalCode = $('.postal_code').val(); // Replace with the postal code you want to display
var lat= $('.lat').val();
var lng= $('.long').val();

$(function () {
    initMap();
});
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng }, // Center the map at your desired location or leave it at the default (0,0)
        zoom: 10 // Adjust the initial zoom level as needed
    });

    // Use the Geocoder to get the LatLng for the postal code
    var geocoder = new google.maps.Geocoder();
    var marker;
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),

        map: map
    });
    geocoder.geocode({ address: postalCode }, function (results, status) {
        if (status === 'OK') {
            var location = results[0].geometry.location;

            // Create a Circle around the postal code area
            var circle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: location,
                radius: 1000 // Adjust the radius as needed (in meters)
            });

            map.fitBounds(circle.getBounds());
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
