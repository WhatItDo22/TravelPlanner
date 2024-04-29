<?php
    session_start();
    $title = "ItineraEase | Saved Route";
?>
<?php include 'header.php'; ?>
    <div class="page-header">
        <h1 class="page-header-title">Route</h1>
    </div>
    <?php
        $server = "localhost";
        $username = "upjomg4jsiwwg";
        $password = "533%3611n_4`";
        $db = "dbbucggrkugs9b";
        $tripNum = $_SESSION["tripNum"];
        $conn_event = new mysqli($server, $dbusername, $dbpassword, $db);
        if ($conn_event->connect_error) {
            die("Connection failed: " . $conn_event->connect_error);
          }
        $sql = "SELECT * FROM waypoints WHERE tripID = $tripNum";

        $conn->close();
        ?>
    <?php include 'footer.php'; ?>
    </body>
</html>