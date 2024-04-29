let map;
let directionsService;
let directionsRenderer;
let markers = [];
let waypointCount = 0;

// Hotel search variables
let places;
let autocomplete;
const MARKER_PATH =
  "https://developers.google.com/maps/documentation/javascript/images/marker_green";
const hostnameRegexp = new RegExp("^https?://.+?/");

let restaurantMap;
let restaurantAutocomplete;
let restaurantMarkers = [];

window.onload = function() {
  initMaps();
};

function initMaps() {
  initMap();
  initRestaurantMap();
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: { lat: 37.1, lng: -95.7 },
    mapTypeControl: true,
    panControl: true,
    zoomControl: true,
    streetViewControl: false,
  });

  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({ map: map });

  setupAutocomplete('origin');
  setupAutocomplete('destination');

  autocomplete = new google.maps.places.Autocomplete(
    document.getElementById("autocomplete")
  );

  places = new google.maps.places.PlacesService(map);

  autocomplete.addListener("place_changed", onPlaceChanged);
  document.getElementById("search-button").addEventListener("click", search);
}

function initRestaurantMap() {
  restaurantMap = new google.maps.Map(document.getElementById("restaurant-map"), {
    zoom: 12,
    center: { lat: 37.7749, lng: -122.4194 },
    mapTypeControl: true,
    panControl: true,
    zoomControl: true,
    streetViewControl: false,
  });

  restaurantAutocomplete = new google.maps.places.Autocomplete(
    document.getElementById("restaurant-location")
  );

  restaurantAutocomplete.addListener("place_changed", onRestaurantPlaceChanged);
  document.getElementById("restaurant-search-button").addEventListener("click", searchRestaurants);
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
  input.id = `waypoint-${waypointCount}`;
  container.insertBefore(input, container.lastChild);
  setupAutocomplete(input.id);
  waypointCount++;
}

function calculateAndDisplayRoute() {
  clearPreviousResults();

  const origin = document.getElementById("origin").value;
  const destination = document.getElementById("destination").value;
  const poiType = document.getElementById("poiType").value;
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
      displayTravelTimesAndFindPOIs(response, poiType);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function displayTravelTimesAndFindPOIs(directionsResult, poiType) {
  const route = directionsResult.routes[0];
  let totalTime = 0;
  let totalDistance = 0;
  let nextPOISearchTime = 3600;
  let accumulatedTime = 0;
  
  route.legs.forEach((leg, index) => {
    totalTime += leg.duration.value;
    totalDistance += leg.distance.value;
    leg.steps.forEach(step => {
      accumulatedTime += step.duration.value;
      if (accumulatedTime >= nextPOISearchTime) {
        searchNearbyPOIs(step.end_location, poiType);
        nextPOISearchTime += 3600;
      }
    });

    if (index === route.legs.length - 1) {
      displayEndOfRouteInfo(leg, totalTime, totalDistance);
    }
  });
}

function searchNearbyPOIs(location, poiType) {
  const service = new google.maps.places.PlacesService(map);
  const types = poiType.split(',').map(type => type.trim());
  service.nearbySearch({
    location: location,
    radius: 40000,
    type: types,
    keyword: poiType
  }, (results, status) => {
    if (status === google.maps.places.PlacesServiceStatus.OK && results.length) {
      displayPOIs(results);
    } else {
      console.log('No points of interest found or API error:', status);
    }
  });
}

function displayPOIs(places) {
  places.slice(0, 5).forEach(place => {
    const marker = new google.maps.Marker({
      position: place.geometry.location,
      map: map,
      title: place.name,
      icon: {
        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
      }
    });

    const infowindow = new google.maps.InfoWindow({
      content: `
        <div>
          <strong>${place.name}</strong><br>
          Rating: ${place.rating || 'N/A'}<br>
          <button class="add-to-itinerary">Add to Itinerary</button>
        </div>
      `
    });

    marker.addListener('click', () => {
      infowindow.open(map, marker);
    });

    // Add click event listener to the "Add to Itinerary" button
    google.maps.event.addListener(infowindow, 'domready', () => {
      const addButton = infowindow.getContent().querySelector('.add-to-itinerary');
      addButton.addEventListener('click', () => {
        // Handle the button click event here
        console.log(`Added ${place.name} to the itinerary`);
        //add logic
      });
    });

    markers.push(marker);
  });
}

function displayEndOfRouteInfo(leg, totalTime, totalDistance) {
  const marker = new google.maps.Marker({
    position: leg.end_location,
    map: map,
    title: "Route End"
  });

  const totalHours = Math.floor(totalTime / 3600);
  const totalMinutes = Math.floor((totalTime % 3600) / 60);
  const totalDistanceKm = (totalDistance / 1000).toFixed(2);
  
  const infowindow = new google.maps.InfoWindow({
    content: `<div><strong>Total Distance:</strong> ${totalDistanceKm} km<br><strong>Total Time:</strong> ${totalHours}h ${totalMinutes}m</div>`
  });

  infowindow.open(map, marker);
  markers.push(marker);
}

function clearPreviousResults() {
  markers.forEach(marker => marker.setMap(null));
  markers = [];
  directionsRenderer.setDirections({ routes: [] });
}

function onPlaceChanged() {
  const place = autocomplete.getPlace();

  if (place.geometry) {
    map.panTo(place.geometry.location);
    map.setZoom(15);
    search();
  } else {
    document.getElementById("autocomplete").placeholder = "Enter a city";
  }
}

function search() {
  const city = document.getElementById("autocomplete").value;

  if (city) {
    const search = {
      bounds: map.getBounds(),
      types: ["lodging"],
    };

    places.nearbySearch(search, (results, status, pagination) => {
      if (status === google.maps.places.PlacesServiceStatus.OK && results) {
        clearResults();
        clearMarkers();

        for (let i = 0; i < results.length; i++) {
          const markerLetter = String.fromCharCode("A".charCodeAt(0) + (i % 26));
          const markerIcon = MARKER_PATH + markerLetter + ".png";
          const marker = new google.maps.Marker({
            position: results[i].geometry.location,
            map: map,
            icon: markerIcon,
          });
          markers.push(marker);

          const tr = document.createElement("tr");
          tr.style.backgroundColor = i % 2 === 0 ? "#F0F0F0" : "#FFFFFF";
          tr.onclick = function () {
            google.maps.event.trigger(marker, "click");
          };
          const iconTd = document.createElement("td");
          const nameTd = document.createElement("td");
          const icon = document.createElement("img");
          icon.src = markerIcon;
          icon.setAttribute("class", "placeIcon");
          const name = document.createTextNode(results[i].name);
          iconTd.appendChild(icon);
          nameTd.appendChild(name);
          tr.appendChild(iconTd);
          tr.appendChild(nameTd);

          const addButton = document.createElement("button");
          addButton.textContent = "Add to Itinerary";
          addButton.classList.add("add-to-itinerary");
          addButton.onclick = function() {
            console.log(`Added ${results[i].name} to the itinerary`);
            // add logic
          };
          tr.appendChild(addButton);

          document.getElementById("results").appendChild(tr);
        }
      }
    });
  }
}

function clearResults() {
  const results = document.getElementById("results");
  while (results.childNodes[0]) {
    results.removeChild(results.childNodes[0]);
  }
}

function clearMarkers() {
  for (let i = 0; i < markers.length; i++) {
    if (markers[i]) {
      markers[i].setMap(null);
    }
  }
  markers = [];
}

function onRestaurantPlaceChanged() {
  const place = restaurantAutocomplete.getPlace();

  if (place.geometry) {
    restaurantMap.panTo(place.geometry.location);
    restaurantMap.setZoom(15);
    searchRestaurants();
  } else {
    document.getElementById("restaurant-location").placeholder = "Enter a location";
  }
}

function searchRestaurants() {
  const location = document.getElementById("restaurant-location").value;
  const query = document.getElementById("restaurant-query").value;

  if (location) {
    const request = {
      location: restaurantMap.getCenter(),
      radius: 5000,
      type: ["restaurant"],
      keyword: query,
    };

    places.nearbySearch(request, (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK && results) {
        clearRestaurantResults();
        clearRestaurantMarkers();

        for (let i = 0; i < results.length; i++) {
          const markerLetter = String.fromCharCode("A".charCodeAt(0) + (i % 26));
          const markerIcon = MARKER_PATH + markerLetter + ".png";
          const marker = new google.maps.Marker({
            position: results[i].geometry.location,
            map: restaurantMap,
            icon: markerIcon,
          });
          restaurantMarkers.push(marker);

          const tr = document.createElement("tr");
          tr.style.backgroundColor = i % 2 === 0 ? "#F0F0F0" : "#FFFFFF";
          tr.onclick = function () {
            google.maps.event.trigger(marker, "click");
          };
          const iconTd = document.createElement("td");
          const nameTd = document.createElement("td");
          const icon = document.createElement("img");
          icon.src = markerIcon;
          icon.setAttribute("class", "placeIcon");
          const name = document.createTextNode(results[i].name);
          iconTd.appendChild(icon);
          nameTd.appendChild(name);
          tr.appendChild(iconTd);
          tr.appendChild(nameTd);

          const addButton = document.createElement("button");
          addButton.textContent = "Add to Itinerary";
          addButton.classList.add("add-to-itinerary");
          addButton.onclick = function() {
            console.log(`Added ${results[i].name} to the itinerary`);
            //add logic
          };
          tr.appendChild(addButton);

          document.getElementById("restaurant-table").appendChild(tr);
        }
      }
    });
  }
}
function clearRestaurantResults() {
  const results = document.getElementById("restaurant-table");
  while (results.childNodes[0]) {
    results.removeChild(results.childNodes[0]);
  }
}

function clearRestaurantMarkers() {
  for (let i = 0; i < restaurantMarkers.length; i++) {
    if (restaurantMarkers[i]) {
      restaurantMarkers[i].setMap(null);
    }
  }
  restaurantMarkers = [];
}

var page = 0;
var ticketMatsterWidgetTemplate = document.getElementById('Ticketmaster-widget').outerHTML;
var searchButton = $(".button");
var cityI= "Chicago";
var stateI = "IL";
var Today = moment().format('YYYY-MM-DD');
var dateI = Today;
var TktAPIKey = "8uLjoPL8tYMRAmxKvWiqevfA4RujHewi";

searchButton.on("click", function() {
  selectQuery();
  getEvents(page);
  reloadTicketmasterWidget();
});

function selectQuery() {
  cityI = $('#City').val();
  stateI = $('#state').val(); 
  dateI = $('#eventDate').val();
  console.log(' City entered: ' + cityI);
  console.log(' State entered: ' + stateI);
  console.log(' Date entered: ' + dateI);
}

function getEvents(page) {
  $('#events-panel').show();
  $('#attraction-panel').hide();

  if (page < 0) {
    page = 0;
    return;
  }
  if (page > 0) {
    if (page > getEvents.json.page.totalPages-1) {
      page=0;
      return;
    }
  }
 
  $.ajax({
    type:"GET",
    url:"https://app.ticketmaster.com/discovery/v2/events.json?apikey="+TktAPIKey+"&sort=date,asc"+"&city="+cityI+"&countryCode=US"+"&state="+stateI+"&startedatetime="+dateI+"&size=4&page="+page,
    async:true,
    dataType: "json",
    success: function(json) {
          getEvents.json = json;
          showEvents(json);
          console.log(json);
         },
    error: function(xhr, status, err) {
  			  console.log(err);
  		   }
  });
}

function showEvents(json) {
  var items = $('#events .list-group-item');
  items.hide();
  var events = json._embedded.events;
  var item = items.first();
  for (var i = 0; i < events.length; i++) {
    item.children('.list-group-item-heading').text(events[i].name);
    item.children('.list-group-item-text').text(events[i].dates.start.localDate);
    try {
      item.children('.venue').text(events[i]._embedded.venues[0].name + " in " + events[i]._embedded.venues[0].city.name);
    } catch (err) {
      console.log(err);
    }
    item.show();

    // Remove the previous click event handler
    item.off("click");

    // Create a new container for the event details
    const eventDetails = $('<div>').addClass('event-details');
    eventDetails.append(item.children('.list-group-item-heading'));
    eventDetails.append(item.children('.list-group-item-text'));
    eventDetails.append(item.children('.venue'));

    // Add click event to the event details container
    eventDetails.on("click", events[i], function(eventObject) {
      console.log(eventObject.data);
      try {
        getAttraction(eventObject.data._embedded.attractions[0].id);
      } catch (err) {
        console.log(err);
      }
    });

    // Create a new container for the "Add to Itinerary" button
    const buttonContainer = $('<div>').addClass('button-container');

    // Add the "Add to Itinerary" button
    const addButton = $('<button>').addClass('add-to-itinerary').text('Add to Itinerary');
    addButton.on('click', function(event) {
      event.stopPropagation();
      console.log(`Added ${events[i].name} to the itinerary`);
      // Add your logic to handle adding the event to the itinerary
    });

    buttonContainer.append(addButton);

    // Clear the item's content and append the event details and button containers
    item.empty();
    item.append(eventDetails);
    item.append(buttonContainer);

    item = item.next();
  }
}
var prevButton = $('#prev');
var nextButton = $('#next');

$('#prev').click(function() { 
  getEvents(--page);
});

$('#next').click(function() {
  getEvents(++page);
});

function getAttraction(id) {
  $.ajax({
    type:"GET",
    url:"https://app.ticketmaster.com/discovery/v2/attractions/"+id+".json?apikey="+TktAPIKey,
    async:true,
    dataType: "json",
    success: function(json) {
          showAttraction(json);
  		   },
    error: function(xhr, status, err) {
  			  console.log(err);
  		   }
  });
}

function showAttraction(json) {
  $('#events-panel').show(); 
  $('#attraction-panel').show();
  
  $('#attraction .list-group-item-heading').first().text(json.name);
  $('#attraction img').first().attr('src', json.images[0].url);
  $('#attraction img').first().css({'width': '80%', 'height': '80%'});
  $('#classification').text(json.classifications[0].segment.name + " - " + json.classifications[0].genre.name + " - " + json.classifications[0].subGenre.name);
  console.log(json.classifications[0].genre.name);
}

function reloadTicketmasterWidget() {
  $('#Ticketmaster-widget').fadeOut(400, function() {
    var newTemplate = $(ticketMatsterWidgetTemplate);
    newTemplate.attr('w-city', cityI, 'w-state', stateI);
    $('#Ticketmaster-widget').html(newTemplate);
    var s = document.createElement('script');
    s.src = 'https://ticketmaster-api-staging.github.io/products-and-docs/widgets/event-discovery/1.0.0/lib/main-widget.js';
    document.body.appendChild(s);
    $('#Ticketmaster-widget').fadeIn(400);
  });
}

getEvents(page);
