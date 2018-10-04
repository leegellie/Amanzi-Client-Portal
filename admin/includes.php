<?
$version = "v";
$version .= date('mdY', time());
?>
<!-- VERSION: <?= $version ?> -->

<!-- ////////////////////////////////    CSS   /////////////////////////////////////////-->
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.10/css/mdb.min.css" rel="stylesheet">

<link href="/styles/bootstrap/docs/css/iconFont.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css2/styles.css">
<link rel="stylesheet" type="text/css" href="../css2/mdb.css">
<link rel="stylesheet" type="text/css" href="/css2/ie10.css">
<link rel="stylesheet" type="text/css" href="/css2/font-awesome-animation.min.css">
	<style>
	  .pika-button.pika-day{font-weight:bold!important;color:grey;}
	</style>


<!-- ////////////////////////////////    JS   /////////////////////////////////////////-->



<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.10/js/mdb.min.js"></script>
<script defer src="https://pro.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-eAVkiER0fL/ySiqS7dXu8TLpoR8d9KRzIYtG0Tz7pi24qgQIIupp0fn2XA1H90fP" crossorigin="anonymous"></script>
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
<!--<script src="../js/modules/forms-free.js"></script>-->
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
<!--<script src="../js/modules/picker-date.js"></script>-->
<script src="../js/modules/picker-time.js"></script>
<script src="../js/modules/picker.js"></script>
<script src="../js/modules/preloading.js"></script>
<script src="../js/modules/range-input.js"></script>
<script src="../js/modules/scrollbar.js"></script>
<script src="../js/modules/scrolling-navbar.js"></script>
<script src="../js/modules/sidenav.js"></script>
<script src="../js/modules/smooth-scroll.js"></script>
<!--<script src="../js/modules/waves.js"></script>-->
<script src="../js/modules/wow.js"></script>
<script src="../js/addons/datatables.min.js"></script>
<!--<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->

<script src="js/clipboard.min.js"></script>
<script src="js/price_materials.js"></script>
<script src="js/bootstrap-datepicker.js"></script>


<script src="js/pikaday.js"></script>
<script src="js/pikaday.jquery.js"></script>
<script src="js/bootstrap-combobox.js"></script>
<script>

	$("#searchBox").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filter").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
//	$('.table').not( ".dynamic" ).DataTable({
//		"pageLength": 100,
//		"aoColumnDefs" : [{
//			'bSortable' : false,
//			'aTargets' : [ -1 ]
//		}]
//	});


	$inFocus = true;
	window.onfocus = function() { $inFocus = true; console.log('true'); };
	window.onblur = function() { $inFocus = false; console.log('false'); };

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

$(document).ready(function() {
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");


	$('.addChg').change( function() {
		$('.addVF').addClass('hidden');
		$('.addFA').addClass('hidden');
		$('.addLU').removeClass('hidden');
		$('#address_verif').val(0);
		$addChange = 1;
	})
});
</script>