let map;
let directionsService;
let directionsRenderer;
let markers = [];
let waypointCount = 0;

window.onload = function() {
  initMap();
};

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 6,
    center: { lat: 37.1, lng: -95.7 }
  });

  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({ map: map });

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
      content: `<div><strong>${place.name}</strong><br>Rating: ${place.rating || 'N/A'}</div>`
    });

    marker.addListener('click', () => {
      infowindow.open(map, marker);
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

var page = 0;
var ticketMatsterWidgetTemplate = document.getElementById('Ticketmaster-widget').outerHTML;
var searchButton = $(".button");
var cityI= "Chicago";
var stateI = "IL";
var Today = moment().format('YYYY-MM-DD');
var dateI = Today;
var categoryI= "";
var Family="yes";
var TktAPIKey = "8uLjoPL8tYMRAmxKvWiqevfA4RujHewi";

searchButton.on("click", function() {
  FamilyorNot();
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
  console.log("Show family events only is " + Family);
}

function FamilyorNot() {
  if(document.getElementById('showFamily').checked) {
    Family="only";
    console.log(" Only family events is checked so mark Family as " + Family);
  }
  else if(document.getElementById('over21').checked) {
    Family="no";
    console.log("Over 21 is checked so mark it as " + Family);
  }
  else {
    Family="yes";
    console.log("Radio button was not used so both Family and other events must show : " + Family);
  }
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
    url:"https://app.ticketmaster.com/discovery/v2/events.json?apikey="+TktAPIKey+"&sort=date,asc"+"&city="+cityI+"&countryCode=US"+"&state="+stateI+"&startedatetime="+dateI+"&classificationName="+categoryI+"&includeFamily="+Family+"&size=4&page="+page,
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
  for (var i=0;i<events.length;i++) {
    item.children('.list-group-item-heading').text(events[i].name);
    item.children('.list-group-item-text').text(events[i].dates.start.localDate);
    try {
      item.children('.venue').text(events[i]._embedded.venues[0].name + " in " + events[i]._embedded.venues[0].city.name);
    } catch (err) {
      console.log(err);
    }
    item.show();
    item.off("click");
    item.click(events[i], function(eventObject) {
      console.log(eventObject.data);
      try {
        getAttraction(eventObject.data._embedded.attractions[0].id);
      } catch (err) {
      console.log(err);
      }
    });
    item=item.next();
  }
}

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
  $('#events-panel').show(); // Keep the events panel visible
  $('#attraction-panel').show();
  
  $('#attraction-panel').click(function() {
    getEvents(page);
  });
  
  $('#attraction .list-group-item-heading').first().text(json.name);
  $('#attraction img').first().attr('src', json.images[0].url);
  $('#attraction img').first().css({'width': '80%', 'height': '80%'}); // Set fixed image size
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
