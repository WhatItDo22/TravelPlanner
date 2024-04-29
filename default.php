<?php
    session_start();
    $title = "ItineraEase";
?>
    <?php include 'header.php'; ?>
        <?php
            // Establish connection info to database one
            $server = "localhost";
            $username = "upjomg4jsiwwg";
            $password = "533%3611n_4`";
            $db = "dbxr6uvbrsv2dg";
            $conn = new mysqli($server, $username, $password);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $conn->select_db($db);
            $sql = "SELECT Name, Abbreviation FROM States";
            $result = $conn->query($sql);
            echo "<select name='state' id='state'>";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['Abbreviation']}'>{$row['Name']}</option>";
                }
            }
            echo "</select>";
            $conn->close();
        ?>
    <?php include 'footer.php'; ?>
</body>
</html>