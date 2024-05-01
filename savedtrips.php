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
$locations = array();
if (isset($_POST['btn-route'])) {
    $tripID = $_POST['trip_route'];
    $username = $user["username"];
    $server = 'localhost';
    $dbusername = 'upjomg4jsiwwg';
    $dbpassword = '533%3611n_4`';
    $db = 'dbz0xs4h1mcple';
    $conn = new mysqli($server, $dbusername, $dbpassword, $db);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    $sql = "SELECT latitude, longitude FROM waypoints WHERE username = '$username' AND tripID = $tripID ORDER BY waypointID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = array(
                'lat' => $row['latitude'],
                'lng' => $row['longitude']
            );
        }
    }
    $conn->close();
}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUuWak2CTtiOWi0ycSLTJU43cJVch2_w&libraries=places"></script>
<script type="text/javascript">
var map;
var Markers = {};
var infowindow;
var locations = [
<?php for($i=0;$i<sizeof($locations);$i++){ $j=$i+1;?>
[
'Waypoint <?php echo $j; ?>',
<?php echo $locations[$i]['lat'];?>,
<?php echo $locations[$i]['lng'];?>,
<?php echo $i; ?>
]<?php if($j!=sizeof($locations))echo ","; }?>
];

function initialize() {
    if (locations.length > 0) {
        var origin = new google.maps.LatLng(locations[0][1], locations[0][2]);
        var mapOptions = {
            zoom: 9,
            center: origin
        };
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        infowindow = new google.maps.InfoWindow();
        for (i = 0; i < locations.length; i++) {
            var position = new google.maps.LatLng(locations[i][1], locations[i][2]);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            Markers[locations[i][3]] = marker;
        }
        locate(0);
    } else {
        console.log("No locations found.");
    }
}

function locate(marker_id) {
    if (Markers[marker_id]) {
        var myMarker = Markers[marker_id];
        var markerPosition = myMarker.getPosition();
        map.setCenter(markerPosition);
        google.maps.event.trigger(myMarker, 'click');
    }
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php include 'footer.php'; ?>
