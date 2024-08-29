
let map;
let directionsService;
let directionsRenderer;
let autocompleteOrigin;
let autocompleteDestination;
let autocompleteWaypoints;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 6,
        center: { lat: 37.1, lng: -95.7 }  // Centered on the US
    });
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Setup the Autocomplete feature
    autocompleteOrigin = new google.maps.places.Autocomplete(
        document.getElementById('origin'),
        { types: ['geocode'] }
    );
    autocompleteDestination = new google.maps.places.Autocomplete(
        document.getElementById('destination'),
        { types: ['geocode'] }
    );
    autocompleteWaypoints = new google.maps.places.Autocomplete(
        document.getElementById('waypoints'),
        { types: ['geocode'] }
    );
}

function calculateAndDisplayRoute() {
    const origin = document.getElementById("origin").value;
    const destination = document.getElementById("destination").value;
    const waypointsInput = document.getElementById("waypoints").value;
    const waypointArray = waypointsInput.split('|').map(location => ({
        location,
        stopover: true
    }));

    directionsService.route({
        origin: origin,
        destination: destination,
        waypoints: waypointArray,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
    }, (response, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}
