<?php
session_start();
$title = "ItineraEase | Saved Trips";
$style = "profilestyles.css";
include 'header.php';
?>

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
    $tripID = $_POST['trip_route'];
    $username = $user["username"];
    $server = 'localhost';
    $dbusername = 'upjomg4jsiwwg';
    $dbpassword = '533%3611n_4`';
    $db = 'dbbucggrkugs9b';
    $conn = new mysqli($server, $dbusername, $dbpassword, $db);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    $sql = "SELECT latitude, longitude FROM waypoints WHERE username = '$username' AND tripID = $tripID ORDER BY waypointID";
    $result = $conn->query($sql);
    $coordinates = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coordinates[] = 'new google.maps.LatLng(' . $row['latitude'] . ',' . $row['longitude'] . '),';
        }
    }
    $lastcount = count($coordinates) - 1;
    $coordinates[$lastcount] = trim($coordinates[$lastcount], ",");
    $conn->close();
}
?>

<script>
function initMap() {
    var mapOptions = {
        zoom: 8,
        center: {<?php echo isset($coordinates[0]) ? $coordinates[0] : 'lat: 0, lng: 0'; ?>},
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var RouteCoordinates = [<?php echo isset($coordinates) ? implode(" ", $coordinates) : ''; ?>];
    var RoutePath = new google.maps.Polyline({
        path: RouteCoordinates,
        geodesic: true,
        strokeColor: '#1100FF',
        strokeOpacity: 1.0,
        strokeWeight: 10
    });
    RoutePath.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initMap);
</script>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhUuWak2CTtiOWi0ycSLTJU43cJVch2_w&libraries=places"></script>
<?php include 'footer.php'; ?>
