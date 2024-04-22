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
  directionsRenderer = new google.maps.DirectionsRenderer({map: map});
  
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
      displayTravelTimesAndFindPOIs(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function displayTravelTimesAndFindPOIs(directionsResult) {
  const route = directionsResult.routes[0];
  let totalTime = 0;
  let totalDistance = 0; // Added to accumulate total distance
  let nextPOISearchTime = 3600; // Initialize for 1 hour
  let accumulatedTime = 0;
  
  route.legs.forEach((leg, index) => {
    totalTime += leg.duration.value;
    totalDistance += leg.distance.value; // Accumulate distance
    let legTime = 0;

    leg.steps.forEach(step => {
      legTime = step.duration.value;
      accumulatedTime += legTime;

      if (accumulatedTime >= nextPOISearchTime) {
        searchNearbyPOIs(step.end_location);
        nextPOISearchTime += 3600;
      }
    });

    const marker = new google.maps.Marker({
      position: leg.end_location,
      map: map,
      title: `Leg ${index + 1}`
    });

    const infowindow = new google.maps.InfoWindow({
      content: `<div><strong>${leg.start_address}</strong> to <strong>${leg.end_address}</strong><br>Distance: ${leg.distance.text}<br>Duration: ${leg.duration.text}</div>`
    });

    marker.addListener('click', () => {
      infowindow.open(map, marker);
    });

    markers.push(marker);

    if (index === route.legs.length - 1) { // Ensure this only occurs for the last leg
      const totalInfowindow = new google.maps.InfoWindow({
        content: `<div><strong>Total Distance:</strong> ${(totalDistance / 1000).toFixed(2)} km<br><strong>Total Time:</strong> ${Math.floor(totalTime / 3600)}h ${Math.floor((totalTime % 3600) / 60)}m</div>`
      });
      totalInfowindow.open(map, marker);
    }
  });
}

function searchNearbyPOIs(location) {
  const service = new google.maps.places.PlacesService(map);
  service.nearbySearch({
    location: location,
    radius: 20000, // Search within 20 km radius
    type: ['restaurant', 'museum', 'park'], 
    keyword: 'tourist attractions' 
  }, (results, status) => {
    if (status === google.maps.places.PlacesServiceStatus.OK && results.length) {
      displayPOIs(results);
    } else {
      console.log('No points of interest found or API error:', status);
    }
  });
}


function displayPOIs(places) {
  places.slice(0, 5).forEach(place => { // Limit to 5 places
    const marker = new google.maps.Marker({
      position: place.geometry.location,
      map: map,
      title: place.name,
      icon: {
        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
      }
    });

    const infowindow = new google.maps.InfoWindow({
      content: `<div><strong>${place.name}</strong><br>Rating: ${place.rating || 'N/A'}</div>`
    });

    marker.addListener('click', () => {
      infowindow.open(map, marker);
    });

    markers.push(marker);
  });
}

function clearPreviousResults() {
  markers.forEach(marker => marker.setMap(null)); // Remove all markers from the map
  markers = []; // Clear the markers array
  directionsRenderer.setDirections({ routes: [] }); // Clear previous directions
}
