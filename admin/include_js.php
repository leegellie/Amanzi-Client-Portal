<?
$version = "v";
$version .= date('mdY', time());
?>
<!-- VERSION: <?= $version ?> -->

<!-- ////////////////////////////////    JS   /////////////////////////////////////////-->



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

<script src="js/clipboard.min.js"></script>
<script src="js/price_materials.js"></script>
<script src="js/bootstrap-datepicker.js"></script>


<script src="js/pikaday.js"></script>
<script src="js/pikaday.jquery.js"></script>
<script src="js/bootstrap-combobox.js"></script>
<script>
var entityMap = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'"': '&quot;',
	"'": '&#39;',
	'/': '&#x2F;',
	'`': '&#x60;',
	'=': '&#x3D;'
};

function escapeHtml(string) {
	return String(string).replace(/[&<>"'`=\/]/g, function (s) {
		return entityMap[s];
	});
}

	</script>
	<style>
	  .pika-button.pika-day{font-weight:bold!important;color:grey;}
	</style>



<script>

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


$(document).ready(function(){
	$('.mdb-select').material_select('destroy');
	$("#searchBox").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filter").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	window.onfocus = function() { $inFocus = true; console.log('true'); };
	window.onblur = function() { $inFocus = false; console.log('false'); };
	if ( $( 'table' ).length ) {
		$('table').DataTable();
	}
//	$('.table').not( ".dynamic" ).DataTable({
//		"pageLength": 100,
//		"aoColumnDefs" : [{
//			'bSortable' : false,
//			'aTargets' : [ -1 ]
//		}]
//	});
	$('select').addClass('mdb-select');
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
	var res = <?= json_encode($output); ?>; //for the template_date 
	var resforinstall = <?= json_encode($outputforinstall); ?>; //for the install_date 
	var holi = '<?php echo json_encode($holidays); ?>';
	var currently_sqft = '<?php echo $limitinfo[0]['install_sqft']; ?>';
	var template_num = '<?php echo $limitinfo[0]['templates_number']; ?>';
	var access_level = '<?php echo $_SESSION['access_level']; ?>';
	var session_id = '<?php echo $_SESSION['id']; ?>';
	console.log("session id",session_id);

	var holidays = jQuery.parseJSON(holi);
	// for template date
	var atr = 0;
	var cur_day = [];
	var approv_day = [];
	var cur_mo = [];
	var approv_mon = [];
	// for install date  
	var atr_ins = 0;
	var cur_day_ins = [];
	var approv_day_ins = [];
	var cur_mo_ins = [];
	var approv_mon_ins = [];
	var disable = false;
	var cur_d = new Date();
	var _cur_day = cur_d.getDate();
	var _cur_mon = cur_d.getMonth();
	function distance(lat1, lon1, lat2, lon2) {
		var radlat1 = Math.PI * lat1/180
		var radlat2 = Math.PI * lat2/180
		var theta = lon1-lon2
		var radtheta = Math.PI * theta/180
		var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
		dist = Math.acos(dist)
		dist = dist * 180/Math.PI
		dist = dist * 60 * 1.1515;
		return dist
	}
	var $datepicker = $('.datepicker').pikaday({
		firstDay: 1,
		minDate: new Date(),
		maxDate: new Date(2020, 12, 31),
		yearRange: [2000,2020],
		disableDayFn: function(theDate) {
			var formattedDate = new Date(theDate);
			var jday = formattedDate.getDay();
			var d = formattedDate.getDate();
			var st_d = d;
			var m =  formattedDate.getMonth();
			var st_m = m;
			m += 1;  // JavaScript months are 0-11
			var y = formattedDate.getFullYear();
			if (d < 10) {
				d = "0" + d;
			}
			if (m < 10) {
				m = "0" + m;
			}
			var job_day = formattedDate.getDay();
			var curdate = y+'-'+m+'-'+d;
			console.log("here --- ", curdate);
			//console.log(curdate,"-----", jday); 
			var flag = false;
			if(jday == 0 || jday == 6) flag = true;
			$.each(res, function(key, value){
				if(value['template_date'] == curdate){
					var jobs_num = value['detail'].length;
					if (jobs_num >= template_num){
						flag = true;
					}else{  
						var lat1 = 36.1181642;
						var lon1 = -80.0626623;
						var lat2 = $('#p-geo-lat').val();
						var lon2 = $('#p-geo-long').val();
						var distan = distance(lat1,lon1,lat2,lon2);
						if(distan > 25){
							$.each(value['detail'], function(k,v){
								var temp_lat = v['job_lat'];
								var temp_lang = v['job_long'];
								var each_dis = distance(lat2, lon2, temp_lat, temp_lang);
								if(each_dis < 15){
									atr = 1;
								}
							})
							if ( atr == 1){
								cur_day.push(st_d);
								cur_mo.push(st_m);
								atr = 0;
							}else{
								approv_day.push(st_d);
								approv_mon.push(st_m);
							}
						}
					}
				}
			});
			$.each(holidays, function(k, v){
				var f_day = new Date(v['start_date']);
				var e_day = new Date(v['end_date']);
				if(Date.parse(f_day) <= Date.parse(formattedDate) && Date.parse(e_day) >= Date.parse(formattedDate)){
					flag = true;
				}
			});
			if (session_id == 1 || session_id == 13 || session_id == 14  || session_id == 985 || session_id == 1444 || session_id == 4 || session_id == 1452)  flag = false;
			return flag;
		},
		onDraw(){
			var curmm = $('.pika-select').val();
			var d = new Date();
			var n = d.getMonth();
			//console.log(cur_day);
			//if(n == curmm){
			for(var i=0;i<cur_day.length;i++){
				if(curmm == cur_mo[i]){
					var class_btn = ".pika-button[data-pika-day='"+cur_day[i]+"']";
					$(class_btn).css({
						"background":"rgb(144, 186, 255)",
						"color":"black"
					});
				}
			}
			for(var i=0;i<approv_day.length;i++){
				if(curmm == approv_mon[i]){
					var class_btn = ".pika-button[data-pika-day='"+approv_day[i]+"']";
					$(class_btn).css({
						"background":"rgb(244, 151, 159)",
						"color":"black"
					}); 
				}
			}
			//}
		}
	});
	var $datepicker1 = $('.datepicker1').pikaday({
		firstDay: 1,
		minDate: new Date(),
		maxDate: new Date(2020, 12, 31),
		yearRange: [2000,2020],
		disableDayFn: function(theDate) {
			var formattedDate = new Date(theDate);
			var jday = formattedDate.getDay();
			var d = formattedDate.getDate();
			var st_d = d;
			var m =  formattedDate.getMonth();
			var st_m = m;
			m += 1;  // JavaScript months are 0-11
			var y = formattedDate.getFullYear();
			if (d < 10) {
				d = "0" + d;
			}
			if (m < 10) {
				m = "0" + m;
			}
			var job_day = formattedDate.getDay();

			var curdate = y+'-'+m+'-'+d;
			console.log("currenlty date = ",curdate);          
			var flag = false;
			if(jday == 0 || jday == 6) flag = true;
	console.log("today: ", _cur_day, "currently month = ", _cur_mon);
			//           if((access_level != 1 || access_level != 14 ) && st_d < _cur_day + 7 ) flag = true;
			var $repair = $('input[name=repair]').val();
			if(!(session_id == 1 || session_id == 13 || session_id == 14 || session_id == 985 || session_id == 1444 || session_id == 1448 || session_id == 1452) && (st_m == _cur_mon && st_d < _cur_day + 7 )) flag = true;
			$.each(resforinstall, function(key, value){
				if(value['install_date'] == curdate){
					var sum_sqft = 0;
					$.each(value['detail'], function(k,v){
						console.log( parseInt(v['job_sqft']) );
						sum_sqft += parseInt(v['job_sqft']);
					})
					var cur_sqft = $('#p-job-sqft').val();

		sum_sqft += parseInt(cur_sqft*1);
					console.log('sum_sqft=' + sum_sqft);
					console.log('cur_sqft=' + cur_sqft);
					console.log('currently_limit_sqft', currently_sqft);
					console.log('current_day',curdate);
					if (sum_sqft > currently_sqft) {
						flag = true;
					}else{  
						var lat1 = 36.1181642;
						var lon1 = -80.0626623;
						var lat2 = $('#p-geo-lat').val();
						var lon2 = $('#p-geo-long').val();
						//console.log(lat2,"************************", lon2);
						var distan = distance(lat1,lon1,lat2,lon2);
						if(distan > 25){
							$.each(value['detail'], function(k,v){
								var temp_lat = v['job_lat'];
								var temp_lang = v['job_long'];
								var each_dis = distance(lat2, lon2, temp_lat, temp_lang);
								if(each_dis < 15){
									atr_ins = 1;
								}
							})
							if ( atr_ins == 1){
								cur_day_ins.push(st_d);
								cur_mo_ins.push(st_m);
								atr_ins = 0;
							}else{
								approv_day_ins.push(st_d);
								approv_mon_ins.push(st_m);
							}
						}
					}
				}
			});
			$.each(holidays, function(k, v){
				var f_day = new Date(v['start_date']);
				var e_day = new Date(v['end_date']);
				if(Date.parse(f_day) <= Date.parse(formattedDate) && Date.parse(e_day) >= Date.parse(formattedDate)){
					flag = true;
				}
			});
			if(session_id == 1 || session_id == 13  || session_id == 14  || session_id == 985 || session_id == 1444 || session_id == 1448 || session_id == 1452 || $repair == 1)  flag = false;
			return flag;
		},
		onDraw() {
			var curmm = $('.pika-select').val();
			var d = new Date();
			var n = d.getMonth();
			// console.log(cur_day);
			// if(n == curmm) {
			for (var i=0; i<cur_day_ins.length; i++) {
				if(curmm == cur_mo_ins[i]){
					var class_btn = ".pika-button[data-pika-day='"+cur_day_ins[i]+"']";
					$(class_btn).css({
						"background":"rgb(144, 186, 255)",
						"color":"black"
					});
				}
			}
			for(var i=0;i<approv_day_ins.length;i++){
				if(curmm == approv_mon_ins[i]){
					var class_btn = ".pika-button[data-pika-day='"+approv_day_ins[i]+"']";
					$(class_btn).css({
						"background":"rgb(244, 151, 159)",
						"color":"black"
					}); 
				}
			}
			//}
		}
	});

	$('.mdb-select').material_select();
});


	</script>