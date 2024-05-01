<?php
session_start();
$title = "ItineraEase | Saved Trips";
$style = "profilestyles.css";
?>
<?php include 'header.php'; ?>
<h1>Saved Trips</h1>
<?php
$user = $_SESSION["user"];
$username = $user["username"];
$server = "localhost";
$dbusername = "upjomg4jsiwwg";
$dbpassword = "533%3611n_4`";
$db = "dbz0xs4h1mcple";
$conn = new mysqli($server, $dbusername, $dbpassword, $db);
if ($conn_event->connect_error) {
    die("Connection failed: " . $conn_event->connect_error);
}
$sql = "SELECT numTrips FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        for ($i = 1; $i <= $row['numTrips']; $i++) {
            $_SESSION['numTrips'] = $row['numTrips'];
            echo "<div class='container'><div class=trip_container>";
            echo "<h2>Trip $i</h2>";
            echo "<div class='buttons_container'";
            echo "<form method='post'>";
            echo "<input type='hidden' name='trip_route' id='trip_route'>";
            echo "<input type='submit' class='trip_btn' name='btn-route' id='route_$i' value='Route'>";
            echo "</form></div></div></div>";
        }
    }
}
$conn->close();
?>
<?php
if (isset($_POST['btn-route'])) {
    $username = $user["username"];
    $server = 'localhost';
    $dbusername = 'upjomg4jsiwwg';
    $dbpassword = '533%3611n_4`';
    $db = 'dbbucggrkugs9b';
    $conn = new mysqli($server, $dbusername, $dbpassword, $db);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    $tripID = $_Session['tripNum'];
    $sql = "SELECT latitude, longitude FROM waypoints WHERE username = '$username' AND tripID = '$tripID'";
    $result = $conn->query($sql);

    $waypoints = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $waypoints[] = array(
                'lat' => $row['latitude'],
                'lng' => $row['longitude']
            );
        }
    }

    $conn->close();
}
?>
<?php include 'footer.php'; ?>
<div id="map" style="height: 500px; width: 100%;"></div>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUuWak2CTtiOWi0ycSLTJU43cJVch2_w&libraries=places"></script>
<script>
var map;
var directionsService;
var directionsRenderer;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 8
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    var waypoints = <?php echo json_encode($waypoints); ?>;
    if (waypoints.length > 0) {
        var origin = waypoints[0];
        var destination = waypoints[waypoints.length - 1];
        var waypointLocations = waypoints.slice(1, -1);

        var request = {
            origin: new google.maps.LatLng(origin.lat, origin.lng),
            destination: new google.maps.LatLng(destination.lat, destination.lng),
            waypoints: waypointLocations.map(function(location) {
                return {
                    location: new google.maps.LatLng(location.lat, location.lng),
                    stopover: true
                };
            }),
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
            }
        });
    }
}

var numTrips = <?php echo $_SESSION['numTrips'] ?>;
for (var i = 1; i <= numTrips; i++) {
    document.getElementById("route_" + i).addEventListener("click", function() {
        $_SESSION['tripNum'] = i;
    });
}

google.maps.event.addDomListener(window, 'load', initMap);
</script>
</body>
</html>
