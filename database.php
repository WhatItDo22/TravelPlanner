<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Planner</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    </style>
    <script>
        function funcName() {
            var request = new XMLHttpRequest();
            request.open("GET", "", true);
            request.onreadystatechange = function() {
                // Runs if the URL could be loaded and it loads correctly
                if (request.readyState == 4 && request.status == 200) {
                    let data = request.responseText;
                    // Converts the text into a JavaScript object
                    let myObj = JSON.parse(data);
                }
                else if (request.readyState == 4 && request.status != 200) {
                    console.log("Request failed");
                }
            }
            request.send();
        }
    </script>
</head>

<body onload="funcName()"> 
    <?php include 'header.php'; ?>

        <?php
            // Establish connection info to database one
            $servername = "localhost";
            $username = "upjomg4jsiwwg";
            $password = "g94wspgywq8e";
            $db = "dbxr6uvbrsv2dg";
            $conn = new mysqli($server, $username, $password);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $conn->select_db($db);
            $sql = "SELECT Name, Abbreviation FROM States";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['Abbreviation']}'>{$row['Name']}</option>"
                }
            }

            $conn->close();
        ?>
    <?php include 'footer.php'; ?>
</body>
</html>