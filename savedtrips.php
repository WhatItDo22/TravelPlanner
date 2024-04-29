<?php
    session_start();
    $title = "ItineraEase | Saved Trips";
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
                for ($i = 0; $i < $row['numTrips']; $i++) {
                    echo "<div class='container'><div class=trip_container>";
                    echo "<h2>Trip ($i + 1)</h2>";
                    echo "<div class='buttons_container'";
                    echo "<a class='trip_btn' href='savedroutes.php'>Route</a>";
                    echo "<a class='trip_btn' href='savedevents.php'>Events</a>";
                    echo "</div></div></div>";
                }
            }
        }
        $conn->close();
    ?>
    <?php include 'footer.php'; ?>
</body>
</html>