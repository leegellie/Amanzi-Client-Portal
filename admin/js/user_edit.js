$(document).on("keypress", ":input:not(textarea)", function(event) {
    if (event.keyCode == 13) {
		var target = $( event.target );
		if (target.is("#search")) {$("#searchSubmit").click()};
		if (target.is("#zip")) {$("#EditSubmit").click()};
        event.preventDefault();
		var inputs = $(this).closest('form').find(':input');
		inputs.eq( inputs.index(this)+ 1 ).focus();
    }
});
function editThisUser(i) {
	$('#edit_user_data')[0].reset();
	$uid = i;
	$.post("ajax.php",{action: "get_all_user_data",get_data: '1', get_billing: '1', selection: '*', uid: i},function(data) {
		$('.mdb-select').material_select('destroy');
		var res = data.split(",");
		var obj = {};
		for (var i = 0; i < res.length; i++) {
			var split = res[i].split('::');
			obj[split[0]] = split[1];
		}
		$uName = clientName;

		$('#id').val($uid);
		$('select[name="access_level"]').val(obj.access_level);
		var clientName = obj.company + ' ' + obj.fname + ' ' + obj.lname;
		$("#client_name").text(clientName);
		$("#discount").val(obj.discount);
		$("#discount_quartz").val(obj.discount_quartz);
		$("#username").val(obj.username);
		$("#email").val(obj.email);
		$("#fname").val(obj.fname);
		$("#lname").val(obj.lname);
		$("#company").val(obj.company);
		$("#phone").val(obj.phone);
		$("#address1").val(obj.address1);
		$("#address2").val(obj.address2);
		$("#city").val(obj.city);
		$('select[name="state"]').val(obj.state);
		$("#zip").val(obj.zip);
		if (obj.isActive == '1') {
			$("#uEditMod #e-isActive").prop('checked',true);
			$("#uEditMod #e-isActive").val(1);
		}
		if (obj.acct_rep > 0) {
			$('select[name="acct_rep"]').val(obj.acct_rep);
		} else {
			$('select[name="acct_rep"]').val('0');
		}

		// Set up Billing Edit Form
		$("#uid").val($uid);
		$("#billing_name").val(obj.billing_name);
		$("#billing_company").val(obj.billing_company);
		$("#billing_address1").val(obj.billing_address1);
		$("#billing_addresss2").val(obj.billing_addresss2);
		$("#billing_city").val(obj.billing_city);
		$('select[name="billing_state"]').val(obj.billing_state);
		$("#billing_zip").val(obj.billing_zip);
		$('.mdb-select').material_select();
	});
	window.scrollTo(0,0);
	$('#uEditMod').modal('show');
	$('#updateSuc').hide();
	$('#billingSuc').hide();
}

function changePW() {
	$('#uEditMod').modal('hide');
	$('#pw-uid').val($uid);
	$("#user_name").text($uName);
	$('#uPassEdit').modal('show');
}

function fadeSaver ($f) {
	$($f).fadeIn(300);
	setTimeout(function() { $($f).fadeOut(300); },2000);
}

$(document).ready(function() {
    $("#popupDIVclose").click(function() {
		$("#popupDIVwrapper").fadeOut(300);
		$('#searchSubmit').click();
	});
	$('input').change(function(){
		return $(this).val ($.trim( $(this).val() ) );
	});
	$("#user_type").validate({
    	expression: "if (VAL != '0') return true; else return false;",
        message: "&#x2718; Please select a user type"
	});
	$("#fname").validate({
		expression: "if (VAL.match(/^[a-zA-Z]+$/) && VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a first name"
	});
	$("#lname").validate({
		expression: "if (VAL.match(/^[a-zA-Z]+$/) && VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a valid last name"
	});
	$("#company").validate({
		expression: "if (VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a valid company name"
	});
//	$("#email").validate({
//		expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/) && VAL.indexOf('::') == -1) return true; else return false;",
//		message: "&#x2718; Please enter a valid Email address"
//	});
	$("#phone").validate({
		expression: "if (!isNaN(VAL) && VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a valid 10 digit phone number"
	});
	$("#address1").validate({
		expression: "if (VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter an Address"
	});
	$("#address2").validate({
		expression: "if (VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter an Address"
	});
	$("#city").validate({
		expression: "if (VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a valid City or Town"
	});
	$("#zip").validate({
		expression: "if (VAL.indexOf('::') == -1) return true; else return false;",
		message: "&#x2718; Please enter a valid Zip Code"
	});
	//$('.AdvancedEditForm').validated(function(e){


	$("#searchSubmit").click(function() {
		loadingAdd(this);

		if ($('#mine').prop('checked') == true) {
			$('#mine').val('1');
		} else {
			$('#mine').val(0);
		}

		var datastring = $("form#findToEdit").serialize();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				$("#tableResults").replaceWith('<div width="100%" id="tableResults" style="background:none">' + data + '</div>');
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			},
			complete: function() {
				loadingRemove();
			}
		});
	});

	$("#EditSubmit").click(function() {
		$('input').removeClass('is-invalid');
		loadingAdd(this);
		var $access_level = parseFloat($("#accs").text());
		if ($access_level > 1) {
			if ($('#discount').val() > 15) {
				alert("Only Sales Managers have access to set marble & graninte discounts above 15%");
				$('#discount').addClass('is-invalid');
				$('#discount').focus();
				loadingRemove();
				return
			}
			if ($('#discount_quartz').val() > 10) {
				alert("Only Sales Managers have access to set quartz discount above 10%");
				$('#discount_quartz').addClass('is-invalid');
				$('#discount_quartz').focus();
				loadingRemove();
				return
			}
		} else {
			if ($('#discount').val() > 35) {
				alert("35% is the maximum discount allowed on quartz");
				$('#discount').addClass('is-invalid');
				$('#discount').focus();
				loadingRemove();
				return
			}
			if ($('#discount_quartz').val() > 20) {
				alert("20% is the maximum discount allowed on quartz!");
				$('#discount_quartz').addClass('is-invalid');
				$('#discount_quartz').focus();
				loadingRemove();
				return
			}
		}

		var datastring = $("form#edit_user_data").serialize();
		//alert(datastring);
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if (data=='1') {
					// alert("User Info Updated.");
					//successNote = "User Info Updated."
					fadeSaver('#updateSuc');
					//document.getElementById('closeFocus').focus();
				} else {
					// alert(data);
					fadeSaver('#updateSuc');
					//$('#editSuccess').html(succesStarter+data+successEnder);
					//document.getElementById('closeFocus').focus();
				}
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				//successNote = "Error submitting form: "+xhr.responseText;
				//$('#editSuccess').html(succesStarter+successNote+successEnder);
				//document.getElementById('closeFocus').focus();
			},
			complete: function() {
				loadingRemove();
			}
		});
	});
	//$('.AdvancedBillingForm').validated(function(e){
	$("#BillingSubmit").click(function(e) {
		loadingAdd(this);
		$('#EditSubmit').click();
		var datastring = $("form#user_billing").serialize();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if (data=='1') {
					// alert("User Billing Info Updated.");
					//successNote = "User Billing Info Updated."
					fadeSaver('#billingSuc');
					//$('#editSuccess').html(succesStarter+successNote+successEnder);
					//document.getElementById('closeFocus').focus();
				} else {
					// alert(data);
					$('#editSuccess').html(succesStarter+data+successEnder);
					document.getElementById('closeFocus').focus();
				}
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			},
			complete: function() {
				loadingRemove();
			}
		});
	});
	$("#pwSubmit").click(function() {
		loadingAdd(this);
		var datastring = $("form#changePassword").serialize();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if (data=='1') {
					// alert("User Info Updated.");
					//successNote = "User Info Updated."
					fadeSaver('#pwSuccess');

					//document.getElementById('closeFocus').focus();
				} else {
					// alert(data);
					fadeSaver('#pwFail');
					//$('#editSuccess').html(succesStarter+data+successEnder);
					//document.getElementById('closeFocus').focus();
				}
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				//successNote = "Error submitting form: "+xhr.responseText;
				//$('#editSuccess').html(succesStarter+successNote+successEnder);
				//document.getElementById('closeFocus').focus();
			},
			complete: function() {
				loadingRemove();
			}
		});
	});
});