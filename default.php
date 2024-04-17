<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Travel Planner</title>
    <style>
    </style>

</head>
<body>
        <?php
            // Establish connection info to database one
            $servername = "localhost";
            $username = "upjomg4jsiwwg";
            $password = "g94wspgywq8e";
            $db = "dbxr6uvbrsv2dg";
            // Create connection
            $conn = new mysqli($server, $username, $password);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Select menu database
            $conn->select_db($db);
            $sql = "";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                }
            }

            $conn->close();
        ?>
</body>
</html>