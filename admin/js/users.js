// For both User Add and User Edit Pages
$uid = '';
$uName = '';
var successNote;

var succesStarter = '<div class="metro window-overlay"><div class="window shadow" style="min-width:200px; max-width:450px; top:200px; left:50%; margin-left:-225px;" ><div class="caption"><span class="icon icon-user-3"></span><div class="title">User Save Data</div><button class="btn-close" onClick="closeSuccess()"></button></div><div class="content">';

var successEnder = '</div><div id="closeFocus" class="button bg-yellow fg-white bd-red" style="width:75px; bottom:5px; margin-left:345px; margin-bottom:10px" tabindex="0" onclick="closeSuccess()">Close &#10008;</div></div>';

function loadingAdd(button){
	//alert('Loading...');
	var e = '#' + button;
	$(button).append('<i id="loading" class="fa fa-spinner fa-spin"></i>');
}

function loadingRemove(){
	$("#loading").remove();
}


function autoFillBilling() {
	$('.mdb-select').material_select('destroy');
	if (document.getElementById('sameAdd').checked == true){
		$("input#billing_name").val($("#fname").val() + ' ' + $("#lname").val());
		$("input#billing_company").val($("#company").val()); 
		$("input#billing_address1").val($("#address1").val()); 
		$("input#billing_address2").val($("#address2").val()); 
		$("input#billing_city").val($("#city").val()); 
		$("select#billing_state").val($("#state").val()); 
		$("input#billing_zip").val($("#zip").val()); 
	} else {
		$("input#billing_name").val(''); 
		$("input#billing_company").val(''); 
		$("input#billing_address1").val(''); 
		$("input#billing_address2").val(''); 
		$("input#billing_city").val(''); 
		$("select#billing_state").val(''); 
		$("input#billing_zip").val('');
	}
	$('.mdb-select').material_select();
};

function closeSuccess(){
	$('#editSuccess').html('');
};
function custAddPjt(element) {
	var locLink = 'projects.php?add&uid=' + $(element).attr('uid') + '&uName=' + $(element).attr('uNameC').replace('&','and') + ' ' + $(element).attr('uNameF').replace('&','and') + ' ' + $(element).attr('uNameL').replace('&','and');
	location.href = locLink;
}
function makeComment(e,cmt_user) {
	var datastring = 'action=comments_user_name&id=' + cmt_user;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('#commentor').text(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});

	var cmt_type = $(e).attr('cmt_type').toString();

	if (cmt_type == 'pjt') {
		$('#cmt_ref_id').val($pid);
		$('#cmt_name').text($pName);
	} else if (cmt_type == 'usr') {
		$('#cmt_ref_id').val($uid);
		$('#cmt_name').text($uName);
	} else if (cmt_type == 'ins') {
		$('#cmt_ref_id').val($iid);
		$('#cmt_name').text($iName);
	}

	$('#cmt_type').val(cmt_type);
	$('#cmt_user').val(cmt_user);

	$('#addComment').modal('show');

}

function getComments(ref) {
	$('#commentList').html('');
	var $ref = '';
	if (ref == 'usr') {
		$ref = $uid;
	} else if (ref == 'pjt') {
		$ref = $pid;
	} else if (ref == 'ins') {
		$ref = $iid;
	}
	var datastring = 'action=get_comments&cmt_ref_id=' + $ref + '&cmt_type=' + ref;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#commentList').append(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}

$('#closeFocus').bind('keydown', function(event) {
    if ( event.which > 0 ) {
		closeSuccess();
	}
});
$(document).ready(function(){

	$("#submitComments").click(function(e) {

		var form = $("form#commentForm");
    	var formdata = false;
    	if (window.FormData){
   			formdata = new FormData(form[0]);
    	}
		var datastring = formdata ? formdata : form.serialize();

   		$.ajax({
        	url         : 'ajax.php',
        	data        : datastring,
        	cache       : false,
       	 	contentType : false,
        	processData : false,
        	type        : 'POST',
        	success     : function(data){
				if (isNaN(data)) {
					alert(data);
				} else {
					$('#addComment').modal('hide');
					getComments('usr');
					$('#commentForm')[0].reset();
					//alert(form.serialize() + " ----- Project ID -----> " + data);
					alert('Comment Made!');
					//viewThisInstall($iid,$pid,$uid);
					//$('#addProjectStepper').stepper('next');
				}
				return false;
        	}
    	});
	});


	$('input').change(function(){
		return $(this).val ($.trim( $(this).val() ) );
	});
	$("#user_type").validate({
    	expression: "if (VAL != '0') return true; else return false;",
        message: "&#x2718; Please select a user type"
	});
//	$("#username").validate({
//		expression: "if (VAL.match(/^[a-zA-Z0-9]+$/) && VAL.length > 3 && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; User name must be AlphaNumeric, at least 4 charachters long"
//	});
//	$("#password").validate({
//		expression: "if (VAL.length > 5 && VAL && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Password must be AlphaNumeric or '_' and at least 6 characters"
//	});
	$("#v_password").validate({
		expression: "if (VAL == jQuery('#password').val()) return true; else return false;",
		message: "&#x2718; Confirm password field doesn't match the password field"
	});
	$("#pw2").validate({
		expression: "if (VAL == jQuery('#pw1').val()) return true; else return false;",
		message: "&#x2718; Confirm password field doesn't match the password field"
	});
//	$("#fname").validate({
//		expression: "if (VAL.match(/^[a-zA-Z]+$/) && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a first name"
//	});
//	$("#lname").validate({
//		expression: "if (VAL.match(/^[a-zA-Z]+$/) && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a valid last name"
//	});
//	$("#email").validate({
//		expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/) && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a valid Email address"
//	});
//	$("#phone").validate({
//		expression: "if (!isNaN(VAL) && VAL.length == 10 && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a valid 10 digit phone number"
//	});
//	$("#address1").validate({
//		expression: "if (VAL && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter an Address"
//	});
//	$("#city").validate({
//		expression: "if (VAL.match(/^[a-zA-Z\- ]+$/) && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a valid City or Town"
//	});
//	$("#state").validate({
//		expression: "if (VAL != '' && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please select a State"
//	});
//	$("#zip").validate({
//		expression: "if (!isNaN(VAL) && VAL.length == 5 && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter 5 digit zip code"
//	});
})