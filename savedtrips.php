<?php
    session_start();
    $title = "ItineraEase | Saved Trips";
?>
    <?php include 'header.php'; ?>
    <h1>Saved Trips</h1>
    <?php
        $server = "localhost";
        $dbusername = "upjomg4jsiwwg";
        $dbpassword = "533%3611n_4`";
        $db = "dbz0xs4h1mcple";
        $conn = new mysqli($server, $dbusername, $dbpassword, $db);
    ?>
    <?php include 'footer.php'; ?>
</body>
</html>