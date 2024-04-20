let map;
let directionsService;
let directionsRenderer;
let markers = []; // Array to store the markers
let waypointCount = 0; // Counter for generating unique IDs

window.onload = function() {
  initMap();
};

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 6,
    center: { lat: 37.1, lng: -95.7 } // Centered on the US
  });

  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();
  directionsRenderer.setMap(map);

  // Initialize autocomplete for initially present inputs
  setupAutocomplete('origin');
  setupAutocomplete('destination');
}

function setupAutocomplete(id) {
  new google.maps.places.Autocomplete(document.getElementById(id), {
    types: ['geocode']
  });
}

function addWaypoint() {
  const container = document.getElementById('waypointsContainer');
  const input = document.createElement('input');
  input.type = 'text';
  input.placeholder = 'Enter waypoint';
  input.className = 'waypoint';
  input.id = `waypoint-${waypointCount}`; // Generate a unique ID for each waypoint
  container.insertBefore(input, container.lastChild);
  setupAutocomplete(input.id); // Setup autocomplete for the new input
  waypointCount++; // Increment the counter
}

function calculateAndDisplayRoute() {
  clearPreviousResults();

  const origin = document.getElementById("origin").value;
  const destination = document.getElementById("destination").value;
  const waypoints = Array.from(document.getElementsByClassName('waypoint'))
    .map(input => ({ location: input.value, stopover: true }))
    .filter(wp => wp.location !== "");

  const routeRequest = {
    origin: origin,
    destination: destination,
    waypoints: waypoints,
    travelMode: google.maps.TravelMode.DRIVING,
    optimizeWaypoints: waypoints.length > 0

  };

  directionsService.route(routeRequest, (response, status) => {
    if (status === 'OK') {
      directionsRenderer.setDirections(response);
      displayTravelTimes(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function displayTravelTimes(directionsResult) {
  const route = directionsResult.routes[0];
  let totalTime = 0;
  let totalDistance = 0;

  route.legs.forEach((leg, index) => {
    totalTime += leg.duration.value;
    totalDistance += leg.distance.value;

    const marker = new google.maps.Marker({
      position: leg.end_location,
      map: map,
      title: `Leg ${index + 1}`,

    });

    markers.push(marker); // Add marker to the array for tracking

    const infowindow = new google.maps.InfoWindow({
      content: `<div><strong>${leg.start_address}</strong> to <strong>${leg.end_address}</strong><br> Distance: ${leg.distance.text}<br> Duration: ${leg.duration.text}</div>`
    });

    marker.addListener('click', () => {
      infowindow.open(map, marker);
    });

    if (index === route.legs.length - 1) {
      // Last leg
      new google.maps.InfoWindow({
        content: `<div><strong>Total Distance:</strong> ${totalDistance / 1000} km<br> <strong>Total Time:</strong> ${Math.floor(totalTime / 3600)}h ${Math.floor((totalTime % 3600) / 60)}m</div>`
      }).open(map, marker);
    }
  });
}

function clearPreviousResults() {
  markers.forEach(marker => marker.setMap(null)); // Remove all markers from the map
  markers = []; // Clear the markers array
  directionsRenderer.setDirections({ routes: [] }); // Clear previous directions
}
