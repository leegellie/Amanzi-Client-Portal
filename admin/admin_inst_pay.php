<div class="w-100">
	<div class="col-12" style="margin-left:0">
		<div id="user-data" class="col-12">
			<div class="row">
				<h1 class="text-primary col-10">Installer Pay</h1>
			</div>
			<div id="user-block" class="content">
				<div class="row">
					<div class="col-5"></div>
					<div class="col-3 t-sec">
						<h5 id="title">Week Commencing: </h5>
					</div>
					<div class="col-2 date-sec">
						<div class="form-group">
							<div class="input-group" id="DateDemo">
								<input type='text' id='weeklyDatePicker' placeholder="Select Week" />
							</div>
						</div>
					</div>
					<div class="col-1">
						<div class="btn btn-sm btn-primary" onclick="viewThisDate()" style="cursor:pointer">
							<span class="d-none d-lg-block">View </span>
							<i class="fas fa-eye"></i>
						</div>
					</div>
				</div>
			</div>
			<div id="pjt-block" class="content">
				<div class="col-12" id="pjtResults"></div>
			</div>
			<div id="inst-list" class="content">
				<div class="col-12" id="pjtDetails"></div>
			</div>
			<div id="inst-block" class="content">
				<div class="col-12" id="instDetails"></div>
			</div>
		</div>
	</div>
</div>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
$(document).ready(function(){
	moment.locale('en', {
		week: { dow: 1 } // Monday is the first day of the week
	});
	//Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
	$("#weeklyDatePicker").datetimepicker({
		format: 'MM-DD-YYYY'
	});
	//Get the value of Start and End of Week
	$('#weeklyDatePicker').on('dp.change', function (e) {
		var value = $("#weeklyDatePicker").val();
		var firstDate = moment(value, "MM-DD-YYYY").day(1).format("MM/DD/YYYY");
		var lastDate =  moment(value, "MM-DD-YYYY").day(7).format("MM/DD/YYYY");
		$("#weeklyDatePicker").val(firstDate);
	});
	$(".TableHolder tr td, .TableHolder tr:not(:first-child) th").hover(
		function() {
			$(this).addClass("TDActiv");
		},
		function() {
			$(this).removeClass("TDActiv");
		}
	);
	$(".TableHolder tr td").hover(
		function() {
			$(this)
				.parent()
				.find("th")
				.css("background-color", "rgba(0,0,0,0.7)");
		},
		function() {
			$(this)
				.parent()
				.find("th")
				.css("background-color", "inherit");
		}
	);
});
function updatePay(id) {
	console.log(id);
	var checkboxid = "#my_checkbox"+id;
	if($(checkboxid).is(':checked') == true) {
		console.log("true");
		var datastring = "action=update_payroll&instid=" + id + "&status=true";
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				//console.log(data);
				viewThisDate();
			},
			error: function(data) {
				console.log(data);
			}
		});
	}else{
		var datastring = "action=update_payroll&instid=" + id + "&status=false";
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				//console.log(data);
				viewThisDate();
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
}
function viewThisDate() {
	var first_date = $("#weeklyDatePicker").val();
	console.log(first_date);
	var datastring = "action=inst_pay&selweek=" + first_date;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			//console.log(data);
			$('#pjtResults').html('');
			$('#pjtResults').append(data);
		},
		error: function(data) {
			console.log(data);
		}
	});
	//     setTimeout(viewThisDate, 10000);
}
</script>
<style>
  .row {
    margin-right: -30px;
  }
  .bootstrap-datetimepicker-widget .datepicker-days table tbody tr:hover {
    background-color: #eee;
  }
  #title {
    text-align: right;
    margin-top: 5px;
  }
  .form-group {
    margin-bottom: 0px;
  }
  .t-sec, .date-sec {
    align-self: center;
  }
  #weeklyDatePicker {
    width: 100%;
  }
  input[type=checkbox] {
    position: inherit;
    width: 20px;
    visibility: visible;
  }
  
  *{box-sizing: border-box}
  /* ---- code ---- */
  .container{
      width: 100%;
/*       min-height: 100vh; */
      font-family: 'Raleway', sans-serif;
      margin-bottom: 35px;
  }

  .TableContainer{
/*       margin: 0 auto;
      width: 80%;
      min-width: 500px;
      overflow-x: auto;
      border: 0.5px solid grey;
      margin: 5px;
      max-width: 31.5%;*/
  }
  .TableHolder{
      margin: 0 auto;
      width: 95%;
/*
      text-align: left;
      cursor: default;
      border-spacing: 0;
      border-collapse: collapse;
*/
  }
  .TableHolder tr:first-child th{
      border-bottom: 1px solid #65CEC8;
      padding: 5px 0px;
      background-color: #ffffff44;
      font-size: 1em;
  }
  .TableHolder tr td, .TableHolder tr:not(:first-child) th{
      padding: 2px 2px;
      position: relative;
      font-weight: normal;
  }
  .TableHolder tr:not(:first-child) th{
      transition: all 1s ease-out;
  }

  .TableHolder tr td::after, .TableHolder tr:not(first-child) th::after{
      width: 0;
      height: 2px;
      background-color: #ffffff22;
      content: " ";
      position: absolute;
      bottom: 0;
      left: 0;
      transition: width 0.1s ease-out 0.2s, height 0.2s ease 0.4s;
  }

  .TDActiv::after{
      width: calc(100% - 20px) !important;
      height: 100% !important;
  }

</style>

