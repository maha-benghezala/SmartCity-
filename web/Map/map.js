function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 15
});

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var contentString = 'Voila ma position';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 200
            });

            map.setCenter(pos);
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: 'Ma position'
            });

            map.addListener('click', function(e) {
                placeMarkerAndPanTo(e.latLng, map);
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            function placeMarkerAndPanTo(latLng, map) {
                var markerj = new google.maps.Marker({
                    position: latLng,
                    map: map
                })
                alert("Pour supprimer le marker cliqueer deux fois sur le marker et pour valider l'adresse exacte cliquer une seule fois sur le marker")

                ;
                map.panTo(latLng);5
                map.panTo(latLng);
                markerj.addListener('dblclick', function () {
                    markerj.setMap(null);
                })
                markerj.addListener('click', function () {
                    $("#questionnairebundle_probleme_Latitude").val(latLng.lat());
                    $("#questionnairebundle_probleme_Longitude").val(latLng.lng());
                })
            }
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}
function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
