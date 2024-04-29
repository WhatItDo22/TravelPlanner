<?php
    session_start();
    $style = "defaultstyles.css";
    $title = "ItineraEase";
?>

<?php include 'header.php'; ?>
<div class="page-header">
        <h1 class="page-header-title">ItineraEase</h1>
        <p class="page-header-subtitle">Start here to plan your next great roadtrip!</p>
    </div>
<div class="container">
    <div id="controlPanel">
        <input id="origin" type="text" placeholder="Enter origin" class="waypoint input-fixed-width">
        <input id="destination" type="text" placeholder="Enter destination" class="waypoint input-fixed-width">
        <input id="poiType" type="text" placeholder="Enter types of places (e.g., museum, restaurant)" class="input-fixed-width">
    </div>

    <div id="dynamicWaypointsContainer"></div>

    <div id="waypointsContainer">
        <button onclick="addWaypoint()" id="waypoint">Add Waypoint</button>
        <button onclick="calculateAndDisplayRoute()" id="submit_button">Get Directions</button>
    </div>
</div>

<div id="mapContainer">
    <div id="map"></div>
    <button id="addRouteButton">Add route</button>
</div>

<?php include 'footer.php'; ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUuWak2CTtiOWi0ycSLTJU43cJVch2_w&libraries=places"></script>
<script>
let map, geocoder, directionsService, directionsRenderer;

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: { lat: 37.7749, lng: -122.4194 } 
  });

  geocoder = new google.maps.Geocoder();
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();
  directionsRenderer.setMap(map);


  const originInput = document.getElementById('origin');
  const destinationInput = document.getElementById('destination');

  originInput.addEventListener('input', geocodeOrigin);
  destinationInput.addEventListener('input', geocodeDestination);
}

function geocodeOrigin() {
  const address = this.value;
  geocoder.geocode({ 'address': address }, function(results, status) {
    if (status === 'OK') {
      const originCoords = results[0].geometry.location;

    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function geocodeDestination() {
  const address = this.value;
  geocoder.geocode({ 'address': address }, function(results, status) {
    if (status === 'OK') {
      const destinationCoords = results[0].geometry.location;

    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
  });
}


window.onload = initMap;
</script>

</body>
</html>
