<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <title>FAQ</title>
        <style>
            :root {
                --primary-color: #c39e41;
                --whiteColor: #fff;
                --darkColor: #333;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
                outline: none;
            }

            body {
                width: 100%;
                height: auto;
                padding: 3%;
                background-color: var(--whiteColor);
            }
            .page-header {
                background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/event-img.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 5% 3%;
                border-radius: 30px;
                max-height: 300px;
                color: var(--whiteColor);
            }

            .page-header-title {
                font-size: 40px;
                letter-spacing: 1.5;
            }
            .events {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            
            .event-container {
                display: flex;
                justify-content: safe;
                padding: 5px;
                margin-top: 5%;
                width: 40%;
                background: var(--primary-color);
                border-radius: 10px;
                margin-right: 40px;
            }

            .event-date {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 5px;
                background: var(--whiteColor);
                border-radius: 10px;
                margin: 10px;
                width: 25%;
            }

            .event-info {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 5px;
                border-radius: 10px;
                margin: 10px;
                width: 75%;
            }

            .event-date-info {
                font-size: 20px;
                letter-spacing: 1;
                align-items: center;
            }
            @media screen and (max-width: 680px) {
                .page-header {
                    padding: 10% 3%;
                }
                .events {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .event-container {
                    width: 80%;
                }   
            }
        </style>
    </head>
    <body>
        <div class="page-header">
            <h1 class="page-header-title">Events</h1>
        </div>
        <?php include 'header.php';
            $user = $_SESSION["user"];
            $userName = $user["username"];

            require_once "event_db.php";
            $sql = "SELECT * FROM events WHERE username = $userName";
            $result = mysqli_query($conn_event, $sql);
            $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (count($events) > 0) {
                echo "<div class='events'>";
                foreach ($events as $event) {
                    $day = date("d", strtotime($event["eventDate"]));
                    $month = date("F", strtotime($event["eventDate"]));
                    $year = date("Y", strtotime($event["eventDate"]));
                    echo "<div class='event-container'>";
                    echo "<div class='event-date'>";
                    echo "<h2 class='event-date-info'>" . $month . "<br>" . $day . "<br>" . $year . "</h2>";
                    echo "</div>";
                    echo "<div class='event-info'>";
                    echo "<h2 class='event-name'>" . $event["name"] . "</h2>";
                    echo "<h4 class='event-location'>" . $event["address"] . ", ". $event["city"] . ", " . $event["state"] . "</h4>";
                    echo "<h4 class='event-category'>" . $event["category"] . "</h4>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<h2>No events saved</h2>";
            }
            include 'footer.php';
        ?>
    </body>
</html>