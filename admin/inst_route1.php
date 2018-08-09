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

$q = $conn->prepare("SELECT * FROM install_teams WHERE isActive = 1");
$q->execute();
$rows = $q->fetchAll(PDO::FETCH_ASSOC);

if( isset($_POST['teamID']) && isset($_POST['jobID']) && isset($_POST['cur_date'])){
	$teamID = $_POST['teamID'];
	$jobID = $_POST['jobID'];
	$date = new DateTime($_POST['cur_date']);
	$curDate = $date->format('Y-m-d');
	$q = $conn->prepare("UPDATE projects SET install_team = :teamID WHERE id = :jobID");
	$q->bindParam('teamID',$teamID);
	$q->bindParam('jobID',$jobID);
	$q->execute();

	$q = $conn->prepare("
		SELECT projects.*, u.fname, u.lname, c.company AS comp_name, c.fname AS cFname, c.company AS cLname, s.name AS status
		FROM projects 
		JOIN users u
			ON u.id = projects.acct_rep 
		JOIN users c 
			ON c.id = projects.uid 
		JOIN status s 
			ON s.id = projects.job_status 
		WHERE projects.install_date = :install_date 
		  AND projects.job_status > 24 
		  AND projects.isActive = 1 
		ORDER BY 
			zip ASC,
			first_stop DESC,
			am DESC,
			pm ASC
	");

	$q->bindParam('install_date', $curDate);
	$q->execute();
	$jobs = $q->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($jobs);
	exit;
}

if( isset($_POST['date']) ){
	$date = new DateTime($_POST['date']);
	$curDate = $date->format('Y-m-d');
	$pastDate = date('Y-m-d', strtotime($curDate. ' - 8 days'));
	$limitDate = date('Y-m-d', strtotime($curDate. ' + 8 days'));
	$dateNow = date("Y-m-d");

	$q = $conn->prepare("
		SELECT projects.*, u.fname, u.lname, c.company AS comp_name, c.fname AS cFname, c.company AS cLname, s.name AS status
		FROM projects 
		JOIN users u
			ON u.id = projects.acct_rep 
		JOIN users c 
			ON c.id = projects.uid 
		JOIN status s 
			ON s.id = projects.job_status 
		WHERE projects.install_date = :install_date
		  AND projects.job_status > 24 
		  AND projects.isActive = 1
		ORDER BY 
			zip ASC,
			first_stop DESC,
			am DESC,
			pm ASC
	");

	$q->bindParam('install_date',$curDate);
	$q->execute();
	$jobs = $q->fetchAll(PDO::FETCH_ASSOC);
	$projects = getinfoByJob($jobs);

	$p = $conn->prepare("
		SELECT projects.*, u.fname, u.lname, c.company AS comp_name, c.fname AS cFname, c.company AS cLname
		FROM projects 
		JOIN users u
			ON u.id = projects.acct_rep 
		JOIN users c 
			ON c.id = projects.uid 
		WHERE projects.install_date <> :curDate 
		  AND projects.install_date >= :dateNow 
		  AND projects.install_date > :pastDate
		  AND projects.install_date < :limitDate
		  AND projects.job_status > 24 
		  AND projects.isActive = 1
		  ORDER BY zip ASC
	");

	$p->bindParam('curDate', $curDate);
	$p->bindParam('pastDate', $pastDate);
	$p->bindParam('limitDate', $limitDate);
	$p->bindParam('dateNow', $dateNow);
	$p->execute();
	$ex_jobs = $p->fetchAll(PDO::FETCH_ASSOC);

	//$extra_projects = getinfoByJob($ex_jobs);

	echo json_encode(array('projects'=>$projects,'extra_projects'=>$ex_jobs));
	exit;
}

function getinfoByJob($jobs){
	$result;
	$index = 0;
	foreach ($jobs as $job){
		if ($job['job_lat'] === NULL) {
			$address = $job['address_1'].' '. $job['city'].' '.$job['state'];
			$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4&address='.urlencode($address).'&sensor=false');
			$geo = json_decode($geo, true); // Convert the JSON to an array
			$job['address_job'] = $address;

			if (isset($geo['status']) && ($geo['status'] == 'OK')) {
				$latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
				$longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
				$job['lat'] = $latitude;
				$job['lng'] = $longitude;
				$result[$index] = $job;

				$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$u = $conn->prepare("UPDATE projects SET job_lat = :job_lat, job_long = :job_long WHERE id = :id");
				$u->bindParam('job_lat',$latitude);
				$u->bindParam('job_long',$longitude);
				$u->bindParam('id',$job['id']);
				$u->execute();

			} else {
				$latitude = 36.1175539; // Latitude
				$longitude = -80.0622948; // Longitude
				$job['lat'] = $latitude;
				$job['lng'] = $longitude;

				$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$u = $conn->prepare("UPDATE projects SET job_lat = :job_lat, job_long = :job_long WHERE id = :id");
				$u->bindParam('job_lat',$job['lat']);
				$u->bindParam('job_long',$job['lng']);
				$u->bindParam('id',$job['id']);
				$u->execute();

				$result[$index] = $job;
			}
		} else {
			$job['lat'] = $job['job_lat'];
			$job['lng'] = $job['job_long'];
			$result[$index] = $job;
		}
		$index++;
	}
	return $result;
}

function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4&address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        //var_dump($output);exit;
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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR" crossorigin="anonymous">


  
  
  <!--  INCLUDE bootstrap CSS & JS files for Datepicker  -->
<!--   <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"> -->
<?
include('includes.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">
<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>

  <!--    Google Map Javascript API    -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4">   </script>
<!--  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->  
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/markerclusterer.js"></script>
  
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
    var job_coords = [];
	  var installers = [];
    var pointHOME_initial = new google.maps.LatLng(36.1181642, -80.0626623,59);
		// $('.mdb-select').material_select();
    function markerCreator1(value,latitude,longitude){
		// $('.mdb-select').material_select('destroy');
		var html_str = "<div style = 'width:200px;min-height:40px'>";
		html_str += "<div id='myForm'>";
		html_str +=   "<p class='text-success'>Job: <b>" + value['job_name'] + ' - ' + value['job_sqft'] + "<sup>sf</sup></b></p>";
		html_str +=   "<p class='text-success'>Client: <b>";
		if (value['comp_name'] > '') {
			html_str += value['comp_name'];
		} else {
			html_str += value['cFname'] + ' ' + value['cLname'];
		}
		html_str += "</b></p>";
		html_str +=   "<p>Inst. Date: <b class='text-success'>" + value['install_date'] + "</b>";
		if (value['first_stop'] == 1) {
			html_str +=   "<b class='text-primary'> 1st Stop</b>";
		}else if (value['am'] == 1) {
			html_str +=   "<b class='text-primary'> AM</b>";
		}else if (value['pm'] == 1) {
			html_str +=   "<b class='text-primary'> PM</b>";
		}
		var instTeamID = value['install_team'];
		html_str +=   "<br>Installer: <b>" + installers[instTeamID] + "</b><br>";
		html_str +=   "Account rep: <b>" + value['fname'] + ' ' + value['lname'] + "</b></br>";
		html_str +=   "Address: <b>" + value['address_1'] + ', ';
		if (value['address_2'] != '' && value['address_2'] != null) {
			html_str +=   value['address_2'] + ', ';
		}
		html_str +=   value['city'] + ", ";
		html_str +=   value['state'] + " ";
		html_str +=   value['zip'] + "</b></p>";
		html_str +=   "<div class='container-fluid'>";
		html_str +=   "<div class='row'>";
		html_str +=     "<a class='btn btn-primary col-3' target='_blank' style='cursor:pointer' href='/admin/projects.php?edit&pid=" + value['id'] + "&uid=" + value['uid'] + "'><i class='fas fa-eye'></i></a>";
		<?
		if ($_SESSION['access_level'] == 1) {
		?>
			html_str +=     "<select class='form-control col-9 markersele border-0 select" + value['id'] + "' onchange='assign_btn("+value['id']+");'>";
		<?
			foreach ($rows as $row){ 
		?>
				var selectedTeam = <?php echo $row['inst_team_id']; ?>;
				html_str +=       "<option id='contactChoice<?php echo $row['inst_team_id']; ?>' value='<?php echo $row['inst_team_id']; ?>' "
				if (selectedTeam == value['install_team']) {
					html_str += 'selected';
				}
				html_str +=       " ><?php echo $row['inst_team_name']; ?></option>";
		<? 
			} 
		?>
			html_str +=     "</select>";
		<?
		}
		?>
		html_str +=    "</div>";
		if (longitude > 0) {
			html_str +=    "<a class='btn btn-success col-12 mt-2' style='cursor:pointer' target='_blank' href='https://maps.google.com/maps?11=" + latitude + "," + longitude + "&q=" + latitude + "," + longitude + "&hl=en&t=h&z=18'>Go <i class='fas fa-truck'></i></a>";
		}
		html_str +=    "</div>";
		html_str +=  "</div>";
		html_str += "</div>";
		return html_str;
	}
	<? 
	foreach ($rows as $row) { 
	?>
		installers[<?= $row['inst_team_id'] ?>] = '<?= $row['inst_team_name'] ?>';
	<? 
	} 
	?>


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
                '<!--<div class="shadow"></div>-->' +
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
		$('.mdb-select').material_select('destroy');
		// Map options
		var iconBase_home = '/images/map-icon.png';
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
			label: {
				text: " ",
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
			$('.modal').modal('hide');
			$('.modal-backdrop').hide();
			$('.mdb-select').material_select('destroy');
			$('.rteBtn').removeClass('hidden');
			// Map options
			var iconBase_home = '/images/map-icon.png';
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
						text: " ",
						color: "#ffffff",
						fontSize: "14px",
						overflow: "hidden",
						fontWeight: "bold",
						label: '703 Park Lawn Ct. Kernersville, NC 27284'
					},
					'bounds': true,
					url: "/",
					animation:google.maps.Animation.DROP,
					zIndex: 1.1,
					map: map
				}),  
				geocoder = new google.maps.Geocoder();
			var markerHOME = new CustomMarker({
				position: pointHOME,
				zIndex: 1.1,
				map: map
			});
			var infoWindow = new google.maps.InfoWindow();
			clearMap();
			$('.loading').removeClass('hidden');
			var cur_date = $('.datepicker_sec li .form-control').val();
			var bounds = new google.maps.LatLngBounds();
			$('.modalDelete').remove();
			$.ajax({
				type: 'post',
				data: {date: cur_date},
				success: function(response){
					
					$('.loading').addClass('hidden');
					//var marker;
          //console.log(response);
					var result = JSON.parse(response);
					var extra_projects = result.extra_projects;
					result = result.projects;
	
					if(result.length < 1){
						alert("There are no jobs");
						return;
					}
					// If there are directions being shown, clear them
					clearDirections();
					var iconBase = '/images/icon-normal.png';
					var iconBase1 = '/images/icon-am.png';
					var iconBase2 = '/images/icon-hold.png';
					var iconBase3 = '/images/icon-future.png';
	
					var joblist_str = [];
					for(var i=0;i<=1000;i++){
						nodes_team[i] = [];
						joblist_str[i] = '';
						nodes_team[i].push(pointHOME);
					}

					var plotLat = [];
					var plotLong = [];
					var plottedLat = [];
					var plottedLong = [];
					var time = 0;
					$.each(extra_projects, function(key, value){
						setTimeout(function() {
							var orderText = '';					
							var mText = {};
							if (value['first_stop'] == 1) {
								mText = {
									icon: iconBase3,
									text: value['install_date'] + ' 1st Stop',
									bg: 'yellow'
								}
							} else if (value['am'] == 1) {
								mText = {
									icon: iconBase3,
									text: value['install_date'] + ' AM',
									bg: 'yellow'
								}
							} else if (value['pm'] == 1) {
								mText = {
									icon: iconBase3,
									text: value['install_date'] + ' PM',
									bg: 'green'
								}
							} else {
								mText = {
									icon: iconBase3,
									text: value['install_date'],
									bg: 'yellow'
								}
							}

							if (value['job_lat'] != 0 || value['job_lat'] != null) {
								var latitude = parseFloat(value['job_lat']).toFixed(8);
								var longitude = parseFloat(value['job_long']).toFixed(8);

								if ($.inArray(latitude,plotLat) > -1) {
									do {
										var newLat = latitude - 0.001;
										latitude = parseFloat(newLat).toFixed(8);
										plotLat.push(parseFloat(latitude).toFixed(8));
									} while ($.inArray(latitude,plottedLat) > -1);
									do {
										var newLong = parseFloat(longitude) + 0.001;
										longitude = parseFloat(newLong).toFixed(8);
										plotLong.push(parseFloat(longitude).toFixed(8));
									} while ($.inArray(longitude,plottedLong) > -1);
								} else {
									plotLat.push(parseFloat(latitude).toFixed(8));
									plotLong.push(parseFloat(longitude).toFixed(8));
								}


								marker = new google.maps.Marker({
									position: new google.maps.LatLng(latitude, longitude),
									map: map,
									label: {
										text: ' ',
										color: '#CCC',
										fontSize: "12px",
										overflow: "hidden",
										fontWeight: "bold"
									},
									'bounds': true,
									icon: mText['icon'],
									title: mText['text'],
									url: "/",
									zIndex: 1.3,
									animation:google.maps.Animation.DROP
								});

								(function (marker, value) {
//                   $('.mdb-select').material_select('destroy');
//                   $('.mdb-select').material_select();
									google.maps.event.addListener(marker, "click", function (e) {
										$('.mdb-select').material_select('destroy');
										html_str = markerCreator1(value,latitude,longitude);
										infoWindow.setContent(html_str);
										infoWindow.open(map, marker);
                    					$('.markersele').addClass('mdb-select');
                    					$('.mdb-select').material_select();
									});
								})(marker, value);
								var point_item1 = new google.maps.LatLng(latitude, longitude);
								bounds.extend(point_item1);

							} else {

								var geocoder = new google.maps.Geocoder();
								var address = value['address_1'] +' '+ value['city']+' '+value['state'];
								geocoder.geocode( { 'address': address}, function(results, status) {
									console.log(status);
									if (status == 'OK') {
										var latitude = results[0].geometry.location.lat();
										var longitude = results[0].geometry.location.lng();
										if ($.inArray(latitude,plottedLat) > -1) {
											do {
												latitude = latitude - 0.0001;
											} while ($.inArray(latitude,plottedLat) > -1);
											do {
												longitude = longitude + 0.0001;
											} while ($.inArray(longitude,plottedLong) > -1);
										}
										plottedLat.push(latitude);
										plottedLong.push(longitude);
										marker = new google.maps.Marker({
											position: new google.maps.LatLng(latitude, longitude),
											map: map,
											label: {
												text: ' ',
												color: '#ccc',
												//color: "#ffffff",
												fontSize: "12px",
												overflow: "hidden",
												fontWeight: "bold"
											},
											'bounds': true,
											icon: mText['icon'],
											title: mText['text'],
											url: "/",
											zIndex: 1.3,
											animation:google.maps.Animation.DROP
										});
										(function (marker, value) {
											// $('.mdb-select').material_select('destroy');
											// $('.mdb-select').material_select();
											google.maps.event.addListener(marker, "click", function (e) {
												$('.mdb-select').material_select('destroy');
												html_str = markerCreator1(value,latitude,longitude);
												infoWindow.setContent(html_str);
												infoWindow.open(map, marker);
												$('.markersele').addClass('mdb-select');
												$('.mdb-select').material_select();
											});
										})(marker, value);
										var point_item1 = new google.maps.LatLng(latitude, longitude);
										bounds.extend(point_item1);
									} else {
										var latitude = 36.1181642;
										var longitude = -80.0626623;
										if ($.inArray(latitude,plottedLat) > -1) {
											do {
												latitude = latitude - 0.001;
											} while ($.inArray(latitude,plottedLat) > -1);
											do {
												longitude = longitude + 0.001;
											} while ($.inArray(longitude,plottedLong) > -1);
										}
										plottedLat.push(latitude);
										plottedLong.push(longitude);
										marker = new google.maps.Marker({
											position: new google.maps.LatLng(latitude, longitude),
											map: map,
											label: {
												text: ' ',
												color: '#ccc',
												fontSize: "12px",
												overflow: "hidden",
												fontWeight: "bold"
											},
											'bounds': true,
											icon: mText['icon'],
											title: mText['text'],
											url: "/",
											zIndex: 1.3,
											animation:google.maps.Animation.DROP
										});
										(function (marker, value) {
											// $('.mdb-select').material_select('destroy');
											// $('.mdb-select').material_select();
											google.maps.event.addListener(marker, "click", function (e) {
												$('.mdb-select').material_select('destroy');
												var html_str = markerCreator1(value,latitude,longitude);
												infoWindow.setContent(html_str);
												infoWindow.open(map, marker);
												$('.markersele').addClass('mdb-select');
												$('.mdb-select').material_select();
											});
										
										})(marker, value);
										var point_item1 = new google.maps.LatLng(latitude, longitude);
										bounds.extend(point_item1);
									} 
								});
							}
						}, time);
						time += 200;
					});

					job_coords = [];
					$.each( result, function( key, value ) {

						var orderText = '';					
						var mText = {};
						if (value['first_stop'] == 1) {
							orderText = '<span class="text-danger">1st Stop </span>';
							mText = {
								icon: iconBase1,
								text: '1st Stop ' + value['job_name'],
								bg: 'yellow'
							}
						} else if (value['am'] == 1) {
							orderText = '<span class="text-danger">AM </span>';
							mText = {
								icon: iconBase1,
								text: 'AM ' + value['job_name'],
								bg: 'yellow'
							}
						} else if (value['pm'] == 1) {
							orderText = '<span class="text-danger">PM </span>';
							mText = {
								icon: iconBase,
								text: 'PM ' + value['job_name'],
								bg: 'green'
							}
						} else {
							mText = {
								icon: iconBase,
								text: value['job_name'],
								bg: 'yellow'
							}
						}

						var latitude = parseFloat(value['lat']);
						var longitude = parseFloat(value['lng']);

						do {
							latitude = latitude - 0.001;
						} while ($.inArray(latitude,plottedLat) > -1);
						do {
							longitude = longitude + 0.001;
						} while ($.inArray(longitude,plottedLong) > -1);

						var tlat = 'lat' + value['id'];
						var tlong = 'long' + value['id'];

						job_coords[tlat] = latitude;
						job_coords[tlong] = longitude;

						plottedLat.push(latitude);
						plottedLong.push(longitude);

						var modalName = 'modalPull' + value['id'];
						var modalFunct = "$('#" + modalName + "').modal('show')";

						var teamID = value['install_team'];
						joblist_str[teamID] += compileList(value,latitude,longitude,modalFunct,orderText);


//						//console.log("^^^^^^^^^^^^^^^^^^^^^^^^^^^^^",value, teamID);
//						//joblist_str[teamID] += '<li>'+value['job_name']+'</li>'
//						joblist_str[teamID] += '<li class="list-group-item py-1"><div class="row"><div class="col-2"><div class="btn btn-sm mr-1 ';
//						if (value['job_status'] < 62 || value['job_status'] == 69) {
//							joblist_str[teamID] += 'btn-danger';
//						} else {
//							joblist_str[teamID] += 'btn-primary';
//						}
//						joblist_str[teamID] += '" style="cursor:pointer" onClick="targetMap('+latitude+','+longitude+')"><i class="fas fa-bullseye"></i></div></div><div class="col-10"><a class="text-primary text-left p-0" style="cursor:pointer; line-height:1.2; text-shadow:none" target="_blank" onClick="' + modalFunct + '">' + value['job_sqft'] + '<sup>sf</sup> - ' + value['comp_name'] + '<br>' + orderText + ' <b>' + value['order_num'] + '</b> ' + value['job_name'] + '<br><span style="color:#555;text-shadow:none;font-weight:normal;cursor:pointer">' + value['address_1'] + ', ' + value['city'] + ', ' + value['state'] + ', ' + value['zip'] + '</span></a></div></div>';

						var modalPull = '';
            //console.log(joblist_str[teamID]);

modalPull += '<div class="modal fade modalDelete" aria-hidden="true" aria-labelledby="' + modalName + 'Label" id="' + modalName + '" role="dialog" tabindex="-1">';
modalPull += '	<div class="modal-dialog modal-dialog-centered" role="document" >';
modalPull += '		<div class="modal-content">';
modalPull += '			<div class="modal-header">';
modalPull += '				<div class="modal-title">';
modalPull += '					<h2 class="d-inline text-primary"><i class="fas fa-map h2 text-warning"></i> Job data</h2><h6> - ' + value['status'] + '</h6>';
modalPull += '				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>';
modalPull += '			</div>';
modalPull += '			<div class="modal-body">';
modalPull += '				<div class="container">';

modalPull += '					<div class="row"><h2>Job: <span class="text-primary">'+value['job_name']+ '</span></h2></div>';

modalPull += '					<div class="row">';
									if (value['first_stop'] == 1){
										modalPull +=   "<p class='text-danger'><b>1st Stop</b></p>";
									}else if (value['am'] == 1) {
										modalPull +=   "<p class='text-danger'><b>AM</b></p>";
									}else if (value['pm'] == 1) {
										modalPull +=   "<p class='text-danger'><b>PM</b></p>";
									}

modalPull += '					</div>';

modalPull += '					<div class="row"><p>Account Rep: <b>' + value['fname'] + ' ' + value['lname'] + '</b></p></div>';
modalPull += '					<div class="row"><p>Address: <br><b>' + value['address_1'];
									if (value['address_2'] > '') {
										modalPull += ', ' + value['address_2'];
									}
modalPull += 						', ' + value['city'];
modalPull += 						', ' + value['state'];
modalPull += 						' ' + value['zip'];
modalPull += 					'</b></p></div>';
modalPull += '					<form class="row" id="form' + value['id'] + '">';
modalPull += '						<a class="btn btn-primary col-3" onClick='
modalPull += "'window.open(";
modalPull += 			'"/admin/projects.php?edit&pid=' + value['id'] + '&uid=' + value['uid'];
modalPull += 			'")';
modalPull += 			"'><i class='fas fa-eye'></i></a>";
//modalPull += '						<a class="btn btn-primary col-3" style="cursor:pointer" target="_blank" href="/admin/projects.php?edit&pid=' + value['id'] + '&uid=' + value['uid'] + '"><i class="fas fa-eye"></i></a>';

								<?php 
								if ($_SESSION['access_level'] == 1) {
								?>
modalPull += '						<select class="mdb-select form-control col-9 border-0 select' + value['id'] + '" onchange="assign_select(' + value['id'] + ');">';
								<?
								foreach ($rows as $row){ ?>

									var selectedTeam = <?php echo $row['inst_team_id']; ?>;
modalPull += '							<option id="contactChoice<?php echo $row['inst_team_id']; ?>" value="<?php echo $row['inst_team_id']; ?>" '
if (selectedTeam == value['install_team']) {modalPull += 'selected'};
modalPull += 							' ><?php echo $row['inst_team_name']; ?></option>';
<?php } ?>
modalPull += '						</select>';
								<?
								}
								?>
modalPull += "						<a class='btn btn-success col-12 mt-2' style='cursor:pointer' target='_blank' href='https://maps.google.com/maps?11=" + latitude + "," + longitude + "&q=" + latitude + "," + longitude + "&hl=en&t=h&z=18'>Go <i class='fas fa-truck'></i></a>";
modalPull += '					</form>';
modalPull += '				</div>';
modalPull += '			</div>';
modalPull += '			<div class="modal-footer">';
modalPull += '				<button class="btn btn-secondary" style="cursor:pointer" data-dismiss="modal" type="button">Close &#10008;</button>';
modalPull += '			</div>';
modalPull += '		</div>';
modalPull += '</div>';


						$('body').append(modalPull);
						marker = new google.maps.Marker({
							position: new google.maps.LatLng(latitude, longitude),
							map: map,
							label: {
								text: ' ',
								color: '#CCC',
								fontSize: "12px",
								overflow: "hidden",
								fontWeight: "bold"
							},
							'bounds': true,
							icon: mText['icon'],
							title: mText['text'],
							url: "/",
							zIndex: 2,
							animation:google.maps.Animation.DROP
						});


						var point_item = new google.maps.LatLng(latitude, longitude);
						point.push(point_item);
						markers.push(marker);
						nodes_team[teamID].push(point_item);
						bounds.extend(point_item);
						//Attach click event to the marker.
						(function (marker, value) {
							google.maps.event.addListener(marker, "click", function (e) {
 								$('.mdb-select').material_select('destroy');
								var html_str = markerCreator1(value,latitude,longitude);
								infoWindow.setContent(html_str);
								infoWindow.open(map, marker);
								$('.markersele').addClass('mdb-select');
								$('.mdb-select').material_select();
							});
						
						})(marker, value);
					
					});
					map.fitBounds(bounds);
					//map.panToBounds(bounds);
					var team_num = <?php echo $rows[count($rows)-1]['inst_team_id']; ?>;
					for(var i=0;i<=team_num;i++){
						$('.mdb-select').material_select('destroy');
						var team_id = '.row.team'+i+' .jobs_list';
						$(team_id).empty().html(joblist_str[i]); 
						$('.mdb-select').material_select();

					}
					
					// Update destination count
					$('#destinations-count').html(nodes.length);
					
				}
			});
		})

		function getlatlng(address){
			var geocoder = new google.maps.Geocoder();

			geocoder.geocode( { 'address': address}, function(results, status) {

				if (status == google.maps.GeocoderStatus.OK) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();
				} 
			}); 
		}




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




	function assign_btn(n) {
		$('.mdb-select').material_select('destroy');
		//$('.rteBtn').addClass('hidden');
		var cur_date = $('.datepicker_sec li .form-control').val();
		var team_select_id = $('select option:selected', '#myForm').val();
		$.ajax({
			type: 'post',
			data: {
				teamID: team_select_id,
				jobID: n,
				cur_date: cur_date
			},
			success: function(response) {
				clearDirections();
				$('.modal').modal('hide');
				$('.mdb-select').material_select('destroy');
				var currentStr = 'select.select' + n + ' option:selected';
				console.log(currentStr);
				$(currentStr).prop('selected',false);
				var newStr = "select.select" + n + ' option[value="' + team_select_id + '"]';
				console.log(newStr);
				$(newStr).prop('selected',true)
				var moveStr = '.team' + team_select_id + ' ul.jobs_list';
				console.log(moveStr);
				var toMove = '#list' + n;
				console.log(toMove);
				$(moveStr).append($(toMove).closest('li'));
				$('.mdb-select').material_select();
				//$('.get_info_btn').click();
//				var result = JSON.parse(response);
//				var joblist_str = [];
//				for (var i = 0; i <= 100; i++) {
//					joblist_str[i] = '';
//					nodes_team[i] = [];
//					nodes_team[i].push(pointHOME_initial);
//				}
//				$.each(result, function(key, value) {
//					var orderText = '';	
//					if (value['first_stop'] == 1) {
//						orderText = '<span class="text-danger">1st Stop </span>';
//					} else if (value['am'] == 1) {
//						orderText = '<span class="text-danger">AM </span>';
//					} else if (value['pm'] == 1) {
//						orderText = '<span class="text-danger">PM </span>';
//					} 
//					var modalName = 'modalPull' + value['id'];
//					var modalFunct = "$('#" + modalName + "').modal('show')";
//					var teamID = value['install_team'];
//					var latPull = 'lat' + value['id'];
//					var longPull = 'long' + value['id'];
//					var latResult = job_coords[latPull];
//					var longResult = job_coords[longPull];
//					console.log("--------------------");
//					console.log(latResult, longResult);
//					console.log("--------------------");
//					var point_item_assign = new google.maps.LatLng(latResult, longResult);
//					console.log(teamID);
//					nodes_team[teamID].push(point_item_assign);
//					console.log(nodes_team[teamID]);
//					var latitude = parseFloat(value['job_lat']).toFixed(8);
//					var longitude = parseFloat(value['job_long']).toFixed(8);
//					joblist_str[teamID] += compileList(value,latitude,longitude,modalFunct,orderText);

					//joblist_str[teamID] += '<li>'+value['job_name']+'</li>'
					//joblist_str[teamID] += '<li><a class="text-primary" target="_blank" onClick="' + modalFunct + '">' + value['job_name'] + '<br><span style="color:#555;text-shadow:none;font-weight:normal;cursor:pointer">' + value['address_1'] + ', ' + value['city'] + ', ' + value['state'] + ', ' + value['zip'] + '</span></a></li>';
//					joblist_str[teamID] += '<li class="list-group-item py-1"><div class="row"><div class="col-2"><div class="btn btn-sm mr-1 ';
//					if (value['job_status'] < 62 || value['job_status'] == 69) {
//						joblist_str[teamID] += 'btn-danger';
//					} else {
//						joblist_str[teamID] += 'btn-primary';
//					}
//					joblist_str[teamID] += '" style="cursor:pointer" onClick="targetMap('+latitude+','+longitude+')"><i class="fas fa-bullseye"></i></div></div><div class="col-10"><a class="text-primary text-left p-0" style="cursor:pointer; line-height:1.2; text-shadow:none" target="_blank" onClick="' + modalFunct + '">' + value['job_sqft'] + '<sup>sf</sup> - ' + value['comp_name'] + '<br>' + orderText + ' <b>' + value['order_num'] + '</b> ' + value['job_name'] + '<br><span style="color:#555;text-shadow:none;font-weight:normal;cursor:pointer">' + value['address_1'] + ', ' + value['city'] + ', ' + value['state'] + ', ' + value['zip'] + '</span></a></div></div></li>';
//				});
//				for (var i = 0; i <= <?php echo $rows[count($rows)-1]['inst_team_id']; ?>; i++) {
//					var team_id = '.row.team' + i + ' .jobs_list';
//					$(team_id).empty().html(joblist_str[i]);
//				}
			},
			error: function(data) {
				console.log(data);
			},
			complete: function() {
			}
		});
	}

	function targetMap(newLat,newLng) {
		map.setCenter(new google.maps.LatLng(newLat, newLng));
		map.setZoom(15);
		//	map.setCenter({
		//		lat : newLat,
		//		lng : newLng,
		//	});
	}

	function assign_select(n) {
		$('.mdb-select').material_select('destroy');
		//$('.rteBtn').addClass('hidden');
		var modalClose = 'modalPull' + n;
		var myForm = '#form' + n + ' select option:selected';
		var cur_date = $('.datepicker_sec li .form-control').val();
		var team_select_id = $(myForm).val();
		$.ajax({
			type: 'post',
			data: {
				teamID: team_select_id,
				jobID: n,
				cur_date: cur_date
			},
			success: function(response) {
				clearDirections();
				$('.modal').modal('hide');
				$('.mdb-select').material_select('destroy');
				var currentStr = 'select.select' + n + ' option:selected';
				console.log(currentStr);
				$(currentStr).prop('selected',false);
				var newStr = "select.select" + n + ' option[value="' + team_select_id + '"]';
				console.log(newStr);
				$(newStr).prop('selected',true)
				var moveStr = '.team' + team_select_id + ' ul.jobs_list';
				console.log(moveStr);
				var toMove = '#list' + n;
				console.log(toMove);
				$(moveStr).append($(toMove).closest('li'));
				$('.mdb-select').material_select();
				//$('.get_info_btn').click();
//				var result = JSON.parse(response);
//				var joblist_str = [];
//				for (var i = 0; i <= 100; i++) {
//					joblist_str[i] = '';
//					nodes_team[i] = [];
//					nodes_team[i].push(pointHOME_initial);
//				}
//				$.each(result, function(key, value) {
//					var orderText = '';	
//					if (value['first_stop'] == 1) {
//						orderText = '<span class="text-danger">1st Stop </span>';
//					} else if (value['am'] == 1) {
//						orderText = '<span class="text-danger">AM </span>';
//					} else if (value['pm'] == 1) {
//						orderText = '<span class="text-danger">PM </span>';
//					} 
//					var teamID = value['install_team'];
//					var latPull = 'lat' + value['id'];
//					var longPull = 'long' + value['id'];
//					var modalName = 'modalPull' + value['id'];
//					var modalFunct = "$('#" + modalName + "').modal('show')";
//					var latResult = job_coords[latPull];
//					var longResult = job_coords[longPull];
//					var point_item_assign = new google.maps.LatLng(latResult, longResult);
//					console.log(teamID);
//					nodes_team[teamID].push(point_item_assign);
//					console.log(nodes_team[teamID]);
//					var latitude = parseFloat(value['job_lat']).toFixed(8);
//					var longitude = parseFloat(value['job_long']).toFixed(8);
//					joblist_str[teamID] += compileList(value,latitude,longitude,modalFunct,orderText);

//					joblist_str[teamID] += '<li class="list-group-item py-1"><div class="row"><div class="col-2"><div class="btn btn-sm mr-1 ';
//					if (value['job_status'] < 62 || value['job_status'] == 69) {
//						joblist_str[teamID] += 'btn-danger';
//					} else {
//						joblist_str[teamID] += 'btn-primary';
//					}
//					joblist_str[teamID] += '" style="cursor:pointer" onClick="targetMap('+latitude+','+longitude+')"><i class="fas fa-bullseye"></i></div></div><div class="col-10"><a class="text-primary text-left p-0" style="cursor:pointer; line-height:1.2; text-shadow:none" target="_blank" onClick="' + modalFunct + '">' + value['job_sqft'] + '<sup>sf</sup> - ' + value['comp_name'] + '<br>' + orderText + ' <b>' + value['order_num'] + '</b> ' + value['job_name'] + '<br><span style="color:#555;text-shadow:none;font-weight:normal;cursor:pointer">' + value['address_1'] + ', ' + value['city'] + ', ' + value['state'] + ', ' + value['zip'] + '</span></a></div></div></li>';
//				});
//				for (var i = 0; i <= <? echo count($rows); ?>; i++) {
//					var team_id = '.row.team' + i + ' .jobs_list';
//					$(team_id).empty().html(joblist_str[i]);
//				}
			},
			error: function(response) {
				console.log('Error: ' + response);
			},
			complete: function() {
				$(modalClose).modal('hide');
				$('.modal').modal('hide');
			}
		});
	}

	function assign_list(n) {
		$('.mdb-select').material_select('destroy');
		//$('.rteBtn').addClass('hidden');
		var modalClose = 'modalPull' + n;
		var myForm = '#list' + n + ' select option:selected';
		var cur_date = $('.datepicker_sec li .form-control').val();
		var team_select_id = $(myForm).val();
		$.ajax({
			type: 'post',
			data: {
				teamID: team_select_id,
				jobID: n,
				cur_date: cur_date
			},
			success: function(response) {
				$('.modal').modal('hide');
				$('.mdb-select').material_select('destroy');

				var currentStr = 'select.select' + n + ' option:selected';
				console.log(currentStr);
				$(currentStr).prop('selected',false);

				var newStr = "select.select" + n + ' option[value="' + team_select_id + '"]';
				console.log(newStr);
				$(newStr).prop('selected', true);

				var moveStr = '.team' + team_select_id + ' ul.jobs_list';
				console.log(moveStr);
				var toMove = '#list' + n;
				console.log(toMove);
				$(moveStr).append($(toMove).closest('li'));

				$('.mdb-select').material_select();
				//$('.get_info_btn').click();
//				clearDirections();
//				$('.modal').modal('hide');
//				var result = JSON.parse(response);
//				var joblist_str = [];
//				for (var i = 0; i <= 100; i++) {
//					joblist_str[i] = '';
//					nodes_team[i] = [];
//					nodes_team[i].push(pointHOME_initial);
//				}
//				$.each(result, function(key, value) {
//					var orderText = '';	
//					if (value['first_stop'] == 1) {
//						orderText = '<span class="text-danger">1st Stop </span>';
//					} else if (value['am'] == 1) {
//						orderText = '<span class="text-danger">AM </span>';
//					} else if (value['pm'] == 1) {
//						orderText = '<span class="text-danger">PM </span>';
//					} 
//					var teamID = value['install_team'];
//					var latPull = 'lat' + value['id'];
//					var longPull = 'long' + value['id'];
//					var modalName = 'modalPull' + value['id'];
//					var modalFunct = "$('#" + modalName + "').modal('show')";
//					var latResult = job_coords[latPull];
//					var longResult = job_coords[longPull];
//					var point_item_assign = new google.maps.LatLng(latResult, longResult);
//					console.log(teamID);
//					nodes_team[teamID].push(point_item_assign);
//					console.log(nodes_team[teamID]);
//					var latitude = parseFloat(value['job_lat']).toFixed(8);
//					var longitude = parseFloat(value['job_long']).toFixed(8);
//					joblist_str[teamID] += compileList(value,latitude,longitude,modalFunct,orderText);
//				});
//				for (var i = 0; i <= <? echo count($rows); ?>; i++) {
//					var team_id = '.row.team' + i + ' .jobs_list';
//					$(team_id).empty().html(joblist_str[i]);
//					$('.mdb-select').material_select();
//				}
			},
			error: function(response) {
				console.log('Error: ' + response);
			},
			complete: function() {
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
			avoidTolls: true,
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
		nodes = nodes_team[n];
		if (nodes.length < 2) {
			alert("No jobs assigned to this team");
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
		//https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=40.6655101,-73.89188969999998&destinations=40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.6905615%2C-73.9976592%7C40.659569%2C-73.933783%7C40.729029%2C-73.851524%7C40.6860072%2C-73.6334271%7C40.598566%2C-73.7527626%7C40.659569%2C-73.933783%7C40.729029%2C-73.851524%7C40.6860072%2C-73.6334271%7C40.598566%2C-73.7527626&key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4

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
				var mins = Math.floor(update.population.getFittest().getDistance() / 60);
				var hours = Math.floor(mins/60);
				var removeMins = hours * 60;
				var totMins = Math.floor( mins - removeMins );
				$(time_id).empty().html('Driving time: <b>' + hours + ' hrs ' + totMins + ' mins</b>');
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
						strokeColor: getRandomColor(n)
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
					avoidTolls: true
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
	function getRandomColor(n) {
		if (n == 1) {
			color = '#000000';
		} else if (n == 2) {
			color = '#003366';
		} else if (n == 3) {
			color = '#184832';
		} else if (n == 4) {
			color = '#e85050';
		} else if (n == 5) {
			color = '#ff8800';
		} else if (n == 6) {
			color = '#a4d1f0';
		} else if (n == 7) {
			color = '#417b3e';
		} else if (n == 8) {
			color = '#003366';
		} else if (n == 9) {
			color = '#184832';
		} else if (n == 10) {
			color = '#e85050';
		} else if (n == 11) {
			color = '#ff8800';
		} else if (n == 12) {
			color = '#a4d1f0';
		} else if (n == 13) {
			color = '#417b3e';
		} else if (n == 14) {
			color = '#003366';
		} else if (n == 15) {
			color = '#184832';
		} else if (n == 16) {
			color = '#e85050';
		} else if (n == 17) {
			color = '#ff8800';
		} else if (n == 18) {
			color = '#a4d1f0';
		} else if (n == 19) {
			color = '#417b3e';
		} else if (n == 20) {
			color = '#003366';
		} else if (n == 21) {
			color = '#184832';
		} else if (n == 22) {
			color = '#e85050';
		} 
		//      var letters = '0123456789ABCDEF';
		//      var color = '#';
		//      for (var i = 0; i < 6; i++) {
		//        color += letters[Math.floor(Math.random() * 16)];
		//      }
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
					var instIndividual = this.individuals[randomIndex];
					this.individuals[randomIndex] = this.individuals[i];
					this.individuals[i] = instIndividual;
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
					var instNode = this.chromosome[randomIndex];
					this.chromosome[randomIndex] = this.chromosome[i];
					this.chromosome[i] = instNode;
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
						var instNode = this.chromosome[randomIndex];
						this.chromosome[randomIndex] = this.chromosome[index];
						this.chromosome[index] = instNode;
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
		$('.date').datepicker({
			format:'dd MM yyyy',
			autoclose: true
		}).on('change', function(){
			$('.datepicker').hide();
		});
	});

	function compileList(value,latitude,longitude,modalFunct,orderText) {
		var $str = '<li class="list-group-item py-1 ';

		if (value['job_status'] == 84) {
			$str += 'amber lighten-3'; 
		} else if (value['job_status'] > 84 && value['job_status'] != 89) {
			$str += 'purple lighten-3 '; 
		} else if (value['job_status'] == 89) {
			$str += 'red lighten-3'; 
		}

		$str += '"><div class="row" id="list' + value['id'] +'"><div class="col-3 col-md-2 text-center"><div class="btn btn-sm mr-1 ';
		if (value['job_status'] < 62 || value['job_status'] == 69) {
			$str += 'btn-danger';
		} else if (value['job_status'] < 72) {
			$str += 'btn-warning';
		} else {
			$str += 'btn-primary';
		}
		$str += '" style="cursor:pointer" onClick="targetMap('+latitude+','+longitude+')"><i class="fas fa-bullseye"></i></div>';

		if (value['job_status'] == 81) {
			$str += '<i class="fas fa-truck-loading text-success h3"></i> '; 
		} else if (value['job_status'] == 82) {
			$str += '<i class="fas fa-truck faa-passing animated text-success h3"></i> '; 
		} else if (value['job_status'] == 83) {
			$str += '<i class="fas fa-gavel faa-shake animated text-success h3"></i> '; 
		} else if (value['job_status'] == 84) {
			$str += '<i class="fas fa-exclamation-triangle faa-flash animated text-warning h3"></i> '; 
		} else if (value['job_status'] > 84 && value['job_status'] != 86 && value['job_status'] != 89) {
			$str += '<i class="fas fa-check text-success h3"></i> '; 
		} else if (value['job_status'] == 86) {
			$str += '<i class="fas far-thumbs-up faa-tada animated text-danger h3"></i> '; 
		} else if (value['job_status'] == 89) {
			$str += '<i class="fas fa-exclamation-triangle faa-flash animated text-danger h3"></i> '; 
		}

		$str += '</div><div class="col-9 col-md-10">';
<?
		if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14) {
?>
			$str += '<i class="fas fa-calendar-alt text-primary"  onclick="dc_modal(' + value['id'] + ')"></i> ';
<?
		}
?>
		$str += '<a class="text-primary text-left p-0 d-inline" style="cursor:pointer; line-height:1.2; text-shadow:none" target="_blank" onClick="' + modalFunct + '">' + value['job_sqft'] + '<sup>sf</sup> - ' + value['comp_name'] + '<br>' + orderText + ' <b>' + value['order_num'] + '</b> ' + value['job_name'] + '<br><span style="color:#555;text-shadow:none;font-weight:normal;cursor:pointer">' + value['address_1'] + ', ' + value['city'] + ', ' + value['state'] + ', ' + value['zip'] + '</span></a>';
		
		if (value['address_notes'] > '') {
			$str += '<p class="text-muted mb-0">Addr. Notes: <b>' + value['address_notes'] + '</b></p>';
		}

		$str +=     "<select class='mdb-select border-0 select" + value['id'] + "' onchange='assign_list("+value['id']+");'>";
		<?
			foreach ($rows as $row){ 
		?>
		var selectedTeam = <?php echo $row['inst_team_id']; ?>;
		$str +=       "<option id='contactChoice<?php echo $row['inst_team_id']; ?>' value='<?php echo $row['inst_team_id']; ?>' "
		if (selectedTeam == value['install_team']) {
			$str += 'selected';
		}
		$str +=       " ><?php echo $row['inst_team_name']; ?></option>";
		<? 
			} 
		?>
		$str +=     "</select></div></div></li>";


		return $str;
	}

	function dc_modal(pid) {
		$('#dc-pid').val(pid);
		$('#dc-staff').val(<?= $_SESSION['id'] ?>);
		$('#date_change').modal('show');
	}
function date_change() {
	if ($('#date_change_reason').val() == '') {
		alert("You must enter a reason for changing the install date.");
		return;
	}
	var user = $('#dc-staff').val();
	var pjt = $('#dc-pid').val();
	var cmt_comment = $('#date_change_reason').val();
	var install_date = $('#dc-install_date').val();

	var datastring = 'action=date_change&staffid=' + user + '&pid=' + pjt + '&cmt_comment=' + cmt_comment + '&install_date=' + install_date;
	console.log(datastring);
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);

			var toRemove = '#list' + pjt;
			$(toRemove).closest('li').remove();

			Command: toastr["error"]("Install Date Changed.", "Projects")
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": 300,
				"hideDuration": 1000,
				"timeOut": 5000,
				"extendedTimeOut": 1000,
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			$('#date_change').modal('hide');
		},
		error: function(data) {
			console.log(data);
		}
	});
}

</script>
<style>
.side-nav {
	width: 40%;
	min-width: 360px;
	background: url(../images/marble.jpg);
}
.side-nav ul, .side-nav li {
	margin-bottom: 5px;
}
/* .datepicker.dropdown-menu{
		top: 67px !important;
		right: 147px !important;
} */
.datepicker>div {
	display: block;
}
#myForm .btn.btn-primary.col-3 {
	margin: 0;
	padding: 0;
	padding-top: 10px;
	padding-bottom: 10px;
}
.gm-style-pbc {
	z-index: -2!important;
}
.tertiary-text {
	position: fixed;
}
#ga-buttons {
	position: absolute;
	top: 100px;
}
.blank_high {
	display:none!important;
}
.datepicker_sec li input { 
	margin-top: 7px;
	font-size: 25px!important;
	font-weight: bold!important;
	text-align: center!important;
	line-height: 1px;
}
.datepicker.dropdown-menu {
	width:300px;
}
.datepicker.dropdown-menu .table-condensed {
	width: 100%;
}
button:focus {
	outline: none!important;
}
input[type=radio], input[type=checkbox] {
	width: 20px;
}
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
.team_section ul li {
	font-size: 14px;
	font-weight: bold;
}
html, body {
	overflow-y:hidden!important;
}
/*   #myForm .select-wrapper.mdb-select{
	display: contents;
}
#myForm .select-wrapper span.caret,
#myForm .select-wrapper input.select-dropdown,*/
#myForm .select-wrapper ul.dropdown-content.select-dropdown {
	top: 50px!important;
} 
#myForm .markersele {
	padding: 0 0 0 10px;
	border: none;
}
#myForm input.select-dropdown {
	margin: 0px;
}
#myForm ul.dropdown-content.select-dropdown {
/*     position: fixed!important; */
/*     top: -70px!important;
left:-140px!important; */
}
.gm-style-iw,
.gm-style-iw > div { 
	overflow: unset!important;
}
.markersele {
	position: absolute;
	bottom: 0;
	right:0;
}
.select-wrapper input.select-dropdown {
	margin-bottom: 0;
}
</style>


</head>
<body class="hidden-sn grey-skin" style="margin: 0; padding: 0; overflow-x: hidden; background:none !important">
  <?PHP 
	include ('modal_date_change.php');

  // INCLUDE THE footer.php FILE. THIS FILE IS USED TO DISPLAYS EVERYTHING UNDER THE MAIN CONTENT AREA (IE. COPYRIGHT INFO)
  ?>
	<div class="loading hidden h-100 w-100 m-0 position-absolute" style="z-index: 3; touch-action: pan-x pan-y;background: #0000004a url(../images/icon.gif) no-repeat fixed center;"></div>
    <header>
        <!-- Sidebar navigation -->
        <div id="slide-out" class="side-nav">
			<div class="container" style="overflow-y:auto; overflow-x:hidden; max-height:100vh">
<!--
				<a class="button-collapse" >
					<i class="fas fa-times-circle"></i>
				</a>
-->
				<div class="row">
					<div class="col-12 pr-3 team_section">
						<?php 
						foreach ($rows as $row){ 
							$color = '';
							if ($row['inst_team_id'] == 1) {
								$color = '#000000';
							} else if ($row['inst_team_id'] == 2) {
								$color = '#003366';
							} else if ($row['inst_team_id'] == 3) {
								$color = '#184832';
							} else if ($row['inst_team_id'] == 4) {
								$color = '#e85050';
							} else if ($row['inst_team_id'] == 5) {
								$color = '#ff8800';
							} else if ($row['inst_team_id'] == 6) {
								$color = '#a4d1f0';
							} else if ($row['inst_team_id'] == 7) {
								$color = '#417b3e';
							} else if ($row['inst_team_id'] == 8) {
								$color = '#003366';
							} else if ($row['inst_team_id'] == 9) {
								$color = '#184832';
							} else if ($row['inst_team_id'] == 10) {
								$color = '#e85050';
							} else if ($row['inst_team_id'] == 11) {
								$color = '#ff8800';
							} else if ($row['inst_team_id'] == 12) {
								$color = '#a4d1f0';
							} else if ($row['inst_team_id'] == 13) {
								$color = '#417b3e';
							} else if ($row['inst_team_id'] == 14) {
								$color = '#003366';
							} else if ($row['inst_team_id'] == 15) {
								$color = '#184832';
							} else if ($row['inst_team_id'] == 16) {
								$color = '#e85050';
							} else if ($row['inst_team_id'] == 17) {
								$color = '#ff8800';
							} else if ($row['inst_team_id'] == 18) {
								$color = '#a4d1f0';
							} else if ($row['inst_team_id'] == 19) {
								$color = '#417b3e';
							} else if ($row['inst_team_id'] == 20) {
								$color = '#003366';
							} else if ($row['inst_team_id'] == 21) {
								$color = '#184832';
							} else if ($row['inst_team_id'] == 22) {
								$color = '#e85050';
							} else {
								$color = '#CCCCCC';
							}
						?>
						<div class="row team<?= $row['inst_team_id'] ?>">
							<div class="col-1 team_no">
								<?
								if ($row['inst_team_id'] > 0) {
								?>
								<i class="fa fa-truck" style="color:<?PHP echo $color ?>; font-size: 1.6rem"></i><br>
								<?
								}
								?>
							</div>
							<div class="col-8 team_no">
								<span class="pl-1">
								<? 
								if ($row['inst_team_id'] == 0) {
									echo '<span class="text-primary">Installer: </span>' . $row['inst_team_name'];
								} else {
									echo $row['inst_team_name'];
								}
								?>
								</span>
							</div>
							<div class="col-3">
								<?
								if ($row['inst_team_id'] > 0) {
								?>
								<button class="btn btn-sm btn-primary mt-1 rteBtn" style='cursor:pointer' onclick="display_route(<?php echo $row['inst_team_id']; ?>)"><i class="far fa-route"></i></button>
								<?
								}
								?>
							</div>
							<div class="col-12">
								<ul class="jobs_list list-group"></ul>
							</div>
							<div class="col-12">
								<p id="best-time" style="font-size:18px;line-height:1;"></p>
							</div>
						</div>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
            <div class="sidenav-bg mask-strong"></div>
        </div>
        <!--/. Sidebar navigation -->
        <!-- Navbar -->
        <nav class="navbar navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
            <!-- SideNav slide-out button -->
            <div class="float-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
            </div>
            <!-- Breadcrumb-->
            <div class="breadcrumb-dn mr-auto">
				<img class="img-fluid" src="../images/icon.png"  style="max-width:52px; margin-left: 20px" alt="Amanzi">
            </div>
            <ul class="nav navbar-nav nav-flex-icons ml-auto datepicker_sec">
                <li class="nav-item">
					        <input class="form-control date" type="text" placeholder="Select date">
                </li>
                <li class="nav-item">
					        <button class="btn btn-success get_info_btn" style="cursor:pointer;">SHOW</button>
                </li>
            </ul>
        </nav>
        <!-- /.Navbar -->
    </header>
	<div class="row">

		<div class="col-12" style="height: 100vh;">
			<div id="map-canvas" style="width:100%; height:100vh;position:fixed!important;"></div>
			<div class="hr vpad"></div>
			<div>
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
        <tr style="display: none;">
            <td colspan="2"><b>Debug Info</b></td>
        </tr>
        <tr style="display: none;">
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
  <!-- END FOOTER --> 
</body>
<script>
$( document ).ready(function() {
	// SideNav Button Initialization
	$(".button-collapse").sideNav({
		closeOnClick: true
	});		
	//$('.button-collapse').sideNav('hide');
	// SideNav Scrollbar Initialization
	var sideNavScrollbar = document.querySelector('.custom-scrollbar');
	Ps.initialize(sideNavScrollbar);
});
//$('.button-collapse').click(function() {
//	$('.mdb-select').material_select('destroy');
//	$('.mdb-select').material_select();
//})

</script>

</html>