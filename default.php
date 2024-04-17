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
    <div class="navbar">
        <div class="nav_menu">
            <a class="logo" href="default.php"><img src="" alt="Flight Logo"></a>
            <a href="explore.php">Explore</a>
            <a href="flights.php">Flights</a>
            <a href="stays.php">Stays</a>
            <a href="events.php">Events</a>
            <a href="food.php">Food</a>
            <a href="other.php">Other</a>
        </div>
        <div class="hamburger_menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

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
            // Select database
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