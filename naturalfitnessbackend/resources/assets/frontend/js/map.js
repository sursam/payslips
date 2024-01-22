var map;
var postalCode = $('.postal_code').val(); // Replace with the postal code you want to display
var lat = $('.lat').val();
var lng = $('.long').val();
var councils = JSON.parse($('.councils').val());
var zones = JSON.parse($('.zones').val());
var mapId = $('.map_id').val();

$(function () {
    initMap();
});
let featureLayer;
async function initMap() {
    /*map = new google.maps.Map(
      document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: 'terrain'
    });

    if(typeof zones != 'undefined'){
        for (var i = 0; i < zones.length; i++) {
            const zoneArea = new google.maps.Polygon({
                paths: JSON.parse(zones[i].coordinates),
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
            });    
            zoneArea.setMap(map);
        }
    }
  
    //var markers = new Array();
    if(typeof councils != 'undefined'){
        for (var i = 0; i < councils.length; i++) {
        var latLng = new google.maps.LatLng(councils[i].lat, councils[i].long);
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            //label: councils[i].name,
            //title: councils[i].name
        });
    
        var infowindow = new google.maps.InfoWindow({
            content: councils[i].name + ""
        });
    
        google.maps.event.addListener(marker, 'click', function(marker, i) {
            return function() {
                openNav();
                //changeText();
                infowindow.setContent(councils[i].name + "");
                infowindow.open(map, marker);
            }
        }(marker, i));
        google.maps.event.addListener(map, 'click', function() {
            closeNav()
        });
        }
    }*/
    const states = [];
    if(typeof zones != 'undefined'){
        for (var i = 0; i < zones.length; i++) {
            let coordinateData = JSON.parse(zones[i].coordinates);
            for (var j = 0; j < coordinateData.length; j++) {
                states.push(coordinateData[j].place_id);
            }
        }
    }
    /*const states = [
        "ChIJdf5LHzR_hogR6czIUzU0VV4",
        "ChIJG8CuwJzfAFQRNduKqSde27w",
        "ChIJaxhMy-sIK4cRcc3Bf7EnOUI",
        "ChIJYSc_dD-e0ocR0NLf_z5pBaQ",
        "ChIJPV4oX_65j4ARVW8IJ6IJUYs",
        "ChIJt1YYm3QUQIcR_6eQSTGDVMc",
    ];*/
    console.log(states);

    const { Map } = await google.maps.importLibrary("maps");
    const map = new Map(document.getElementById("map"), {
        center: new google.maps.LatLng(lat, lng),
        zoom: 5,
        // In the cloud console, configure this Map ID with a style that enables the
        // "Administrative Area Level 1" feature layer.
        //mapId: "7ba16be0c9375fa7",
        mapId: mapId,
    });
    const featureLayer = map.getFeatureLayer(
        //google.maps.FeatureType.ADMINISTRATIVE_AREA_LEVEL_1,
        google.maps.FeatureType.POSTAL_CODE,
    );
    const featureStyleOptions = {
        strokeColor: "#810FCB",
        strokeOpacity: 1.0,
        strokeWeight: 3.0,
        fillColor: "#810FCB",
        fillOpacity: 0.5
    };

    featureLayer.style = (featureStyleFunctionOptions) => {
        if (states.includes(featureStyleFunctionOptions.feature.placeId)) {
            console.log(featureStyleFunctionOptions.feature.placeId);
            return featureStyleOptions;
        }
    };

    if(typeof councils != 'undefined'){
        for (var i = 0; i < councils.length; i++) {
        var latLng = new google.maps.LatLng(councils[i].lat, councils[i].long);
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            //label: councils[i].name,
            //title: councils[i].name
        });
    
        var infowindow = new google.maps.InfoWindow({
            content: councils[i].name + ""
        });
    
        google.maps.event.addListener(marker, 'click', function(marker, i) {
            return function() {
                openNav();
                //changeText();
                infowindow.setContent(councils[i].name + "");
                infowindow.open(map, marker);
            }
        }(marker, i));
        google.maps.event.addListener(map, 'click', function() {
            closeNav()
        });
        }
    }
}
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}
  
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
/*function initMap() {
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
}*/
