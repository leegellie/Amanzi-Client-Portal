<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once ('head_php.php');
//CONFIG DB


/*
HERE ARE THE CODE SNIPPETS TO DISPLAY USER INFO.
WHAT TO DISPLAY = CODE TO INSERT THE VALUE
USERNAME = <?= $username ?>
ACCESS LEVEL (NUMERIC VALUE) = <?= $access_level ?>
FIRST NAME = <?= $first_name ?>
LAST NAME = <?= $last_name ?>
USER'S EMAIL = <?= $user_email ?>
*/

/*
GET THE TEMPLATE TEAM INFO
*/
$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$q = $conn->prepare("SELECT * FROM template_teams");
$q->execute();
$rows = $q->fetchAll(PDO::FETCH_ASSOC);

if( isset($_POST['teamID']) && isset($_POST['jobID']) && isset($_POST['cur_date'])){
  $teamID = $_POST['teamID'];
  $jobID = $_POST['jobID'];
  $date = new DateTime($_POST['cur_date']);
  $curDate = $date->format('Y-m-d');
  $q = $conn->prepare("UPDATE projects SET template_team = :teamID WHERE id = :jobID");
  $q->bindParam('teamID',$teamID);
  $q->bindParam('jobID',$jobID);
  $q->execute();
  
  $q = $conn->prepare("SELECT * FROM projects where template_date = :template_date");
  $q->bindParam('template_date', $curDate);
  $q->execute();
  $jobs = $q->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($jobs);
  exit;
  
}
if( isset($_POST['date']) ){
  $date = new DateTime($_POST['date']);
  $curDate = $date->format('Y-m-d');
  $q = $conn->prepare("SELECT * FROM projects WHERE template_date = :tempate_date");
  $q->bindParam('tempate_date',$curDate);
  $q->execute();
  $jobs = $q->fetchAll(PDO::FETCH_ASSOC);
  
  $jobs_info = [];
  $index = 0;
  foreach ($jobs as $job){
    $address = $job['address_1'].' '. $job['city'].' '.$job['state'];
//     $value = getLatLong($address);
//     $job['lat'] = $value['latitude'];
//     $job['lng'] = $value['longitude'];
//     $jobs_info[$index] = $job;
    $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4&address='.urlencode($address).'&sensor=false');
    $geo = json_decode($geo, true); // Convert the JSON to an array
    $job['address_job'] = $address;

    if (isset($geo['status']) && ($geo['status'] == 'OK')) {
      $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
      $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
      $job['lat'] = $latitude;
      $job['lng'] = $longitude;
      $jobs_info[$index] = $job;
    }
    $index++;
  }
//   $jobs_info['count'] = $index;
  echo json_encode($jobs_info);
  exit;
}

function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBPONZzDP2hnCQzQ8vVtGLphLGQ3Xp2qFg&address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        var_dump($output);exit;
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
} 

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css2/styles.css">
  
  
  
  <!--  INCLUDE bootstrap CSS & JS files for Datepicker  -->
<!--   <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"> -->
  <script type='text/javascript' src='//code.jquery.com/jquery-1.8.3.js'></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">
	<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>

  <!--    Google Map Javascript API    -->
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA5ozXh8RjlEX82tUI4oDYyMZdPTHaI-Tw">   </script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  
  
  <script type="text/javascript">
    var map;
    var directionsDisplay = null;
    var directionsService;
    var polylinePath;
    var nodes = [];
    var prevNodes = [];
    var markers = [];
    var durations = [];
    var geocoder;
    var point = [];
    var marker;
    var markerHOME;
    var nodes_team = [];
    
    // Initialize google maps
    CustomMarker.prototype = new google.maps.OverlayView();

    function CustomMarker(opts) {
        this.setValues(opts);
    }

    CustomMarker.prototype.draw = function() {
        var self = this;
        var div = this.div;
        if (!div) {
            div = this.div = $('' +
                '<div>' +
                '<div class="shadow"></div>' +
                '<div class="pulse"></div>' +
                '</div>' +
                '</div>' +
                '')[0];
            this.pinWrap = this.div.getElementsByClassName('pin-wrap');
            this.pin = this.div.getElementsByClassName('pin');
            this.pinShadow = this.div.getElementsByClassName('shadow');
            div.style.position = 'absolute';
            div.style.cursor = 'pointer';
            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
            google.maps.event.addDomListener(div, "click", function(event) {
                google.maps.event.trigger(self, "click", event);
            });
        }
        var point = this.getProjection().fromLatLngToDivPixel(this.position);
        if (point) {
            div.style.left = point.x + 'px';
            div.style.top = point.y + 'px';
        }
    };
    
    
    function initializeMap() {
        // Map options
        var iconBase_home = '/home.png';
        var opts = {
            center: new google.maps.LatLng(36.1181642, -80.0626623,59),
            zoom: 9,
            streetViewControl: true,
            mapTypeControl: true
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), opts);
        
        var pointHOME = new google.maps.LatLng(36.1181642, -80.0626623,59),
        markerHOME = new google.maps.Marker({
            position: pointHOME,
            icon: iconBase_home,
            label:{
              text: "HOME",
              color: "#ffffff",
              fontSize: "14px",
              overflow: "hidden",
              fontWeight: "bold",
              label: '703 Park Lawn Ct. Kernersville, NC 27284'
            },
            'bounds': true,
            url: "/",
            animation:google.maps.Animation.DROP,
            map: map
        }),  
      
        geocoder = new google.maps.Geocoder();
        var markerHOME = new CustomMarker({
            position: pointHOME,
            map: map,
        });
        var infoWindow = new google.maps.InfoWindow();
        
        
      
        $('.get_info_btn').click(function(){
          // Map options
          var iconBase_home = '/home.png';
          var opts = {
              center: new google.maps.LatLng(36.1181642, -80.0626623,59),
              zoom: 9,
              streetViewControl: true,
              mapTypeControl: true
          };
          map = new google.maps.Map(document.getElementById('map-canvas'), opts);

          var pointHOME = new google.maps.LatLng(36.1181642, -80.0626623,59),
          markerHOME = new google.maps.Marker({
              position: pointHOME,
              icon: iconBase_home,
              label:{
                text: "HOME",
                color: "#ffffff",
                fontSize: "14px",
                overflow: "hidden",
                fontWeight: "bold",
                label: '703 Park Lawn Ct. Kernersville, NC 27284'
              },
              'bounds': true,
              url: "/",
              animation:google.maps.Animation.DROP,
              map: map
          }),  

          geocoder = new google.maps.Geocoder();
          var markerHOME = new CustomMarker({
              position: pointHOME,
              map: map,
          });
          var infoWindow = new google.maps.InfoWindow();
          clearMap();
          $('.loading').removeClass('hidden');
          var cur_date = $('.datepicker_sec .form-control').val();
          var bounds = new google.maps.LatLngBounds();
          $.ajax({
            type: 'post',
            data: {date: cur_date},
            success: function(response){
              $('.loading').addClass('hidden');
              //var marker;
              var result = JSON.parse(response);
              if(result.length < 1){
                alert("There is no jobs");
                return;
              }
              // If there are directions being shown, clear them
              clearDirections();
              var iconBase = '/marker1.png';
              var joblist_str = [];
              for(var i=0;i<=100;i++){
                nodes_team[i] = [];
                joblist_str[i] = '';
                nodes_team[i].push(pointHOME);
              }
              $.each( result, function( key, value ) {
                
                var teamID = value['template_team'];
                joblist_str[teamID] += '<li>'+value['job_name']+'</li>'
                
                var latitude = parseFloat(value['lat']);
                var longitude = parseFloat(value['lng']);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    map: map,
                    label: {
                      text: value['job_name'],
                      color: "#ffffff",
                      fontSize: "12px",
                      overflow: "hidden",
                      fontWeight: "bold"
                    },
                    'bounds': true,
                    icon: iconBase,
                    title: "jobs",
                    url: "/",
                    animation:google.maps.Animation.DROP
                });
                var point_item = new google.maps.LatLng(latitude, longitude);
                point.push(point_item);
                markers.push(marker);
                nodes_team[teamID].push(point_item);
                console.log(nodes_team[teamID]);
                bounds.extend(point_item);
                //Attach click event to the marker.
                (function (marker, value) {
                    google.maps.event.addListener(marker, "click", function (e) {
                      //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                      var html_str = "<div style = 'width:200px;min-height:40px'>";
                          html_str += "<div id='myForm'>";
                          html_str +=   "<p>Please select the team to assign to this job:</p>";
                          html_str +=   "<div>";
                          <?php foreach ($rows as $row){ ?>
                          html_str +=     "<input type='radio' id='contactChoice<?php echo $row['temp_team_id']; ?>' name='radioName' value='<?php echo $row['temp_team_id']; ?>'>";
                          html_str +=     "<label for='contactChoice<?php echo $row['temp_team_id']; ?>'><?php echo $row['temp_team_name']; ?></label>";
                          <?php } ?>
                          html_str +=    "</div>";
                          html_str +=    "<div>";
                          html_str +=     "<button type='' onclick ='assign_btn("+value['id']+")'>Assign</button>";
                          html_str +=    "</div>";
                          html_str +=  "</div>";
                          html_str += "</div>";
                      infoWindow.setContent(html_str);
                      infoWindow.open(map, marker);
                    });
                    
                })(marker, value);
                
              });
              map.fitBounds(bounds);
              //map.panToBounds(bounds);
              for(var i=1;i<=6;i++){
                var team_id = '.row.team'+i+' .jobs_list';
                $(team_id).empty().html(joblist_str[i]); 
              }

              // Update destination count
              $('#destinations-count').html(nodes.length);
              
            }
          }); 
        })      
      
        // Add "my location" button
        var myLocationDiv = document.createElement('div');
        new getMyLocation(myLocationDiv, map);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(myLocationDiv);

        function getMyLocation(myLocationDiv, map) {
            var myLocationBtn = document.createElement('button');
            myLocationBtn.innerHTML = 'My Location';
            myLocationBtn.className = 'large-btn';
            myLocationBtn.style.margin = '5px';
            myLocationBtn.style.opacity = '0.95';
            myLocationBtn.style.borderRadius = '3px';
            myLocationDiv.appendChild(myLocationBtn);

            google.maps.event.addDomListener(myLocationBtn, 'click', function() {
                navigator.geolocation.getCurrentPosition(function(success) {
                    map.setCenter(new google.maps.LatLng(success.coords.latitude, success.coords.longitude));
                    map.setZoom(12);
                });
            });
        }
    }
    
    function assign_btn(n){
      var cur_date = $('.datepicker_sec .form-control').val();
      var team_select_id = $('input[name=radioName]:checked', '#myForm').val();
      $.ajax({
        type: 'post',
        data: {teamID: team_select_id,jobID:n, cur_date:cur_date},
        success: function(response){
          var result = JSON.parse(response);
          var joblist_html = [];
          for(var i=0;i<=100;i++){
            joblist_html[i] = '';
          }
          $.each( result, function( key, value ) {
            var teamID = value['template_team'];
            joblist_html[teamID] += '<li>'+value['job_name']+'</li>'
            console.log(value);
          });
          
          for(var i=1;i<=<?php echo count($rows); ?>;i++){
            var team_id = '.row.team'+i+' .jobs_list';
            $(team_id).empty().html(joblist_html[i]); 
          }
        }
      });
      
    }
    
    // Get all durations depending on travel type
    function getDurations(callback) {
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: nodes,
            destinations: nodes,
            travelMode: google.maps.TravelMode[$('#travel-type').val()],
            avoidHighways: parseInt($('#avoid-highways').val()) > 0 ? true : false,
            avoidTolls: false,
        }, function(distanceData) {
            // Create duration data array
            var nodeDistanceData;
            for (originNodeIndex in distanceData.rows) {
                nodeDistanceData = distanceData.rows[originNodeIndex].elements;
                durations[originNodeIndex] = [];
                for (destinationNodeIndex in nodeDistanceData) {
                    if (durations[originNodeIndex][destinationNodeIndex] = nodeDistanceData[destinationNodeIndex].duration == undefined) {
                        alert('Error: couldn\'t get a trip duration from API');
                        return;
                    }
                    durations[originNodeIndex][destinationNodeIndex] = nodeDistanceData[destinationNodeIndex].duration.value;
                }
            }
            if (callback != undefined) {
                callback();
            }
        });
    }
    // Removes markers and temporary paths
    function clearMapMarkers() {
        for (index in markers) {
            markers[index].setMap(null);
        }
        prevNodes = nodes;
        nodes = [];
        if (polylinePath != undefined) {
            polylinePath.setMap(null);
        }

        markers = [];

//         $('#ga-buttons').show();
    }
    // Removes map directions
    function clearDirections() {
        // If there are directions being shown, clear them
        if (directionsDisplay != null) {
            directionsDisplay.setMap(null);
            directionsDisplay = null;
        }
    }
    // Completely clears map
    function clearMap() {
        clearMapMarkers();
        clearDirections();

        $('#destinations-count').html('0');
    }
    // Initial Google Maps
    google.maps.event.addDomListener(window, 'load', initializeMap);
    
    function display_route(n){
      nodes = [];
      console.log(nodes_team[n]);
      nodes = nodes_team[n];
      console.log(nodes_team[n]); 
      
      if (nodes.length < 2) {
        alert("No jobs to assign to this team");
        return;
//           if (prevNodes.length >= 2) {
//               nodes = prevNodes;
//           } else {
//               alert('Click on the map to select destination points');
//               return;
//           }
      }
      if (directionsDisplay != null) {
          //directionsDisplay.setMap(null);
          directionsDisplay = null;
      }

      $('#ga-buttons').hide();
      // Get route durations
      getDurations(function(){
          $('.ga-info').show();
          // Get config and create initial GA population
          ga.getConfig();
          var pop = new ga.population();
          pop.initialize(nodes.length);
          var route = pop.getFittest().chromosome;
          ga.evolvePopulation(pop, function(update) {
              $('#generations-passed').html(update.generation);
              var time_id = '.team'+n+' #best-time';
              $(time_id).empty().html((update.population.getFittest().getDistance() / 60).toFixed(2) + ' Mins');

              // Get route coordinates
              var route = update.population.getFittest().chromosome;
              var routeCoordinates = [];
              for (index in route) {
                  routeCoordinates[index] = nodes[route[index]];
              }
              routeCoordinates[route.length] = nodes[route[0]];
              // Display temp. route
              if (polylinePath != undefined) {
                  polylinePath.setMap(null);
              }
              polylinePath = new google.maps.Polyline({
                  path: routeCoordinates,
                  strokeColor: "#f066ff",
                  strokeOpacity: 0.75,
                  strokeWeight: 2,
              });
              //polylinePath.setMap(map);
          }, function(result) {
              // Get route
              route = result.population.getFittest().chromosome;
              // Add route to map
              directionsService = new google.maps.DirectionsService();
              directionsDisplay = new google.maps.DirectionsRenderer({
                                              polylineOptions: {
                                                strokeColor: getRandomColor()
                                              }
                                            });
              directionsDisplay.setMap(map);
              var waypts = [];
              for (var i = 1; i < route.length; i++) {
                  waypts.push({
                      location: nodes[route[i]],
                      stopover: true
                  });
              }

              // Add final route to map
              var request = {
                  origin: nodes[route[0]],
                  destination: nodes[route[0]],
                  waypoints: waypts,
                  travelMode: google.maps.TravelMode[$('#travel-type').val()],
                  avoidHighways: parseInt($('#avoid-highways').val()) > 0 ? true : false,
                  avoidTolls: false
              };
              directionsService.route(request, function(response, status) {
                  if (status == google.maps.DirectionsStatus.OK) {
                      directionsDisplay.setDirections(response);
                  }
                  //clearMapMarkers();
              });
          });
      });
    }
    //Get the random Route color
    function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    
    // Create listeners
    $(document).ready(function() {
        $('#clear-map').click(clearMap);
      
        // Start GA
        $('#find-route').click(function() {    
            
        });
    });
    // GA code
    var ga = {
        // Default config
        "crossoverRate": 0.5,
        "mutationRate": 0.1,
        "populationSize": 50,
        "tournamentSize": 5,
        "elitism": true,
        "maxGenerations": 50,

        "tickerSpeed": 60,
        // Loads config from HTML inputs
        "getConfig": function() {
            ga.crossoverRate = parseFloat($('#crossover-rate').val());
            ga.mutationRate = parseFloat($('#mutation-rate').val());
            ga.populationSize = parseInt($('#population-size').val()) || 50;
            ga.elitism = parseInt($('#elitism').val()) || false;
            ga.maxGenerations = parseInt($('#maxGenerations').val()) || 50;
        },

        // Evolves given population
        "evolvePopulation": function(population, generationCallBack, completeCallBack) {        
            // Start evolution
            var generation = 1;
            var evolveInterval = setInterval(function() {
                if (generationCallBack != undefined) {
                    generationCallBack({
                        population: population,
                        generation: generation,
                    });
                }
                // Evolve population
                population = population.crossover();
                population.mutate();
                generation++;

                // If max generations passed
                if (generation > ga.maxGenerations) {
                    // Stop looping
                    clearInterval(evolveInterval);

                    if (completeCallBack != undefined) {
                        completeCallBack({
                            population: population,
                            generation: generation,
                        });
                    }
                }
            }, ga.tickerSpeed);
        },
        // Population class
        "population": function() {
            // Holds individuals of population
            this.individuals = [];

            // Initial population of random individuals with given chromosome length
            this.initialize = function(chromosomeLength) {
                this.individuals = [];

                for (var i = 0; i < ga.populationSize; i++) {
                    var newIndividual = new ga.individual(chromosomeLength);
                    newIndividual.initialize();
                    this.individuals.push(newIndividual);
                }
            };

            // Mutates current population
            this.mutate = function() {
                var fittestIndex = this.getFittestIndex();
                for (index in this.individuals) {
                    // Don't mutate if this is the elite individual and elitism is enabled 
                    if (ga.elitism != true || index != fittestIndex) {
                        this.individuals[index].mutate();
                    }
                }
            };
            // Applies crossover to current population and returns population of offspring
            this.crossover = function() {
                // Create offspring population
                var newPopulation = new ga.population();

                // Find fittest individual
                var fittestIndex = this.getFittestIndex();
                for (index in this.individuals) {
                    // Add unchanged into next generation if this is the elite individual and elitism is enabled
                    if (ga.elitism == true && index == fittestIndex) {
                        // Replicate individual
                        var eliteIndividual = new ga.individual(this.individuals[index].chromosomeLength);
                        eliteIndividual.setChromosome(this.individuals[index].chromosome.slice());
                        newPopulation.addIndividual(eliteIndividual);
                    } else {
                        // Select mate
                        var parent = this.tournamentSelection();
                        // Apply crossover
                        this.individuals[index].crossover(parent, newPopulation);
                    }
                }

                return newPopulation;
            };
            // Adds an individual to current population
            this.addIndividual = function(individual) {
                this.individuals.push(individual);
            };
            // Selects an individual with tournament selection
            this.tournamentSelection = function() {
                // Randomly order population
                for (var i = 0; i < this.individuals.length; i++) {
                    var randomIndex = Math.floor(Math.random() * this.individuals.length);
                    var tempIndividual = this.individuals[randomIndex];
                    this.individuals[randomIndex] = this.individuals[i];
                    this.individuals[i] = tempIndividual;
                }
                // Create tournament population and add individuals
                var tournamentPopulation = new ga.population();
                for (var i = 0; i < ga.tournamentSize; i++) {
                    tournamentPopulation.addIndividual(this.individuals[i]);
                }
                return tournamentPopulation.getFittest();
            };

            // Return the fittest individual's population index
            this.getFittestIndex = function() {
                var fittestIndex = 0;
                // Loop over population looking for fittest
                for (var i = 1; i < this.individuals.length; i++) {
                    if (this.individuals[i].calcFitness() > this.individuals[fittestIndex].calcFitness()) {
                        fittestIndex = i;
                    }
                }
                return fittestIndex;
            };
            // Return fittest individual
            this.getFittest = function() {
                return this.individuals[this.getFittestIndex()];
            };
        },
        // Individual class
        "individual": function(chromosomeLength) {
            this.chromosomeLength = chromosomeLength;
            this.fitness = null;
            this.chromosome = [];
            // Initialize random individual
            this.initialize = function() {
                this.chromosome = [];
                // Generate random chromosome
                for (var i = 0; i < this.chromosomeLength; i++) {
                    this.chromosome.push(i);
                }
                for (var i = 0; i < this.chromosomeLength; i++) {
                    var randomIndex = Math.floor(Math.random() * this.chromosomeLength);
                    var tempNode = this.chromosome[randomIndex];
                    this.chromosome[randomIndex] = this.chromosome[i];
                    this.chromosome[i] = tempNode;
                }
            };

            // Set individual's chromosome
            this.setChromosome = function(chromosome) {
                this.chromosome = chromosome;
            };

            // Mutate individual
            this.mutate = function() {
                this.fitness = null;

                // Loop over chromosome making random changes
                for (index in this.chromosome) {
                    if (ga.mutationRate > Math.random()) {
                        var randomIndex = Math.floor(Math.random() * this.chromosomeLength);
                        var tempNode = this.chromosome[randomIndex];
                        this.chromosome[randomIndex] = this.chromosome[index];
                        this.chromosome[index] = tempNode;
                    }
                }
            };

            // Returns individuals route distance
            this.getDistance = function() {
                var totalDistance = 0;
                for (index in this.chromosome) {
                    var startNode = this.chromosome[index];
                    var endNode = this.chromosome[0];
                    if ((parseInt(index) + 1) < this.chromosome.length) {
                        endNode = this.chromosome[(parseInt(index) + 1)];
                    }
                    totalDistance += durations[startNode][endNode];
                }

                totalDistance += durations[startNode][endNode];

                return totalDistance;
            };
            // Calculates individuals fitness value
            this.calcFitness = function() {
                if (this.fitness != null) {
                    return this.fitness;
                }

                var totalDistance = this.getDistance();
                this.fitness = 1 / totalDistance;
                return this.fitness;
            };
            // Applies crossover to current individual and mate, then adds it's offspring to given population
            this.crossover = function(individual, offspringPopulation) {
                var offspringChromosome = [];
                // Add a random amount of this individual's genetic information to offspring
                var startPos = Math.floor(this.chromosome.length * Math.random());
                var endPos = Math.floor(this.chromosome.length * Math.random());
                var i = startPos;
                while (i != endPos) {
                    offspringChromosome[i] = individual.chromosome[i];
                    i++
                    if (i >= this.chromosome.length) {
                        i = 0;
                    }
                }
                // Add any remaining genetic information from individual's mate
                for (parentIndex in individual.chromosome) {
                    var node = individual.chromosome[parentIndex];
                    var nodeFound = false;
                    for (offspringIndex in offspringChromosome) {
                        if (offspringChromosome[offspringIndex] == node) {
                            nodeFound = true;
                            break;
                        }
                    }
                    if (nodeFound == false) {
                        for (var offspringIndex = 0; offspringIndex < individual.chromosome.length; offspringIndex++) {
                            if (offspringChromosome[offspringIndex] == undefined) {
                                offspringChromosome[offspringIndex] = node;
                                break;
                            }
                        }
                    }
                }
                // Add chromosome to offspring and add offspring to population
                var offspring = new ga.individual(this.chromosomeLength);
                offspring.setChromosome(offspringChromosome);
                offspringPopulation.addIndividual(offspring);
            };
        },
    };
    
    $(function(){
      
      $('.input-group.date').datepicker({
        format:'dd MM yyyy',
        autoclose: true
      }).on('change', function(){
        $('.datepicker').hide();
      });
  
    });
  </script>
  
</head>
<body>
  <?PHP 
  // INCLUDE THE menu.php FILE. THIS FILE IS USED TO DISPLAYS THE MENU
  include('menu.php'); 
  ?>
  <div class="loading hidden" style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;background: #0000004a url(../CARloader.gif) no-repeat fixed center;"></div>
  <div style="height: 100vh;">
  <div id="map-canvas" style="width:100vw; height:100vh;position:fixed!important;"></div>
  <div class="hr vpad"></div>
  <div>
    <div class="row">
      <div class="col-sm-3 datepicker_sec">
        <div class="input-group date">
          <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i>                 </span>
        </div>
        <div class="input-group">
          <button class="get_info_btn">SHOW</button>
        </div>
        <script type='text/javascript'>
            
          
                
          
        </script>
      </div>
    </div>
    
    <!-- DISPALY THE TEMPLATE_TEAMS  --> 
    <div class="row">
      <div class="col-sm-3 team_section">
        <div class="">
          <?php foreach ($rows as $row){ ?>
          <div class="row team<?php echo $row['temp_team_id']; ?>">
            <div class="col-sm-8 team_no">
              <p><?php echo $row['temp_team_id'] . ' ' . $row['temp_team_name']; ?></span>
            </div>
            <div class="col-sm-4">
              <button class="btn btn-primary mt-3" id="" onclick="display_route(<?php echo $row['temp_team_id']; ?>)">
                Route <i class="fa fa-truck"></i>
              </button>
              <p style="font-size:18px;line-height:1;" id="best-time"></p>
            </div>
            <div class="col-sm-12">
              <ul class="jobs_list pl-0">
              </ul>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <table>
        <tr style="display:none;">
            <td colspan="2"><b>Configuration</b></td>
        </tr>
        <tr style="display:none;">
            <td>Travel Mode: </td>
            <td>
                <select id="travel-type">
                    <option value="DRIVING">Car</option>
                    <option value="BICYCLING">Bicycle</option>
                    <option value="WALKING">Walking</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Avoid Highways: </td>
            <td>
                <select id="avoid-highways">
                    <option value="1">Enabled</option>
                    <option value="0" selected="selected">Disabled</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Population Size: </td>
            <td>
                <select id="population-size">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Mutation Rate: </td>
            <td>
                <select id="mutation-rate">
                    <option value="0.00">0.00</option>
                    <option value="0.05">0.01</option>
                    <option value="0.05">0.05</option>
                    <option value="0.1" selected="selected">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.4">0.4</option>
                    <option value="0.7">0.7</option>
                    <option value="1">1.0</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Crossover Rate: </td>
            <td>
                <select id="crossover-rate">
                    <option value="0.0">0.0</option>
                    <option value="0.1">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.3">0.3</option>
                    <option value="0.4">0.4</option>
                    <option value="0.5" selected="selected">0.5</option>
                    <option value="0.6">0.6</option>
                    <option value="0.7">0.7</option>
                    <option value="0.8">0.8</option>
                    <option value="0.9">0.9</option>
                    <option value="1">1.0</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Elitism: </td>
            <td>
                <select id="elitism">
                    <option value="1" selected="selected">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td>Max Generations: </td>
            <td>
                <select id="generations">
                    <option value="20">20</option>
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td colspan="2"><b>Debug Info</b></td>
        </tr>
        <tr style="display:none;">
            <td>Destinations Count: </td>
            <td id="destinations-count">0</td>
        </tr>
        <tr class="ga-info" style="display:none;">
            <td>Generations: </td><td id="generations-passed">0</td>
        </tr>
        <tr class="ga-info" style="display:none;">
            <td>Best Time: </td><td id="best-time">?</td>
        </tr>
        <tr id="ga-buttons" style="display:none;">
            <td colspan="2"><button id="find-route">Start</button> <button id="clear-map">Clear</button></td>
        </tr>
    </table>
  </div>
</div>
  
  
  <!-- END DASHBOARD CONTENT AREA -->
  <!-- START FOOTER -->
  <?PHP 
  // INCLUDE THE footer.php FILE. THIS FILE IS USED TO DISPLAYS EVERYTHING UNDER THE MAIN CONTENT AREA (IE. COPYRIGHT INFO)
  include ('footer.php'); 
  ?>
  <!-- END FOOTER --> 
</body>
<style>
  .gm-style-pbc {z-index: -2!important;}
  .tertiary-text{position: fixed;}
  #ga-buttons{position: absolute;top: 100px;}
  .blank_high{display:none!important;}
  .datepicker_sec input
  {    
      font-size: 25px!important;
      font-weight: bold!important;
      text-align: center!important;
      line-height: 1px;
  }
  .datepicker.dropdown-menu{width:300px;}
  .datepicker.dropdown-menu .table-condensed{width: 100%;}
  /*button:focus {outline: none!important;}*/
  input[type=radio], input[type=checkbox] {width: 20px;}
  .shadow {
    position: absolute;
  }
  .shadow::after {
    position: absolute;
    left: -125px;
    display: block;
    width: 50px;
    height: 50px;
    margin-top: -25px;
    content: '';
    transform: rotateX(55deg);
    border-radius: 50%;
    box-shadow: rgba(0, 0, 0, .5) 100px 0 20px;
  }
  .pulse {
    position: absolute;
    margin-top: -50px;
    margin-left: -50px;
    transform: rotateX(55deg);
  }
  .pulse::after {
    display: block;
    width: 100px;
    height: 100px;
    content: '';
    animation: pulsate 1s ease-out;
    animation-delay: 1.6s;
    animation-iteration-count: infinite;
    opacity: 0;
    border-radius: 50%;
    box-shadow: 0 0 1px 2px rgba(0, 0, 0, .5);
    box-shadow: 0 0 6px 3px rgba(99, 99, 252, 0.68);
  }
  @keyframes pulsate {
    0% {
      transform: scale(0.1, 0.1);
      opacity: 0;
    }
    50% {
      opacity: 1;
    }
    100% {
      transform: scale(1.2, 1.2);
      opacity: 0;
    }
  }
  .team_section ul li{
    font-size: 14px;
    font-weight: bold;
  }
  html, body{
    overflow-y:hidden!important;
  }
  .jobs_list, .jobs_list > li {
      list-style: none;
      height: 30px;
  }
</style>
</html>