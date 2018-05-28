

jQuery(document).ready(function($){

	function formIn(id){
		var formId = '#' + id;
		//console.log(formId);
		$('section').fadeOut(500);
		setTimeout(function(){
			$(formId).fadeIn(500);
		},600);
	}
	
	$('.start-form').click(function() {
		$link = $(this).attr('link');
		console.log($link);
		formIn($link);
	})

	$('.close-form').click(function() {
		var closeId = '#' + $(this).closest("section").prop("id");
		$(closeId).fadeOut(500);
		setTimeout(function(){
			$('#select-form').fadeIn(500);
			$('.masthead').fadeIn(500);
			$('.mastfoot').fadeIn(500);
		},600);
		$sigdiv.jSignature("destroy");
		setID();
	})

	$('.reset-btn').click(function(){
        //console.log($(this).closest('form').attr('id'));
		var toReset = '#' + $(this).closest('form').attr('id');
		console.log(toReset);
		$(toReset)[0].reset();
		$sigdiv.jSignature("destroy");
		setTimeout(function(){$sigdiv.jSignature();},600);

		//$sigdiv.jSignature();
	});
	function setID() {
		var formID = Math.random().toString().slice(2,11);
		$('#formID').val(formID);
	}
	setID();

	$('#badBut').click( function() {
		var $sigdiv = $("#signature");
		var datapair = $sigdiv.jSignature("getData", "svgbase64");
		var i = "data:" + datapair[0] + "," + datapair[1];
		var i = new Image();
		i.src = "data:" + datapair[0] + "," + datapair[1];
		$('#imgURI').removeClass('hidden');
		$('#imgURI').val(i.src);
		i.id = "sigDone";
		console.log(i);
		$(i).appendTo($("#renderImg")) // append the image (SVG) to DOM.
		//var newInput = '<input type="hidden" name="signature" value="' + $('#renderImg > img').prop('outerHTML'); + '">';
		//$sigdiv.append(newInput);
		$('.sigBox').hide();
		$("#renderImg").removeClass('hidden');
		$('#form-submit').removeClass('hidden');
		var nwFl = $('input[name=formID]').val();
		var nwDt = i.src;
		var data = {
			'SigName' : nwFl,
			'SigData' : nwDt
		}
		console.log(data);
		$.ajax({
			type: "POST",
			url: "php/signature.php",
			data: data,
			success: function(text) {
				console.log(text);
				$('#submit-box').removeClass('hidden');
			},
			error: function(req, err){ console.log('my message' + err); }
		})

	});
	function getDate() {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
		today = yyyy+""+mm+""+dd;
	
		document.getElementById("todayDate").value = today;
	}
		
	//call getDate() when loading the page
	getDate();

	function submitForm(fid){
		
		//var data = new FormData($('#waiver')[0]);
		var data = {
			'fname' : $('input[name=fname]').val(),
			'lname' : $('input[name=lname]').val(),
			'source' : $('select[name=source]').val(),
			'date' : $('input[name=startdate]').val(),
			'phone' : $('input[name=phone]').val(),
			'email' : $('input[name=email]').val(),
			'address1' : $('input[name=address1]').val(),
			'guests' : $('textarea[name=guests]').val(),
			'record' : $('input[name=formID]').val(),
			'isActive' : $('input[name=isActive]').val(),
		}
	
		$.ajax({
			type: "POST",
			url: "php/waiver.php",
			data: data,
			success : function(){
				formSuccess();
			}
		});
	}
	
	
	function formSuccess(){
		$('section').fadeOut(500);
		$( "#thank-you" ).modal("show");
		$('#select-form').fadeIn(500)
		$('.masthead').fadeIn(500);
		$('.mastfoot').fadeIn(500);
		$('form')[0].reset();
		$sigdiv.jSignature("destroy");
		$('#renderImg').addClass('hidden');
		$('#renderImg > img').remove();
		$('.sigBox').show();
		$('#submit-box').addClass('hidden');
		setID();
	}
	
	
	$('form').submit(function(){
		thisForm = this.id;
		//console.log(thisForm);
		// cancels the form submission
		event.preventDefault();
		submitForm(thisForm);
	});


});