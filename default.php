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
    <div id="routeButtonContainer">
        <?php
            if (isset($_POST['btn-route'])) {
                $user = $_SESSION["user"];
                if ($user) {
                    $username = $user["username"];
                    $server = 'localhost';
                    $dbusername = 'upjomg4jsiwwg';
                    $dbpassword = '533%3611n_4`';
                    $db = 'dbbucggrkugs9b';
                    $conn = new mysqli($server, $dbusername, $dbpassword, $db);
                    if ($conn->connect_error) {
                        die('Connection failed: ' . $conn->connect_error);
                    }
                    $sql = "SELECT MAX(tripID) AS NumTrips FROM waypoints";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $tripID = $row["tripID"] + 1;
                    }
                    else {
                        $tripID = 1;
                    }
                    $coord= json_decode($_POST['coordinatesArray'], true);
                    $coordinatesArray = $coord[0];
                    foreach ($coordinatesArray as $coordinates) {
                        $latitude = $coordinates['lat'];
                        $longitude = $coordinates['lng'];
                        $sql2 = "INSERT INTO waypoints (tripID, latitude, longitude, username)
                            VALUES ('$tripID', '$latitude', '$longitude', '$username')";
                        if ($conn->query($sql2) === TRUE) {
                            echo "New records created successfully";
                        } else {
                            echo "Error: " . $sql2 . "<br>" . $conn->error;
                        }
                    }
                    $conn->close();
                }
                else {
                    header("Location: login.php");
                }
            }
        ?>
        <form method="post">
            <input type="hidden" name="coordinatesArray" id="coordinatesArrayInput"> 
            <input type="submit" class="btn1" name="btn-route" value="Add Route">
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="app.js"></script>
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
