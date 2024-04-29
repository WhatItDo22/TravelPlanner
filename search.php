<?php
    session_start();
    $title = "ItineraEase | Search";
?>
    <?php include 'header.php'; ?>
    <section class="events-container">
    <div class="container">
        <h2>Events</h2>
        <div class="search-form">
            <input id="City" type="text" placeholder="Enter city">
            <?php
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
            <input type="date" id="eventDate">
            <button class="button">Search</button>
        </div>
        <div id="events-panel">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Events</h3>
                </div>
                <div class="panel-body">
                    <div id="events" class="list-group">
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading"></h4>
                            <p class="list-group-item-text"></p>
                            <p class="venue"></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination">
            <button id="prev">Previous</button>
            <button id="next">Next</button>
        </div>
      </div>
    </section>
    <div class="container">
        <div id="attraction-panel">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" id="attraction">Attraction</h3>
                </div>
            <div id="attraction" class="panel-body">
                <h4 class="list-group-item-heading">Attraction title</h4>
                <img class="col-xs-12" src="">
                <p id="classification"></p>
            </div>
        </div>
    </div>
    <div id="Ticketmaster-widget"></div>
    <section class="hotel-search-container">
        <div class="container">
            <h2>Hotel Search</h2>
            <div class="search-form">
                <input id="autocomplete" type="text" placeholder="Enter a city">
                <button id="search-button">Search</button>
            </div>
            <div id="map"></div>
            <div id="hotel-results">
                <table id="results"></table>
            </div>
        </div>
    </section>

    <section class="restaurant-search-container">
        <div class="container">
            <h2>Restaurant Search</h2>
            <div class="search-form">
                <input id="restaurant-location" type="text" placeholder="Enter a location">
                <input id="restaurant-query" type="text" placeholder="Enter a cuisine type (optional)">
                <button id="restaurant-search-button">Search</button>
            </div>
            <div id="restaurant-map"></div>
            <div id="restaurant-results">
                <table id="restaurant-table"></table>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>