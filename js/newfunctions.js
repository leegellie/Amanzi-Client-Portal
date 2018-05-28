jQuery(document).ready(function($){
	
	function formIn(id){
		var formId = '#' + id + '-form';
		//console.log(formId);
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
	$('select[name="account-rep"]').change(function() {
		var repEmail = $("option:selected", this).attr('data-email');
		$('input[name=repEmail]').val(repEmail);
	});
	$('.holeOpt').change(function () {
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
    });


	$('.sect-btn').click(function() {
		if ($(this).hasClass('sect-add')){
			var toControl = "." + $(this).attr('data-control');
			//console.log(toControl);
			$(toControl).fadeIn(300);
			$(this).find('span').text('Remove install ');
			$(this).find('i').removeClass('fa-plus').addClass('fa-minus');
			$(this).removeClass('sect-add').addClass('sect-remove');
		} else {
			//console.log('Clicked.');
			var toControl = "." + $(this).attr('data-control');
			$(toControl).fadeOut(300);
			$(this).find('span').text('Add additional install ');
			$(this).find('i').removeClass('fa-minus').addClass('fa-plus');
			$(this).removeClass('sect-remove').addClass('sect-add');
		}
	})
	$('.reset-btn').click(function(){
        //console.log($(this).closest('form').attr('id'));
		var toReset = '#' + $(this).closest('form').attr('id');
		$(toReset)[0].reset();
	});
});

function submitForm(fid){
	var workingForm = '#' + fid;

	var form = $(workingForm)[0];
	var formData = new FormData(form);

//	for (var pair of formData.entries()) {
//		console.log(pair[0]+ ', ' + pair[1]); 
//	};
	var repName = $(fid).find(":selected").attr('data-email');

	$('input[type=file]').each(function(index, element) {
		if ($(this).val() != '') {
	        var file = $(this).val();
			var attName = $(this).attr('name');
			formData.append(attName, file, 'upload.jpg');
		}
    });
	$.ajax({
		url : 'php/form-nc1.php',
		type: 'POST',
		data: formData,
		success : function(text){
            if (text == "success"){
                formSuccess();
            } else {
				formFail();
			}
        },
		cache: false,
		contentType: false,
		processData: false
	});
	
    return false;

}

function loginForm(fid) {

	var workingForm = '#' + fid;
	var form = $(workingForm)[0];
	var formData = new FormData(form);

	$.ajax({
		url : 'php/login.php',
		type: 'POST',
		data: formData,
		success : function(text){
            if (text == "success"){
                loginSuccess();
            }
        },
		cache: false,
		contentType: false,
		processData: false
	});
}

function formSuccess(){
	$('form').each(function() { this.reset() });
	$('section').fadeOut(500);
    $( "#thank-you" ).modal("show");
	$('#select-form').fadeIn(500)
	$('.masthead').fadeIn(500);
	$('.mastfoot').fadeIn(500);
}
function formFail(){
	console.log('Form failed in PHP');
}


function loginSuccess(){
	$('form').each(function() { this.reset() });
	$('section').fadeOut(500);
    $( "#live-projects" ).fadeIn(500);
	//$('#select-form').fadeIn(500)
	$('.masthead').fadeIn(500);
	$('.mastfoot').fadeIn(500);
}

$('.matControl').change(function(){
	var fid = '#' + $(this).closest("form").attr('id');
	var matToChange = '#' + $(this).attr('data-control');
	var $fixForm = $(fid).find(matToChange);
	$fixForm.val('');
	var getDataInputs = 'input[data-control=' + $(this).attr('data-control') + ']';
	$(fid).find(getDataInputs).each(function() {
		if ($(this).val() != '') {
			var oldValue = $(fid).find(matToChange).val();
			var newValue = oldValue + $(this).val() + ' - ';
			$fixForm.val(newValue);
			//console.log($fixForm.val());
		}
	});
});


$('form').submit(function(){
	thisForm = this.id;
    // cancels the form submission
	//console.log(thisForm);
	if (thisForm == "login-form") {
		//loginForm(thisForm);
	} else {
	    event.preventDefault();
		submitForm(thisForm);
	}
});
