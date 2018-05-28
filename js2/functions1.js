jQuery(document).ready(function($){
	
	function formIn(id){
		var formId = '#' + id + '-form';
		console.log(formId);
		$('#select-form').fadeOut(500);
		$('.masthead').fadeOut(500);
		$('.mastfoot').fadeOut(500);
		setTimeout(function(){
			$(formId).fadeIn(500);
		},600);
	}
	
	$('h2.start-form').click(function() {
		formIn(this.id);
	})

	$('.close-form').click(function() {
		var closeId = '#' + $(this).closest("section").prop("id");
		$(closeId).fadeOut(500);
		setTimeout(function(){
			$('#select-form').fadeIn(500);
			$('.masthead').fadeIn(500);
			$('.mastfoot').fadeIn(500);
		},600);
	})
	$('input[type="checkbox"]').change(function(){
		var toControl = "." + $(this).attr('data-control');
		if (this.checked) {
			$(toControl).fadeIn(300);
			$(this).parent().find('i').removeClass('fa-circle-o').addClass('fa-check');
			if ($(this).attr('class').indexOf('sink') > -1) {
				$(this).parent().parent().parent().parent().parent().parent().removeClass('sb1').addClass('sb2');
			}
		} else {
			$(toControl).fadeOut(300);
			$(this).parent().find('i').removeClass('fa-check').addClass('fa-circle-o');
			if ($(this).attr('class').indexOf('sink') > -1) {
				$(this).parent().parent().parent().parent().parent().parent().removeClass('sb2').addClass('sb1');
			}
		}
	})

	$('.holeOpt').change(function () {
		var otherHole = $(this).find('.controller');
		var otherQuery = '#' + otherHole.val() + ":selected";
		$( ".holeOpt option:selected" ).each(function() {
			var curHole = $(this).val();
			if (curHole == 'other') {
				$(this).closest('fieldset').next().fadeIn(300);
				console.log('show');
			} else {
				$(this).closest('fieldset').next().fadeOut(300);
				console.log('hide');
			}
		});
    });


	$('.sect-btn').click(function() {
		if ($(this).hasClass('sect-add')){
			var toControl = "." + $(this).attr('data-control');
			console.log(toControl);
			$(toControl).fadeIn(300);
			$(this).find('span').text('Remove install ');
			$(this).find('i').removeClass('fa-plus').addClass('fa-minus');
			$(this).removeClass('sect-add').addClass('sect-remove');
		} else {
			console.log('Clicked.');
			var toControl = "." + $(this).attr('data-control');
			$(toControl).fadeOut(300);
			$(this).find('span').text('Add additional install ');
			$(this).find('i').removeClass('fa-minus').addClass('fa-plus');
			$(this).removeClass('sect-remove').addClass('sect-add');
		}
	})
	$('.reset-btn').click(function(){
        console.log($(this).closest('form').attr('id'));
		var toReset = '#' + $(this).closest('form').attr('id');
		$(toReset)[0].reset();
	});
});

function submitForm(fid){
	var formData = new FormData($(this)[0]);
	$.ajax({
		url : 'php/test.php',
		type: 'POST',
		data: formData,
		async: false,
		success: function (data) {
			alert(data)
		},
		cache: false,
		contentType: false,
		processData: false
	});
	
    return false;

}


function submitForm2(fid){
	var editForm = '#' + fid;
	var quotenum = $(editForm).find('#quote-num').val();
	var ordernum = $(editForm).find('#order-num').val();
	var installdate = $(editForm).find('#install-date').val();
	var templatedate = $(editForm).find('#template-date').val();
	var jobname = $(editForm).find('#job-name').val();
	var accountrep = $(editForm).find('#account-rep').find('option:selected').text();
	var customername = $(editForm).find('#customer-name').val();
	var buildername = $(editForm).find('#builder-name').val();
	var customerphone = $(editForm).find('#customer-phone').val();
	var customeremail = $(editForm).find('#customer-email').val();
	var pocost = $(editForm).find('#po-cost').val();
	var ponum = $(editForm).find('#po-num').val();
	var billingaddress = $(editForm).find('#billing-address').val();
	var contactname = $(editForm).find('#contact-name').val();
	var contactphone = $(editForm).find('#contact-phone').val();
	var contactname2 = $(editForm).find('#contact-name2').val();
	var contactphone2 = $(editForm).find('#contact-phone2').val();
	var siteaddress = $(editForm).find('#site-address').val();
	var install1name = $(editForm).find('#install1-name').val();
	var jobtype1 = $(editForm).find('input[name=job-type1]:checked').val();
	var tearout1 = $(editForm).find('input[name=tear-out1]:checked').val();
	var material1 = $(editForm).find('#material1').val();
	var color1 = $(editForm).find('#color1').val();
	var lot1 = $(editForm).find('#lot1').val();
	var selected1 = $(editForm).find('input[name=selected1]:checked').val();
	var edge1 = $(editForm).find('#edge1').find('option:selected').text();
//	var edge1 = $(editForm).find('#edge1').val();
	var bsdetail1 = $(editForm).find('#bs-detail1').val();
	var rsdetail1 = $(editForm).find('#rs-detail1').val();
	var model1 = $(editForm).find('#model1').val();
	var cutout1 = $(editForm).find('#cutout1').val();
	var sinks1 = $(editForm).find('#sinks1').val();
	var range1 = $(editForm).find('#range1').find('option:selected').text();
	var spread1 = $(editForm).find('#spread1').find('option:selected').text();
	var holes1 = $(editForm).find('#holes1').val();
	var notes1 = $(editForm).find('#notes1').val();
	var install2name = $(editForm).find('#install2-name').val();
	var jobtype2 = $(editForm).find('input[name=job-type2]:checked').val();
	var tearout2 = $(editForm).find('input[name=tear-out2]:checked').val();
	var material2 = $(editForm).find('#material2').val();
	var color2 = $(editForm).find('#color2').val();
	var lot2 = $(editForm).find('#lot2').val();
	var selected2 = $(editForm).find('input[name=selected2]:checked').val();
	var edge2 = $(editForm).find('#edge2').find('option:selected').text();
	var bsdetail2 = $(editForm).find('#bs-detail2').val();
	var rsdetail2 = $(editForm).find('#rs-detail2').val();
	var model2 = $(editForm).find('#model2').val();
	var cutout2 = $(editForm).find('#cutout2').val();
	var sinks2 = $(editForm).find('#sinks2').val();
	var range2 = $(editForm).find('#range2').find('option:selected').text();
	var spread2 = $(editForm).find('#spread2').find('option:selected').text();
	var holes2 = $(editForm).find('#holes2').val();
	var notes2 = $(editForm).find('#notes2').val();
	var install3name = $(editForm).find('#install3-name').val();
	var jobtype3 = $(editForm).find('input[name=job-type3]:checked').val();
	var tearout3 = $(editForm).find('input[name=tear-out3]:checked').val();
	var material3 = $(editForm).find('#material3').val();
	var color3 = $(editForm).find('#color3').val();
	var lot3 = $(editForm).find('#lot3').val();
	var selected3 = $(editForm).find('input[name=selected3]:checked').val();
	var edge3 = $(editForm).find('#edge3').find('option:selected').text();;
	var bsdetail3 = $(editForm).find('#bs-detail3').val();
	var rsdetail3 = $(editForm).find('#rs-detail3').val();
	var model3 = $(editForm).find('#model3').val();
	var cutout3 = $(editForm).find('#cutout3').val();
	var sinks3 = $(editForm).find('#sinks3').val();
	var range3 = $(editForm).find('#range3').find('option:selected').text();
	var spread3 = $(editForm).find('#spread3').find('option:selected').text();
	var holes3 = $(editForm).find('#holes3').val();
	var notes3 = $(editForm).find('#notes3').val();
	var servicereport = $(editForm).find('#service-report').val();



	var headString1 = "";

	if (fid == 'form1') {
		headString1 = '<div style\="100%"><h1>New Customer Order</h1><h2>Customer Details</h2>';
	} else if (fid == 'form2') {
		headString1 = '<div style\="100%"><h1>Customer Change Order</h1><h2>Customer Details</h2>';
	} else if (fid == 'form3') {
		headString1 = '<div style\="100%"><h1>911 - Service Ticket</h1><h2>Customer Details</h2>';
	}
	

	var frmDetails1 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Quote Number: </b></div><div style\='width: 25%; display: inline-block'>" +quotenum + '</div></div>';
	var frmDetails2 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Order Number: </b></div><div style\='width: 25%; display: inline-block'>" +ordernum + '</div></div>';
	var frmDetails3 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Install Date: </b></div><div style\='width: 25%; display: inline-block'>" +installdate + '</div></div>';
	var frmDetails4 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Template Date: </b></div><div style\='width: 25%; display: inline-block'>" +templatedate + '</div></div>';
	var frmDetails5 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Job Name: </b></div><div style\='width: 25%; display: inline-block'>" +jobname + '</div></div>';
	var frmDetails6 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Account Rep: </b></div><div style\='width: 25%; display: inline-block'>" +accountrep + '</div></div>';
	var frmDetails7 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Customer Name: </b></div><div style\='width: 25%; display: inline-block'>" +customername + '</div></div>';
	var frmDetails8 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Builder Name: </b></div><div style\='width: 25%; display: inline-block'>" +buildername + '</div></div>';
	var frmDetails9 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Customer Email: </b></div><div style\='width: 25%; display: inline-block'>" +customeremail + '</div></div>';
	var frmDetails10 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>P.O. Cost: </b></div><div style\='width: 25%; display: inline-block'>" +pocost + '</div></div>';
	var frmDetails11 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>P.O.Number: </b></div><div style\='width: 25%; display: inline-block'>" +ponum + '</div></div>';
	var frmDetails12 = "<div style\='width: 90%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 10%; display: inline-block;'><b>Billing Address: </b></div><div style\='width: 90%; display: inline-block'>" +billingaddress + '</div></div></div>';

	var headString2 = '<div style\="100%"><h2>Site Details</h2>';

	var frmDetails13 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Contact Name: </b></div><div style\='width: 25%; display: inline-block'>" +contactname + '</div></div>';
	var frmDetails14 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Contact Phone: </b></div><div style\='width: 25%; display: inline-block'>" +contactphone + '</div></div>';
	var frmDetails15 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>2nd Contact Name: </b></div><div style\='width: 25%; display: inline-block'>" +contactname2 + '</div></div>';
	var frmDetails16 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>2nd Contact Phone: </b></div><div style\='width: 25%; display: inline-block'>" +contactphone2 + '</div></div>';
	var frmDetails17 = "<div style\='width: 90%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 10%; display: inline-block;'><b>Site Address: </b></div><div style\='width: 90%; display: inline-block'>" +siteaddress + '</div></div></div>';

	var headString3 = '<div style\="100%"><h2>Install 1 Details</h2>';

	var frmDetails18 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Install 1 Name: </b></div><div style\='width: 25%; display: inline-block'>" +install1name + '</div></div>';
	var frmDetails19 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Job Type: </b></div><div style\='width: 25%; display: inline-block'>" +jobtype1 + '</div></div>';
	var frmDetails20 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Tear Out: </b></div><div style\='width: 25%; display: inline-block'>" +tearout1 + '</div></div>';
	var frmDetails21 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Material: </b></div><div style\='width: 25%; display: inline-block'>" +material1 + '</div></div>';
	var frmDetails22 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Color: </b></div><div style\='width: 25%; display: inline-block'>" +color1 + '</div></div>';
	var frmDetails23 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Lot #: </b></div><div style\='width: 25%; display: inline-block'>" +lot1 + '</div></div>';
	var frmDetails24 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Customer Slected? </b></div><div style\='width: 25%; display: inline-block'>" +selected1 + '</div></div>';
	var frmDetails25 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Edge: </b></div><div style\='width: 25%; display: inline-block'>" +edge1 + '</div></div>';
	var frmDetails26 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Backsplash? </b></div><div style\='width: 25%; display: inline-block'>" +bsdetail1 + '</div></div>';
	var frmDetails27 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Riser Detail? </b></div><div style\='width: 25%; display: inline-block'>" +rsdetail1 + '</div></div>';
	var frmDetails28 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Model: </b></div><div style\='width: 25%; display: inline-block'>" +model1 + '</div></div>';
	var frmDetails29 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Cutout: </b></div><div style\='width: 25%; display: inline-block'>" +cutout1 + '</div></div>';
	var frmDetails30 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Sinks: </b></div><div style\='width: 25%; display: inline-block'>" +sinks1 + '</div></div>';
	var frmDetails31 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Range: </b></div><div style\='width: 25%; display: inline-block'>" +range1 + '</div></div>';
	var frmDetails32 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Faucet Spread / Holes: </b></div><div style\='width: 25%; display: inline-block'>" +spread1 + '</div></div>';
	var frmDetails33 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Other Holes: </b></div><div style\='width: 25%; display: inline-block'>" +holes1 + '</div></div>';
	var frmDetails34 = "<div style\='width: 100%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 100%; display: inline-block;'><b>Notes: </b></div><div style\='width: 100%; display: inline-block'>" +notes1 + '</div></div></div>';

	var headString4 = '<div style\="100%"><h2>Install 2 Details</h2>';

	var frmDetails35 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Install 2 Name: </b></div><div style\='width: 25%; display: inline-block'>" +install2name + '</div></div>';
	var frmDetails36 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Job Type: </b></div><div style\='width: 25%; display: inline-block'>" +jobtype2 + '</div></div>';
	var frmDetails37 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Tear Out: </b></div><div style\='width: 25%; display: inline-block'>" +tearout2 + '</div></div>';
	var frmDetails38 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Material: </b></div><div style\='width: 25%; display: inline-block'>" +material2 + '</div></div>';
	var frmDetails39 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Color: </b></div><div style\='width: 25%; display: inline-block'>" +color2 + '</div></div>';
	var frmDetails40 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Lot #: </b></div><div style\='width: 25%; display: inline-block'>" +lot2 + '</div></div>';
	var frmDetails41 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Customer Slected? </b></div><div style\='width: 25%; display: inline-block'>" +selected2 + '</div></div>';
	var frmDetails42 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Edge: </b></div><div style\='width: 25%; display: inline-block'>" +edge2 + '</div></div>';
	var frmDetails43 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Backsplash? </b></div><div style\='width: 25%; display: inline-block'>" +bsdetail2 + '</div></div>';
	var frmDetails44 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Riser Detail? </b></div><div style\='width: 25%; display: inline-block'>" +rsdetail2 + '</div></div>';
	var frmDetails45 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Model: </b></div><div style\='width: 25%; display: inline-block'>" +model2 + '</div></div>';
	var frmDetails46 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Cutout: </b></div><div style\='width: 25%; display: inline-block'>" +cutout2 + '</div></div>';
	var frmDetails47 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Sinks: </b></div><div style\='width: 25%; display: inline-block'>" +sinks2 + '</div></div>';
	var frmDetails48 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Range: </b></div><div style\='width: 25%; display: inline-block'>" +range2 + '</div></div>';
	var frmDetails49 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Faucet Spread / Holes: </b></div><div style\='width: 25%; display: inline-block'>" +spread2 + '</div></div>';
	var frmDetails50 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Other Holes: </b></div><div style\='width: 25%; display: inline-block'>" +holes2 + '</div></div>';
	var frmDetails51 = "<div style\='width: 100%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 100%; display: inline-block;'><b>Notes: </b></div><div style\='width: 100%; display: inline-block'>" +notes2 + '</div></div></div>';

	var headString5 = '<div style\="100%"><h2>Install 3 Details</h2>';

	var frmDetails52 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Install 3 Name: </b></div><div style\='width: 25%; display: inline-block'>" +install3name + '</div></div>';
	var frmDetails53 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Job Type: </b></div><div style\='width: 25%; display: inline-block'>" +jobtype3 + '</div></div>';
	var frmDetails54 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Tear Out: </b></div><div style\='width: 25%; display: inline-block'>" +tearout3 + '</div></div>';
	var frmDetails55 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Material: </b></div><div style\='width: 25%; display: inline-block'>" +material3 + '</div></div>';
	var frmDetails56 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Color: </b></div><div style\='width: 25%; display: inline-block'>" +color3 + '</div></div>';
	var frmDetails57 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Lot #: </b></div><div style\='width: 25%; display: inline-block'>" +lot3 + '</div></div>';
	var frmDetails58 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Customer Slected? </b></div><div style\='width: 25%; display: inline-block'>" +selected3 + '</div></div>';
	var frmDetails59 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Edge: </b></div><div style\='width: 25%; display: inline-block'>" +edge3 + '</div></div>';
	var frmDetails60 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Backsplash? </b></div><div style\='width: 25%; display: inline-block'>" +bsdetail3 + '</div></div>';
	var frmDetails61 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Riser Detail? </b></div><div style\='width: 25%; display: inline-block'>" +rsdetail3 + '</div></div>';
	var frmDetails62 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Model: </b></div><div style\='width: 25%; display: inline-block'>" +model3 + '</div></div>';
	var frmDetails63 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Cutout: </b></div><div style\='width: 25%; display: inline-block'>" +cutout3 + '</div></div>';
	var frmDetails64 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Sinks: </b></div><div style\='width: 25%; display: inline-block'>" +sinks3 + '</div></div>';
	var frmDetails65 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Range: </b></div><div style\='width: 25%; display: inline-block'>" +range3 + '</div></div>';
	var frmDetails66 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Faucet Spread / Holes: </b></div><div style\='width: 25%; display: inline-block'>" +spread3 + '</div></div>';
	var frmDetails67 = "<div style\='width: 45%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 50%; display: inline-block;'><b>Other Holes: </b></div><div style\='width: 25%; display: inline-block'>" +holes3 + '</div></div>';
	var frmDetails68 = "<div style\='width: 100%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 100%; display: inline-block;'><b>Notes: </b></div><div style\='width: 100%; display: inline-block'>" +notes3 + '</div></div></div>';

	var frmDetails69 = "<div style\='width: 100%; display: inline-block; padding: 5px; border: 1px solid #000'><div style\='width: 100%; display: inline-block;'><b>Service Ticket Data: </b></div><div style\='width: 100%; display: inline-block'>" + servicereport + '</div></div></div>';


	var submitCust = headString1 + frmDetails2 + frmDetails3 + frmDetails4 + frmDetails5 + frmDetails6 + frmDetails7 + frmDetails8 + frmDetails9 + frmDetails10 + frmDetails11 + frmDetails12;
	var submitSite = headString2 + frmDetails13 + frmDetails14 + frmDetails15 + frmDetails16 + frmDetails17;
	var submitInsta = headString3 + frmDetails18 + frmDetails19 + frmDetails20 + frmDetails21 + frmDetails22 + frmDetails23 + frmDetails24 + frmDetails25 + frmDetails26 + frmDetails27 + frmDetails28 + frmDetails29 + frmDetails30 + frmDetails31 + frmDetails32 + frmDetails33 + frmDetails34;
	var submitInstb = headString4 + frmDetails35 + frmDetails36 + frmDetails37 + frmDetails38 + frmDetails39 + frmDetails40 + frmDetails41 + frmDetails42 + frmDetails43 + frmDetails44 + frmDetails45 + frmDetails46 + frmDetails47 + frmDetails48 + frmDetails49 + frmDetails50 + frmDetails51;
	var submitInstc = headString5 + frmDetails52 + frmDetails53 + frmDetails54 + frmDetails55 + frmDetails56 + frmDetails57 + frmDetails58 + frmDetails59 + frmDetails60 + frmDetails61 + frmDetails62 + frmDetails63 + frmDetails64 + frmDetails65 + frmDetails66 + frmDetails67 + frmDetails68;




	var attach_file     = $('#attachment-a1')[0].files[0];




    var m_data = new FormData($(editForm)[0]); 
	  console.log(m_data.entries());
//	var data = {};
//	if (fid == 'form1' || fid == 'form2') {
//		data = {
//			customername: customername,
//			customeremail: customeremail,
//			htmla: submitCust,
//			htmlb: submitSite,
//			htmlc: submitInsta,
//			htmld: submitInstb,
//			htmle: submitInstc,
//		};
//		m_data.append( 'data', data);
//		m_data.append( 'file_attach', $('input[name=attachmenta1]')[0].files[0]);
//	} else if (fid == 'form3') {
//		data = {
//			"Customer Name: ": customername,
//			"Customer Email: ": customeremail,
//			htmla: submitCust,
//			htmlb: submitSite,
//			htmlc: frmDetails69
//		};
//		m_data.append( 'data', data);
//	}



    $.ajax({
        type: "POST",
        url: "php/test.php",
		data: m_data,
		processData: false,
		contentType: false,
		dataType:'json',
		success : function(text){
            if (text == "success"){
                formSuccess();
            }
        }
    });
}


function formSuccess(){
	$('section').fadeOut(500);
    $( "#thank-you" ).modal("show");
	$('#select-form').fadeIn(500)
	$('.masthead').fadeIn(500);
	$('.mastfoot').fadeIn(500);
}


$('form').submit(function(){
	thisForm = this.id;
	console.log(thisForm);
    // cancels the form submission
    event.preventDefault();
    submitForm(thisForm);
});
