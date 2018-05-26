// For both User Add and User Edit Pages
$pid = '';
$uName = '';
var successNote;

var succesStarter = '<div class="metro window-overlay"><div class="window shadow" style="min-width:200px; max-width:450px; top:200px; left:50%; margin-left:-225px;" ><div class="caption"><span class="icon icon-user-3"></span><div class="title">User Save Data</div><button class="btn-close" onClick="closeSuccess()"></button></div><div class="content">';

var successEnder = '</div><div id="closeFocus" class="button bg-yellow fg-white bd-red" style="width:75px; bottom:5px; margin-left:345px; margin-bottom:10px" tabindex="0" onclick="closeSuccess()">Close &#10008;</div></div>';



$(document).ready(function(){

	$("#materialBtn").click(function() {
		var datastring = "action=get_staff_list";

		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				$('#rtoResults').html(data);
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	});

})