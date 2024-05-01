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
                    echo "</div></div></div>";
                }
            }
        }
        $conn->close();
        $db2 = "dbbucggrkugs9b";
        $tripNum = $_SESSION["tripNum"];
        $conn2 = new mysqli($server, $dbusername, $dbpassword, $db2);
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
          }
        $sql2 = "SELECT latitude, longitude FROM waypoints WHERE username = $username AND tripID = $tripNum";


        $conn2->close();
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