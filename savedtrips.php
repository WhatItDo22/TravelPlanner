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
                    echo "<a class='trip_btn' id='route_$i' href='savedroutes.php'>Route</a>";
                    echo "<a class='trip_btn' id='events_$i' href='savedevents.php'>Events</a>";
                    echo "</div></div></div>";
                }
            }
        }
        $conn->close();
    ?>
    <?php include 'footer.php'; ?>
    <script>
        var numTrips = <?php $_SESSION['numTrips']?>;
        for (var i = 1; i <= numTrips; i++) {
            document.getElementById("route_" + i).addEventListener("click", function() {
                $_SESSION['tripNum'] = i;
            });
            document.getElementById("events_" + i).addEventListener("click", function() {
                $_SESSION['tripNum'] = i;
            });
        }
    </script>
</body>
</html>