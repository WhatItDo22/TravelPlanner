<?php
    session_start();
    $title = "ItineraEase";
?>
    <?php include 'header.php'; ?>
    <div class="container">
        <div id="controlPanel">
            <input id="origin" type="text" placeholder="Enter origin" class="waypoint input-fixed-width">
            <input id="destination" type="text" placeholder="Enter destination" class="waypoint input-fixed-width">
            <input id="poiType" type="text" placeholder="Enter types of places (e.g., museum, restaurant)" class="input-fixed-width">
      </div>

    <div id="dynamicWaypointsContainer"></div>
        <div id="waypointsContainer">
            <button onclick="addWaypoint()" id="waypoint">Add Waypoint</button>
            <button onclick="calculateAndDisplayRoute()" id="submit__button">Get Directions</button>
        </div>
    </div>
    <div id="mapContainer">
        <div id="map"></div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="app.js"></script>
</body>
</html>