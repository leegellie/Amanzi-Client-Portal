
//function getSalesReps($rep) {
//	var datastring = "action=find_sales_reps&isSales=1&selectedRep=" + $rep;
//	$.ajax({
//		type: "POST",
//		url: "ajax.php",
//		data: datastring,
//		success: function(data) {
//			$("#acct_rep").append(data);
//		},
//		error: function(xhr, status, error) {
//			// alert("Error submitting form: " + xhr.responseText);
//			successNote = "Error submitting form: "+xhr.responseText;
//			$('#editSuccess').html(succesStarter+successNote+successEnder);
//			document.getElementById('closeFocus').focus();
//		}
//	});
//}

function newInstall() {
	$('#uploadInstall').empty();
	$('#addInstall').modal('show');
	addInstUpload();
}

function newInstallSuccess() {
	$('#addInstall').modal('hide');
	viewThisProject($pid,$uid);
	$("body").scrollTop(0,0);
	$('form#add_new_step2')[0].reset();
	$('#instDetails').html('');
	$('#addInstNew').show();

//	addInstUpload();
}

function addUpload($this) {
	var newSection = '<input class="col-6 mb-2" onChange="addUpload(this);" name="imgUploads[]" type="file">';
	var uploadSection = $('#uploadContain');
	$($this).parent().append(newSection);
}



function viewThisInstall($a,$b,$c) {
	$iid = $a;
	var datastring = "action=view_selected_inst&userID=" + $b + "&pjtID=" + $c + "&instID=" + $a;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$("#instDetails").html('');
			$("#instDetails").append(data);
			$iName = $('#installName').text();
			$("html, body").animate({ scrollTop: $('#instDetails').offset().top - 60 }, 300);
			new Clipboard('.btnCopy');
		},
		error: function(data) {
			alert(data);
		}
	});
	//setTimeout(function(){ getInstParticulars(); }, 500);
}

function viewThisProject($a,$b) {
	$pid = $a;
	$uid = $b;
	var $repID = '';
	var datastring = "action=view_selected_pjt&userID=" + $b + "&pjtID=" + $a;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('.mdb-select').material_select('destroy');
			$("#pjtDetails").replaceWith('<div class="col-12" id="pjtDetails">' + data + '</div>');
			$('.mdb-select').material_select();
			$pName = $('#projectName').text();
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	$('#materials-block').hide();
	$('#user-block').hide();
	$('#pjt-block').hide();
	//setTimeout(function(){ getComments('pjt'); getSqFt()}, 500);
	//setTimeout(function(){ getSqFt()}, 500);
	get_price_mult();
	//setTimeout(function(){ getStatuses(); }, 300);
	//setTimeout(function(){ statusSet(); }, 300);
}

function getStatuses() {
    var statusdata = 'action=get_status_list';
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: statusdata,
        success: function(data) {
			$('.mdb-select').material_select('destroy');
            var $status = data.split(':');
            for (var i = 0; i < $status.length; i++) {
                var $parts = $status[i].split('|');
                var $combine = '<option value="';
                $combine += $parts[0];
                $combine += '">';
                $combine += $parts[1];
                $combine += '</option>';
                $('#changeStatus').append($combine);
            }
			$('.mdb-select').material_select();
        },
        error: function(xhr, status, error) {
            // alert("Error submitting form: " + xhr.responseText);
            successNote = "Error submitting form: " + xhr.responseText;
            $('#editSuccess').html(succesStarter + successNote + successEnder);
            document.getElementById('closeFocus').focus();
        }
    });
}

function statusSet(){
	$('#progressStatus').html('');
	var statusdata = "action=get_job_status&pid=" + $pid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: statusdata,
		success: function(data) {
			var $status = data.split('|');
			var statusBar = '<div class="progress w-100"><div class="progress-bar progress-bar-striped progress-bar-animated ';
			var no = $status[0];
			var lastDigit = no%10;
			statusBar += lastDigit;
			if (lastDigit == 9) {
				statusBar += 'bg-danger';
			}

			statusBar += '" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: ';
			statusBar += $status[0];
			statusBar += '%">';
			statusBar += $status[1];
			statusBar += '</div></div>'
			$('#progressStatus').html(statusBar);
			var selOption = '#changeStatus option[value='+ $status[0] +']';
			$(selOption).attr('selected', 'selected');
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}

function statusUpdate($statId) {
	$statName = $('#changeStatus option:selected').text();
	$percent = $statId + '%';
	var lastDigit = $statId%10;
	if (lastDigit == 9) {
		$('#progressStatus .progress-bar').addClass('bg-danger');
	} else {
		$('#progressStatus .progress-bar').removeClass('bg-danger');
	}
	$('#pjtDetails #progressStatus .progress-bar').width($percent);
	$('#pjtDetails #progressStatus .progress-bar').text($statName);

	var statusdata = 'action=update_job_status&pid=' + $pid + '&status=' + $statId;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: statusdata,
		success: function(data) {
			setTimeout(function(){ statusSet(); }, 300);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
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

function getSqFt() {
	var datastring = 'action=get_sqft&pid=' + $pid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			var $SqFtText = ' <span class="font-italic"><sup>(' + data + ' SqFt)</sup></span>';
			$('#clientName').append($SqFtText);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});

}

//function getInstParticulars() {
//	var dataEdge = "action=find_inst_parts&getEdge=" + parseInt($('#edgeGet').text());
//	var dataHoles = "action=find_inst_parts&getHoles=" + parseInt($('#holesGet').text());
//	var dataRange = "action=find_inst_parts&getRange=" + parseInt($('#rangeGet').text());
//	$.ajax({
//		type: "POST",
//		url: "ajax.php",
//		data: dataEdge,
//		success: function(data) {
//			$("#edgeGet").text(data);
//		},
//		error: function(xhr, status, error) {
//			// alert("Error submitting form: " + xhr.responseText);
//			successNote = "Error submitting form: "+xhr.responseText;
//			$('#editSuccess').html(succesStarter+successNote+successEnder);
//			document.getElementById('closeFocus').focus();
//		}
//	});
//	$.ajax({
//		type: "POST",
//		url: "ajax.php",
//		data: dataHoles,
//		success: function(data) {
//			$("#holesGet").text(data);
//		},
//		error: function(xhr, status, error) {
//			// alert("Error submitting form: " + xhr.responseText);
//			successNote = "Error submitting form: "+xhr.responseText;
//			$('#editSuccess').html(succesStarter+successNote+successEnder);
//			document.getElementById('closeFocus').focus();
//		}
//	});
//	$.ajax({
//		type: "POST",
//		url: "ajax.php",
//		data: dataRange,
//		success: function(data) {
//			$("#rangeGet").text(data);
//		},
//		error: function(xhr, status, error) {
//			// alert("Error submitting form: " + xhr.responseText);
//			successNote = "Error submitting form: "+xhr.responseText;
//			$('#editSuccess').html(succesStarter+successNote+successEnder);
//			document.getElementById('closeFocus').focus();
//		}
//	});
//}

function projectsForUser($a) {
	console.log($a);
	$uid = $a;
	var datastring = "action=find_user_pjts&userID=" + $a;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$("#pjtResults").replaceWith('<div class="col-12" id="pjtResults">' + data + '</div>');
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	$('#user-block').hide();
}


function addInstall() {
    $('#instUID').val($uid);
    $('#pid').val($pid);
//    if ($('#SqFt').val() == "") {
//        $('#SqFt').val(0)
//    }


	var $matName = $('#color-box').val();
	var $matString = ".titleMat:contains('" +  $matName + "')";
	var $price = $($matString).parent().parent().attr('price');
//	if (!(Math.floor($price) == $price && $.isNumeric($price)))  {
//		alert("You have entered a color that is not in the database. If it is a Remnant, you must enter the proper name for a marble or granite. If it is quartz, you will have to have the remnant added to the quartz database by Corry, Kate, Lee, Omar, Kayleigh, Anna or Zack.");
//		return;
//	}
	if (!(Math.floor($price) == $price && $.isNumeric($price)))  {
		if (window.confirm("You have entered a color that is not in the database. You will have to manually enter the price in 'Extra Costs' field. Are you sure you want to do this?")) {
			$price = 0;
		} else {
			return;
		}
	}

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


    var form = $('form#add_new_step2')
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    };
    var datastring = formdata ? formdata : form.serialize();
	console.log(datastring);
    $.ajax({
        url: 'ajax.php',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data) {
            if (isNaN(data)) {
                alert(data);
				$('#addInstNew').show();
            } else {
                newInstallSuccess();
            }
            return false;
        }
    });
}


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////                                   /////////////////////////
///////////////////////         DOCUMENT READY            /////////////////////////
///////////////////////                                   /////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////




$(document).ready(function() {

	$('#addInstNew').click(function(e) {
		$('fieldset').removeClass('form-error');
		$('input').removeClass('is-invalid');
		$('select').removeClass('is-invalid');

	    $('#addInstNew').hide();

		if ( $('#install_name').val() == '' ) {
			alert('You must have an Install/Area Name.');
			$('#install_name').addClass('is-invalid');
			$('#install_name').focus();
			$('#addInstNew').show();
			return;
		}
		if ( $('#typea').is(':checked') == false && $('#typeb').is(':checked') == false ) {
			alert('You must specify if this is a "New Install" or a "Remodel" in the Job Type.');
			$('#typea').closest('fieldset').addClass('form-error');
			$('#typea').focus();
			$('#addInstNew').show();
			return;
		}

		if ( $('#tear_outa').is(':checked') == false && $('#tear_outb').is(':checked') == false ) {
			alert('You must specify if this is a Tear Out or not.');
			$('#tear_outa').closest('fieldset').addClass('form-error');
			$('#tear_outa').focus();
			$('#addInstNew').show();
			return;
		}

		if ( $('#selecteda').is(':checked') == false && $('#selectedb').is(':checked') == false ) {
			alert('You must specify whether the the material is Customer Selected or not.');
			$('#selecteda').closest('fieldset').addClass('form-error');
			$('#selecteda').focus();
			$('#addInstNew').show();
			return;
		}lot

		if ( $('#selectedb').is(':checked') == true ) {
			addInstall();
		} else {
			if ($('#lot').val() != '') {
				addInstall()
			} else {
				alert("If Customer Selected you must enter a lot.");
				$('input[name=lot]').addClass('is-invalid');
				$('#lot').focus();
				$('#addInstNew').show();
				return;
			}
		}

	});


	$("#findPjtUser").submit(function(e) {
		e.preventDefault();
		var datastring = $("form#findPjtUser").serialize();
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
			}
		});
		e.preventDefault();
	});

	$('#resultsTableFPU').DataTable({"order": [[ 3, "desc" ]]});

	$("#pjtUpdate").click(function(e) {
		e.preventDefault();
		$("#pjtUpdate").fadeOut(300);
		if ($('input[name=install_date]').val() == '') {
			$('input[name=install_date]').val('2200-01-01');
		} else if ($('input[name=install_date]').val().match("^2018")) {
			
		} else {
			var iDate = new Date($('input[name=install_date]').val());
			var year = iDate.getFullYear();
			var month= ("0" + (iDate.getMonth()+1)).slice(-2);
			var date = ("0" + iDate.getDate()).slice(-2);
			var dateString = year + '-' + month + '-' + date;
			$('input[name=install_date]').val(dateString);
		}
		if ($('input[name=template_date]').val() == '') {
			$('input[name=template_date]').val('2200-01-01');
		} else if ($('input[name=template_date]').val().match("^2018")) {
			
		} else {
			var tDate = new Date($('input[name=template_date]').val());
			var year = tDate.getFullYear();
			var month= ("0" + (tDate.getMonth()+1)).slice(-2);
			var date = ("0" + tDate.getDate()).slice(-2);
			var dateString = year + '-' + month + '-' + date;
			$('input[name=template_date]').val(dateString);
		}
		if ($('input[name=po_cost]').val() != '') {
			var cost = $('input[name=po_cost]').val();
			var newCost = Number(cost.replace(/[^0-9\.-]+/g,""));
			newCost = Math.round(newCost*100)/100;
			newCost = parseFloat(newCost).toFixed(2); 
			$('input[name=po_cost]').val(newCost);
		}
		var form = $("form#editPjtOne");
    	var formdata = false;
    	if (window.FormData){
   			formdata = new FormData(form[0]);
    	}
		var datastring = formdata ? formdata : form.serialize();

    	var formAction = form.attr('action');
   		$.ajax({
        	url         : 'ajax.php',
        	data        : datastring,
        	//data        : formdata ? formdata : form.serialize(),
        	cache       : false,
       	 	contentType : false,
        	processData : false,
        	type        : 'POST',
        	success     : function(data){
				console.log('Success Lee')
				if (isNaN(data)) {
					alert(data);
					$("#pjtUpdate").fadeIn(300);
				} else {
					$('#editPjt').modal('hide');
					//alert(form.serialize() + " ----- Project ID -----> " + data);
					Command: toastr["success"]("Install data saved!", "Projects")
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
					}
//					$('input[type=file]').remove();
//					$('#p-uploadContain').append('<input class="col-lg-3 cloneUpload" onChange="addUpload();" name="imgUploads[]" type="file">');
					$("form#editPjtOne").get(0).reset();
					viewThisProject($pid,$uid);
					$("#pjtUpdate").fadeIn(300);
					//$('#addProjectStepper').stepper('next');
				}
				return false;
        	}
    	});
		$("body").scrollTop(0,0);
	});




});
