<?php
    session_start();
    $title = "ItineraEase | Saved Trips";
    $style = "profilestyles.css";
?>
<?php include 'header.php'; ?>
<div class="page-header">
    <h1 class="page-header-title">Saved Trips</h1>
    <p class="page-header-subtitle">Click on the "Route" buttons below to see each of your individual trips</p>
</div>
<div id="map" style="height: 500px; width: 100%;"></div>
<?php
    $user = $_SESSION["user"];
    $username = $user["username"];
    $server = "localhost";
    $dbusername = "upjomg4jsiwwg";
    $dbpassword = "533%3611n_4`";
    $db = "dbz0xs4h1mcple";
    $conn = new mysqli($server, $dbusername, $dbpassword, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
                echo "<input type='hidden' name='trip_route' value='$i'>";
                echo "<input type='submit' class='trip_btn' name='btn-route' id='route_$i' value='Route'>";
                echo "</form></div></div></div>";
            }
        }
    }
    $conn->close();
?>
<?php
    if (isset($_POST['btn-route'])) {
        $tripID = 1;
        $username = $user["username"];
        $server = 'localhost';
        $dbusername = 'upjomg4jsiwwg';
        $dbpassword = '533%3611n_4`';
        $db = 'dbbucggrkugs9b';
        $conn = new mysqli($server, $dbusername, $dbpassword, $db);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        $sql = "SELECT latitude, longitude FROM waypoints WHERE username = '$username' AND tripID = $tripID";
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
    var count = Object.keys(waypoints).length;
    if (count > 1) {
        var origin = waypoints[0];
        var destination = waypoints[1];
        var midpoints = waypoints.slice(2);

        var request = {
            origin: new google.maps.LatLng(origin.lat, origin.lng),
            destination: new google.maps.LatLng(destination.lat, destination.lng),
            waypoints: midpoints.map(function(location) {
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

document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.getElementsByClassName('trip_btn');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', initMap);
    }
});
</script>
</body>
</html>
