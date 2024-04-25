<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItineraEase</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    </style>
</head>

<body> 
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
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<select name='state' id='state'>";
                    echo "<option value='{$row['Abbreviation']}'>{$row['Name']}</option>";
                    echo "</select>";
                }
            }

            $conn->close();
        ?>
    <?php include 'footer.php'; ?>

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
        const hamburgerMenu = document.querySelector(".hamburger_menu");
        const navMenu = document.querySelector(".nav_menu");
        hamburgerMenu.addEventListener("click", toggleMenu);

        function toggleMenu() {
            hamburgerMenu.classList.toggle("change");
            navMenu.classList.toggle("change");
        }
    </script>
</body>
</html>