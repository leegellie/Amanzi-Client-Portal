

function newUserAdd() {
	var datastring = "action=get_new_user_name&id=" + $uid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$uName = data;
			selectUserNew();
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	
}

function addClient() {
	$('#selectCompany').modal('hide');
	$('#addClient').modal('show');
}


function detailChange() {
	var toControl = "." + $(this).attr('data-control');
	if (this.checked) {
		$(toControl).removeClass('hidden');
		$(this).parent().find('i').removeClass('fa-circle-o').addClass('fa-check');
	} else {
		$(this).parent().parent(toControl).find().fadeOut(300);
		$(this).parent().find('i').removeClass('fa-check').addClass('fa-circle-o');
	}
}

function holeChange() {
	var otherHole = $(this).find('.controller');
	var otherQuery = '#' + otherHole.val() + ":selected";
	$( ".holeOpt option:selected" ).each(function() {
		var curHole = $(this).val();
		if (curHole == 'other') {
			$(this).closest('fieldset').next().fadeIn(300);
			//console.log('show');
		} else {
			$(this).closest('fieldset').next().fadeOut(300);
			//console.log('hide');
		}
	});
};

function closeSearch(){
	$("#searchWrapper").fadeOut(300);
};


function selectThisUser(uid,name) {
	$("#user_info").val(name);
	$uid = uid;
	$("input[name=uid]").val(uid);
	$("#co_display_name").val(name);
	$('#selectCompany').modal('hide');

	var datastring = "action=get_price_multiplier&uid=" + $uid;

		$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$uMultiplier = data;
		},
		error: function(xhr, status, error) {
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	})

	setTimeout(function() {
		$('#submitForm').click();
	}, 3000);
	//closeSearch();
}

function selectUserNew() {
	$("#user_info").val($uName);
	$("input[name=uid]").val($uid);
	$('#selectCompany').modal('hide');
}





function addInstall() {
	var num = $('.clonedSection').length;
	var newNum  = new Number(num + 0);
	var newSection = $('#menuItemBlocks').children().clone();
	$('#installBlocks').append(newSection);
}

function addInstallSuccess() {
	$('input[name=pjtID]').val($('input[name=hiddenPID]').val());
	var datastring = $('form#instFindForm').serialize();
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$("#liveInstalls").replaceWith('<div id="liveInstalls" class="col-12"><h2>Current Installs</h2>' + data + '<hr></div>');
		},
		error: function(xhr, status, error) {
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	})


	$("body").scrollTop(0);
	$('installBlocks').empty();
	$('#loadOver').fadeOut(500);
	$('form#add_step2')[0].reset();
	//$('#installBlocks').html('');
	//addInstall();
	$('#uploadInstall').html('');
	$('#installBlocks').hide();
	$('#step2btn').hide();
	$('#uploadInstall').hide();
	$('#andMore').html('<div onClick="expandIt()" class="btn btn-primary btn-lg"><i class="fa fa-lg fa-plus"></i></div>');
	addInstUpload();
}

function expandIt() {
	$('#installBlocks').slideDown();
	$('#step2btn').show();
	$('#uploadInstall').show();
	$('#andMore').html('');	
}


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////                                   /////////////////////////
///////////////////////         DOCUMENT READY            /////////////////////////
///////////////////////                                   /////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


$(document).ready(function() {

	$(document).on("keypress", ":input:not(textarea)", function(event) {
		if (event.keyCode == 13) {
			var target = $( event.target );
			if (target.is("#search")) {$("#submitForm").click()};
			if (target.is("#zip")) {$("#EditSubmit").click()};
			event.preventDefault();
			var inputs = $(this).closest('form').find(':input');
			inputs.eq( inputs.index(this)+ 1 ).focus();
		}
	});


	$('input').change(function(){
		if ($(this).attr('type') != 'file'){
			return $(this).val ($.trim( $(this).val() ) );
		}
	});
	
	$("#step3btn").click(function() {
		if ($("div.savePageData:visible").length === 0) {
			var pid = $('input[name=hiddenPID]').val();
			$.post("ajax.php",{action: "get_floorplan_id", pid: pid},function(data) {
				var fpList = data.split(',');
				for (var i=0;i<fpList.length;i++) {
					var fpDetails = fpList[i].split('::');
					var fpID = fpDetails[0];
					var fpTitle = fpDetails[1];
					var fpNum = i + 1;
					var newSection = $('#floorPEach').children().clone();
					newSection.prepend('<a href="#" id="fp' + fpNum + '" class="heading collapsed bg-amber"><h2 class="fg-white">Configure <b>' + fpTitle + '</b> Floorplan:</h2></a>');
					saveFPBut = '<input type="hidden" name="fpid" value="' + fpID + '" /><div style="height:35px" id="holder" style="float:right; display:inline; vertical-align:middle;"><div id="saveFPData' + fpNum + '" onClick="makeFpFloors(' + fpID + ')" class="saveFPData button bg-yellow " style="float:right; display:inline-block"><h4 class="fg-white" style="font-weight:300;line-height:0.3">Go</h4></div></div>';
					$('#fpEditors').last().append(newSection); 
					newSection.children(':nth-child(2)').children(':first').append(saveFPBut);
					newSection.children(':nth-child(2)').children(':first').attr('id',fpID);
					newSection.children(':nth-child(2)').children(':first').attr('name',fpID);
				};
				$('#fp1').click();
			});
			$("#step3container").fadeOut(300);
			$("body").scrollTop(300);
			$("#step4container").fadeIn(300);
			//$('#addProjectStepper').stepper('next');
			return false;
		} else {
			alert("You must save all sections in Step 3 before continuing!");
		}
	});



	$('#step2btn').click(function(e) {
		$('#loadOver').fadeIn(500);
		e.preventDefault();
		if ($('#SqFt').val() == "" || $('#SqFt').val() < 1) {
			$('#SqFt').val(0)
		}
		var cpSqFt = 0;
		var $discounta = 100 - $('#pct').text();
		if ($discounta != 100) {
			var $discountb = '0.' + $discounta;
			var $discountc = $discountb * 1;
			cpSqFt = Math.ceil($price * $discountc);
			$('input[name=cpSqFt]').val(cpSqFt);
			console.log('Discount cP SqFt = ' + cpSqFt);
		} else {
			cpSqFt = Math.ceil($price);
			$('input[name=cpSqFt]').val(cpSqFt);
		}
		var $calc_price = (cpSqFt * SqFt);
		console.log($calc_price);
		$('input[name=price_calc]').val($calc_price);

		var form = $('form#add_step2')
    	var formdata = false;
    	if (window.FormData){
   			formdata = new FormData(form[0]);
    	};

		var datastring = formdata ? formdata : form.serialize();

   		$.ajax({
        	url         : 'ajax.php',
        	data        : formdata,
        	cache       : false,
       	 	contentType : false,
        	processData : false,
        	type        : 'POST',
        	success     : function(data){
				if (isNaN(data)) {
					alert(data);
				} else {
					addInstallSuccess();
				}
				return false;
        	}
    	});
		e.preventDefault();
		$('#loadOver').fadeOut(500);
	});

   
    $('#btnDel').click(function() {
        var num = $('.clonedSection').length; // how many "duplicatable" input fields we currently have
		var toDel = num - 1;
		if (num > 2) {
			$('#installBlocks').children(':last').remove();     // remove the last element
			if (num<4){$('#btnDel').hide();}
		}
        // enable the "add" button
        $('#btnAdd').show();
        
        // if only one element remains, disable the "remove" button
        if (num-1 == 1) {
            $('#btnDel').hide();
		}
    });
    $('#btnDel').hide();

	$("#add_pjt_btn").click(function(e) {
		console.log('started');
		$('input').removeClass('is-invalid');
		$('textarea').removeClass('is-invalid');
		$('#loadOver').fadeIn(500);
		e.preventDefault();
		var $type = 0;
		if ($('#addition').val() == 1) {
			$type = 1;
			if ($('#no_charge').prop('checked') == false) {
				$('#responsible option:selected').val(0);
				$('#reason').val('');
			}
		} else if ($('#repair').val() == 1) {
			$type = 2;
		} else if ($('#rework').val() == 1) {
			$type = 3;
		} else {
			$('#responsible option:selected').val(0);
			if ($('#no_charge').prop('checked') == false) {
				$('#responsible option:selected').val(0);
				$('#reason').val('');
			}
		}
		if ($('#pick_up').prop('checked') == true) {
			$('#install_team').val(22);
		}
		if ($('#install_team').val() == 0) {
			if ($type == 2) {
				$('#install_team').val(12);
			}
		}
		if ($('#no_charge').prop('checked') == true && $('#reason').val().length < 15) {
			alert("You must provide a detailed reason as to why there is no charge.");
			$('#loadOver').fadeOut(500);
			$('#reason').addClass('is-invalid');
			$('#reason').focus();
			return;
		}
		if ($type > 1 && ( $('#responsible option:selected').val() == 0 || $('#reason').val().length < 15) ) {
			alert("You must explain the reason for repairs with as much detail as possible and the area responsible and who is responsible.");
			$('#loadOver').fadeOut(500);
			$('#reason').addClass('is-invalid');
			$('#reason').focus();
			return;
		}
		if ($('input[name=uid]').val() < 1) {
			alert("No project owner selected.");
			$('#loadOver').fadeOut(500);
			return;
		}
		if ($('input[name=job_name]').val() == '') {
			$('input[name=job_name]').addClass('is-invalid');
			$('input[name=job_name]').focus();
			alert("You must have a Job Name.");
			$('#loadOver').fadeOut(500);
			return;
		}
		if ($('select[name=acct_rep]').val() < 1) {
			$('select[name=acct_rep]').addClass('is-invalid');
			$('select[name=acct_rep]').focus();
			alert("You must specify an Account Rep.");
			$('#loadOver').fadeOut(500);
			return;
		}
		if ($('input[name=contact_name]').val() == '') {
			$('input[name=contact_name]').addClass('is-invalid');
			$('input[name=contact_name]').focus();
			alert("You must have a Site Contact listed.");
			$('#loadOver').fadeOut(500);
			return;
		}
		if ($('input[name=contact_number]').val() == '') {
			$('input[name=contact_number]').addClass('is-invalid');
			$('input[name=contact_number]').focus();
			alert("Site Contact must have a phone number.");
			$('#loadOver').fadeOut(500);
			return;
		}
		if ($('input[name=install_date]').val() == '') {
			$('input[name=install_date]').val('2200-01-01');
		} else {
			var iDate = new Date($('input[name=install_date]').val());
			var iYear = iDate.getFullYear();
			var iMonth = ("0" + (iDate.getMonth() + 1)).slice(-2);
			var date = ("0" + iDate.getDate()).slice(-2);
			var dateString = iYear + '-' + iMonth + '-' + date;
			$('input[name=install_date]').val(dateString);
		}
		if ($('input[name=template_date]').val() == '') {
			$('input[name=template_date]').val('2200-01-01');
		} else {
			var tDate = new Date($('input[name=template_date]').val());
			var tYear = tDate.getFullYear();
			var tMonth = ("0" + (tDate.getMonth() + 1)).slice(-2);
			var date = ("0" + tDate.getDate()).slice(-2);
			var dateString = tYear + '-' + tMonth + '-' + date;
			$('input[name=template_date]').val(dateString);
		}

		$breakFunction = 0;
		if($('input[name=repair]').val() == 1) {
			var install_date = $('input[name=install_date]').val()
			check_repairs(toCheck,install_date,0);
		}
		if ($('#am').prop('checked') == true) {
			var toCheck = 'am';
			var install_date = $('input[name=install_date]').val()
			check_firsts(toCheck,install_date,0);
		}
		if($('#pm').prop('checked') == true) {
			var toCheck = 'pm';
			var install_date = $('input[name=install_date]').val()
			check_firsts(toCheck,install_date,0);
		}
		if($('#temp_am').prop('checked') == true) {
			var toCheck = 'temp_am';
			var install_date = $('input[name=template_date]').val()
			check_firsts(toCheck,install_date,0);
		}
		if($('#temp_pm').prop('checked') == true) {
			var toCheck = 'temp_pm';
			var install_date = $('input[name=template_date]').val()
			check_firsts(toCheck,install_date,0);
		}
		if ($breakFunction == 1) {
			$("#pjtUpdate").fadeIn(300);
			return;
		}

		if ($('input[name=po_cost]').val() != '') {
			var cost = $('input[name=po_cost]').val();
			var newCost = Number(cost.replace(/[^0-9\.-]+/g, ""));
			newCost = Math.round(newCost * 100) / 100;
			newCost = parseFloat(newCost).toFixed(2);
			$('input[name=po_cost]').val(newCost);
		}
		var form = $("form#add_project");
		var formdata = false;
		if (window.FormData) {
			formdata = new FormData(form[0]);
		}
		var datastring = formdata ? formdata : form.serialize();
		var formAction = form.attr('action');
		$.ajax({
			url: 'ajax.php',
			data: datastring,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data) {
				if (isNaN(data)) {
					alert(data);
				} else {
					$pid = data;
					$uid = $("#uid").val();
					var $link = '/admin/projects.php?edit&pid=' + $pid + '&uid=' + $uid;
					window.location.replace($link);
				}
				return false;
			}
		});
		$("body").scrollTop(0);
		$('#loadOver').fadeOut(500);
		addInstUpload();
		$('#anyaBtn').show();
	});

	$("#backTo1").click(function() { 
		$("#step2container").fadeOut(300); 
		$("body").scrollTop(300); 
		$("#step1container").fadeIn(300); 
		//$('#addProjectStepper').stepper('prior'); 
		return false; 
	}); 

	$("#submitForm").click(function(e) { 
		e.preventDefault(); 
		if ($('#mine').prop('checked') == true) { 
			$('#mine').val('1'); 
		} else {
			$('#mine').val(0);
		}
		var datastring = $("form#findToAdd").serialize();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				$("#tableResults").replaceWith('<div width="100%" id="tableResults" style="background:none">' + data + '</div>');
				$('#loading').remove();
			},
			error: function(xhr, status, error) {
				alert("Error submitting form: " + xhr.responseText);
			}
		});
		e.preventDefault();
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
	$('.AdvancedForm').validated( function() {
		event.preventDefault();
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
						$('#user_billing').slideDown(300);
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

	$('#user_billing').submit(function(e){
		e.preventDefault();
		$('#uid').val($uid);
		//alert($('#uid').val());
		var datastring = $("form#user_billing").serialize();
		//alert(datastring);
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				if (data=='1') {
					// alert("User Billing Info Added.");
					alert('User Billing Added');
					$('#user_data').show();
					$('#user_billing').hide();
					$('#addClient').modal('hide');
					newUserAdd();
					//window.location.href = 'dashboard.php';
				} else {
					// alert(data);
					//alert('User Billing Added');
					$('#user_data').show();
					$('#user_billing').hide();
					$('#addClient').modal('hide');
					newUserAdd();
					//$('#editSuccess').html(succesStarter+data+successEnder);
					//document.getElementById('closeFocus').focus();
				}
			},
			error: function(xhr, status, error) {
				alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: ";
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	});


});