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
        $tripWaypoints = array();
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
        $db2 = 'dbbucggrkugs9b';
        $conn2 = new mysqli($server, $dbusername, $dbpassword, $db2);
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn_event->connect_error);
        }
        for ($i = 1; $i <= $_SESSION['numTrips']; $i++) {
            $sql2 = "SELECT latitude, longitude FROM waypoints WHERE username = '$username' AND tripID=$i";
            $result2 = $conn2->query($sql2);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    echo "POPULATE THIS PLEASE";
                    $waypoints = array(
                        'lat' => $row2['latitude'],
                        'lng' => $row2['longitude']
                    );
                }
            }
            $tripWaypoints[$i] = $waypoints;
            echo "Trip Waypoints Array: $tripWaypoints[$i]";
        }
        $conn2->close();
    ?>
    <?php include 'footer.php'; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUuWak2CTtiOWi0ycSLTJU43cJVch2_w&libraries=places"></script>
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
    }

    function initMap(i) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 0, lng: 0},
            zoom: 8
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        var waypoints = <?php echo json_encode($tripWaypoints[i]); ?>;
        console.log(waypoints);
        if (Object.keys(waypoints).length > 1) {
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

    google.maps.event.addDomListener(window, 'load', initMap);
    document.addEventListener('DOMContentLoaded', function() {
        var buttons = document.getElementsByClassName('trip_btn');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function() { initMap(i); });
        }
    });
    </script>
</body>
</html>
