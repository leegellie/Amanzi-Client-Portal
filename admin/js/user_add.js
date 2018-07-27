// Hide Billing Section until external user added
$(document).ready(function(){
	//document.getElementById('user-billing').className = 'hide';
	if (!$('#user-billing').hasClass('hide')) {
		$('#user-billing').addClass('hide');
	}
});
// a) Validate form
// b) Enter User Data to DB
// c) Open Billing Form
// d) Enter Billing Data to DB
$(document).ready(function(){


	$('.AdvancedForm').validated( function() {
		$('input').removeClass('is-invalid');

		var $access_level = parseFloat($("#accs1").text());
		if ($access_level > 1) {
			if ($('#discount').val() > 15) {
				alert("Only Sales Managers have access to set marble & graninte discounts above 15%");
				$('#discount').addClass('is-invalid');
				$('#discount').focus();
				return
			}
			if ($('#discount_quartz').val() > 10) {
				alert("Only Sales Managers have access to set quartz discount above 10%");
				$('#discount_quartz').addClass('is-invalid');
				$('#discount_quartz').focus();
				return
			}
		} else {
			if ($('#discount').val() > 35) {
				alert("35% is the maximum discount allowed on quartz");
				$('#discount').addClass('is-invalid');
				$('#discount').focus();
				return
			}
			if ($('#discount_quartz').val() > 20) {
				alert("20% is the maximum discount allowed on quartz!");
				$('#discount_quartz').addClass('is-invalid');
				$('#discount_quartz').focus();
				return
			}
		}

		var phoneNum = $('#phone').val().replace(/\D/g,'');
		$('#phone').val(phoneNum);
		if (!$('#username').val()) {
			var val = Math.floor(Math.random() * 1000000000);
			$('#username').val(val)
		}
		var datastring = $("form#user_data").serialize();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			dataType: "json",
			success: function(data) {
				$uid = data;
				$("#uid").val(data);
				if ((isNaN(data)) || (data=='0') || (data=='')) {
					//RETURNED DATA IS NOT A NUMBER AND THUS AN ERROR. ALERT THE ERROR
					// alert("Error: " + data);
					successNote = "Error: "+data;
					$('#editSuccess').html(succesStarter+successNote+successEnder);
					document.getElementById('closeFocus').focus();
				} else {
					//RETURNED DATA IS A NUMBER AND THUS THE NEW USER'S ID. 
					//ADD YOUR HIDE / SHOW JAVASCRIPT HERE 
					if ($("#user_type").val() > 10) {
						$('#user_data').slideUp(300);
						$('#user_billing1').slideDown(300);
						window.scrollTo(0, 0);
					} else {
						$form = $('#user_data');
						$form.find('input:text, select').val('');
						$("#usernameError").empty();
						// alert('User Added');
						successNote = "User Added.";
						$('#editSuccess').html(succesStarter+successNote+successEnder);
						document.getElementById('closeFocus').focus();
					}
				}
			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				// document.getElementById('closeFocus').focus();
			}
		});
		event.preventDefault();
	});


	$('form#user_billing1').submit(function(){
		var datastring = $("form#user_billing1").serialize();
		//alert(datastring);
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if (data=='1') {
					// alert("User Billing Info Added.");
					//alert('User Billing Added');
					window.location.href = '/admin/projects.php?timeline';
				} else {
					// alert(data);
					$('#editSuccess').html(succesStarter+data+successEnder);
					document.getElementById('closeFocus').focus();
				}
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: ";
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	});
});