$uid = '';

jQuery(document).ready(function($){
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	var $sigdiv = $("#signature");

	$('#clearSig').click( function() {
		$sigdiv.jSignature() // inits the jSignature widget.
		// after some doodling...
		$sigdiv.jSignature("destroy") // clears the canvas and rerenders the decor on it.
	});

	function formIn(id){
		var formId = '#' + id;
		//console.log(formId);
		$('section').fadeOut(500);
		setTimeout(function(){
			$(formId).fadeIn(500);
			if (id == 'waiver'){
				$sigdiv.jSignature();				
			}
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


	function submitForm(fid){
		//var data = new FormData($('#waiver')[0]);
		var datastring = {
			'fname' : $('input[name=fname]').val(),
			'lname' : $('input[name=lname]').val(),
			'source' : $('select[name=source]').val(),
			'phone' : $('input[name=phone]').val(),
			'email' : $('input[name=email]').val(),
			'address1' : $('input[name=address1]').val(),
			'address2' : $('input[name=address2]').val(),
			'city' : $('input[name=city]').val(),
			'state' : $('#state option:selected').val(),
			'zip' : $('input[name=zip]').val(),
			'guests' : $('input[name=guests]').val(),
			'record' : $('input[name=formID]').val()
		};

		$.ajax({
			type: "POST",
			url: "php/waiver.php",
			data: datastring,
			success : function(data){
				$uid = data;
			},
			error : function(data){
				console.log(data);
			},
			complete: function(){
				formSuccess();
			}
		});
	}


	function formSuccess(){
		$('form')[0].reset();

		$('section').fadeOut(500);

		$('#select-form').fadeIn(500);
		$('.masthead').fadeIn(500);
		$('.mastfoot').fadeIn(500);
		$('.sigBox').show();

		$sigdiv.jSignature("destroy");

		$('#renderImg').addClass('hidden');
		$('#renderImg > img').remove();

		setID();
		$( "#thank-you" ).modal("show");
		$('button').removeAttr('disabled');
	}


	$('form').submit(function(){
		event.preventDefault();
		if ($('#source option:selected').val() == 0) {
			alert('Please let us know how you heard about us.');
		} else {
			$('button').attr('disabled', 'disabled');
			thisForm = this.id;
			submitForm(thisForm);
		}
		event.preventDefault();
	});


});