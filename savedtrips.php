<?php
    session_start();
    $title = "ItineraEase | Saved Trips";
    $style = "profilestyles.css";
?>
    <?php include 'header.php'; ?>
    <div class="page-header">
        <h1 class="page-header-title">Saved Trips</h1>
        <p class="page-header-subtitle">Find the next unforgettable part of your trip</p>
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
            $tripID = $_POST['trip_route'];
            $_SESSION['tripNum'] = $tripID;
            echo $tripID;
            echo $_SESSION['tripNum'];
            $username = $user["username"];
            $server = 'localhost';
            $dbusername = 'upjomg4jsiwwg';
            $dbpassword = '533%3611n_4`';
            $db = 'dbbucggrkugs9b';
            $conn = new mysqli($server, $dbusername, $dbpassword, $db);
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }
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
            echo $waypoints;
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
        if (waypoints.length > 1) {
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
    </script>
</body>
</html>
