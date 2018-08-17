<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="/styles/bootstrap/docs/css/iconFont.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css2/styles.css">
<link rel="stylesheet" type="text/css" href="../css2/mdb.css">

<link rel="stylesheet" type="text/css" href="/css2/ie10.css">
<link rel="stylesheet" type="text/css" href="/css2/font-awesome-animation.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs" crossorigin="anonymous">



<script src="../js/mdb.min.js"></script>
<script src="../js/modules/toastr.js"></script>
<script src="../js/modules/buttons.js"></script>
<script src="../js/modules/cards.js"></script>
<script src="../js/modules/character-counter.js"></script>
<script src="../js/modules/chart.js"></script>
<script src="../js/modules/chips.js"></script>
<script src="../js/modules/collapsible.js"></script>
<script src="../js/modules/dropdown.js"></script>
<script src="../js/modules/enhanced-modals.js"></script>
<script src="../js/modules/file-input.js"></script>
<script src="../js/modules/forms-free.js"></script>
<script src="../js/modules/hammer.js"></script>
<script src="../js/modules/jarallax-video.js"></script>
<script src="../js/modules/jarallax.js"></script>
<script src="../js/modules/jquery.easing.js"></script>
<script src="../js/modules/jquery.easypiechart.js"></script>
<script src="../js/modules/jquery.hammer.js"></script>
<script src="../js/modules/jquery.sticky.js"></script>
<script src="../js/modules/lightbox.js"></script>
<script src="../js/modules/material-select.js"></script>
<script src="../js/modules/mdb-autocomplete.js"></script>
<script src="../js/modules/picker-date.js"></script>
<script src="../js/modules/picker-time.js"></script>
<script src="../js/modules/picker.js"></script>
<script src="../js/modules/preloading.js"></script>
<script src="../js/modules/range-input.js"></script>
<script src="../js/modules/scrollbar.js"></script>
<script src="../js/modules/scrolling-navbar.js"></script>
<script src="../js/modules/sidenav.js"></script>
<script src="../js/modules/smooth-scroll.js"></script>
<script src="../js/modules/waves.js"></script>
<script src="../js/modules/wow.js"></script>

<script src="js/clipboard.min.js"></script>
<script src="js/price_materials.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script>
	var x = document.getElementById("location-div");
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition, showError);
		} else { 
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}

	function showPosition(position) {
		var $lat = position.coords.latitude;
		var $long = position.coords.longitude;
		var datastring = 'action=location_log&latitude=' + $lat + '&longitude=' + $long;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if( isMobile.any() ) {
					setTimeout(function(){ getLocation(); }, 600000);
				}
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	}

	function showError(error) {
		switch(error.code) {
			case error.PERMISSION_DENIED:
				x.innerHTML = "User denied the request for Geolocation."
				break;
			case error.POSITION_UNAVAILABLE:
				x.innerHTML = "Location information is unavailable."
				break;
			case error.TIMEOUT:
				x.innerHTML = "The request to get user location timed out."
				break;
			case error.UNKNOWN_ERROR:
				x.innerHTML = "An unknown error occurred."
				break;
		}
	}


$(document).ready(function(){
	$("#searchBox").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filter").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	$('.table').DataTable({
		"pageLength": 100,
		"aoColumnDefs" : [{
			'bSortable' : false,
			'aTargets' : [ -1 ]
		}]
	});
	$('.mdb-select').material_select('destroy');
	$('select').addClass('mdb-select');
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
	$('select[name=DataTables_Table_0_length]').addClass('mdb-select');
	$('.mdb-select').material_select();
});


	</script>