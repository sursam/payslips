/* const locations = [
    {'name':'Mumbai', 'lat':19.0760,'lng':72.8777},
    {'name':'Pune', 'lat':18.5204,'lng':73.8567},
    {'name':'Bhopal', 'lat':23.2599,'lng':77.4126},
    {'name':'Agra', 'lat':27.1767,'lng':78.0081},
    {'name':'Delhi', 'lat':28.7041,'lng':77.1025},
    {'name':'Rajkot', 'lat':22.2734719,'lng':70.7512559}
]; */
let locations= JSON.parse($('.locations').val());
console.log(locations);
$(function () {
    initMap();
});
function initMap() {

    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {lat:32.70539257336434,lng:-117.10174020107274},
        // center: {lat:parseFloat(locations[17]['lat']),lng:parseFloat(locations[17]['lng'])},
    });
    var infowindow = new google.maps.InfoWindow();
    var marker;
    $.each(locations, function (key, value) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(value.lat, value.lng),
            map: map
        });
        google.maps.event.addListener(marker, 'click', (function(marker, key) {
            return function() {
              infowindow.setContent('<span class="fw-bold">Name:- </span>'+value.name+'<br><span class="fw-bold">Address:-</span> '+value.address);
              infowindow.open(map, marker);

            }
          })(marker, key));
    });
}

// window.initMap = initMap;
