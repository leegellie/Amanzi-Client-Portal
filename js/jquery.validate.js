/**
 * @author GeekTantra
 * @date 20 September 2009
 */
function checkUser() {
	var username = $("#username").val();
	$("#usernameError").replaceWith("<span id='usernameError' style='color:#080;'></span>");
	// DATA IS THE RETURNED DATA. IT WILL BE NUMERICAL FOR THE NUMBER OF MATCHES FOUND OR "X" IF NO USERNAME IS GIVEN (IE. " ").
	$.post("ajax.php",{action:"add_user_verify_username",username:username},function(data) {
		$("#usernameError").replaceWith("<span id='usernameError'></span>");
		if (isNaN(data)) {
			//$("#usernameError").replaceWith("<span id='usernameError' style='color:#F00;'>X No username given</span>");
		} else if (data > 0) {
			var uname_count_plural = "";
			if (data > 1) {
				uname_count_plural = "es";
			}
			$("#usernameError").replaceWith("<span id='usernameError' style='color:#F00;'>&#x2718; Username already exists. " + data + " Match" + uname_count_plural + " Found.</span>");
			$("#user_email_error").replaceWith("<span id='user_email_error' style='color:#F00;'>&#x2718; Username &amp; Email MUST be unique.</span>");
			$("#FormSubmit").attr({disabled: "true"});
		} else {
			$("#usernameError").replaceWith("<span id='usernameError' style='color:#080;'>&#x2714;</span>");
			$("#user_email_error").replaceWith("<span id='user_email_error'></span>");
			$("#FormSubmit").removeAttr("disabled");
		}
	});
}
// CHECK FOR DUPLICATE EMAIL ADDRESS
function checkEmail() {
	var email = $("#email").val();
	$("#emailError").replaceWith("<span id='emailError' style='color:#080;'></span>");
	// DATA IS THE RETURNED DATA. IT WILL BE NUMERICAL FOR THE NUMBER OF MATCHES FOUND OR "X" IF NO USERNAME IS GIVEN (IE. " ").
	$.post("ajax.php",{action:"add_user_verify_email",email:email},function(data) {
		$("#emailError").replaceWith("<span id='emailError'></span>");
		if (isNaN(data)) {
			//$("#usernameError").replaceWith("<span id='usernameError' style='color:#F00;'>X No username given</span>");
		} else if (data > 0) {
			var email_count_plural = "";
			if (data > 1) {
				email_count_plural = "es";
			}
			$("#emailError").replaceWith("<span id='emailError' style='color:#F00;'>&#x2718; Email already exists. " + data + " Match" + email_count_plural + " Found.</span>");
			$("#user_email_error").replaceWith("<span id='user_email_error' style='color:#F00;'>&#x2718; Username &amp; Email MUST be unique.</span>");
			$("#FormSubmit").attr({disabled: "true"});
		} else {
			$("#emailError").replaceWith("<span id='emailError' style='color:#080;'>&#x2714;</span>");
			$("#user_email_error").replaceWith("<span id='user_email_error'></span>");
			$("#FormSubmit").removeAttr("disabled");
		}
	});
}

(function(jQuery){
    var ValidationErrors = new Array();
    jQuery.fn.validate = function(options){
        options = jQuery.extend({
            expression: "return true;",
            message: "",
            error_class: "fg-red",
            error_field_class: "new-error-state",
            live: true
        }, options);
        var SelfID = jQuery(this).attr("id");
        var unix_time = new Date();
        unix_time = parseInt(unix_time.getTime() / 1000);
        if (!jQuery(this).parents('form:first').attr("id")) {
            jQuery(this).parents('form:first').attr("id", "Form_" + unix_time);
        }
        var FormID = jQuery(this).parents('form:first').attr("id");
        if (!((typeof(ValidationErrors[FormID]) == 'object') && (ValidationErrors[FormID] instanceof Array))) {
            ValidationErrors[FormID] = new Array();
        }
        if (options['live']) {
            if (jQuery(this).find('input').length > 3) {
                jQuery(this).find('input').bind('blur', function(){
                    if (validate_field("#" + SelfID, options)) {
                        if (options.callback_success) 
                            options.callback_success(this);
                    }
                    else {
                        if (options.callback_failure) 
                            options.callback_failure(this);
                    }
                });
                jQuery(this).find('input').bind('focus keypress click', function(){
                    jQuery("#" + SelfID).next('.' + options['error_class']).remove();
                    jQuery("#" + SelfID).removeClass(options['error_field_class']);
                });
            }
            else {
                jQuery(this).bind('blur', function(){
                    validate_field(this);
                });
                jQuery(this).bind('focus keypress', function(){
                    jQuery(this).next('.' + options['error_class']).fadeOut("fast", function(){
                        jQuery(this).remove();
                    });
                    jQuery(this).removeClass(options['error_field_class']);
                });
            }
        }
        jQuery(this).parents("form").submit(function(){
            if (validate_field('#' + SelfID)) 
                return true;
            else 
                return false;
        });
        function validate_field(id){
			$("#usernameError").replaceWith("<span id='usernameError' style='color:#080;'></span>");
            var self = jQuery(id).attr("id");
            var expression = 'function Validate(){' + options['expression'].replace(/VAL/g, 'jQuery(\'#' + self + '\').val()') + '} Validate()';
            var validation_state = eval(expression);
            if (!validation_state) {
                if (jQuery(id).next('.' + options['error_class']).length == 0) {
                    jQuery(id).after('<span class="' + options['error_class'] + '">' + options['message'] + '</span>');
                    jQuery(id).addClass(options['error_field_class']);
                }
                if (ValidationErrors[FormID].join("|").search(id) == -1) 
                    ValidationErrors[FormID].push(id);
                return false;
            }
            else {
                for (var i = 0; i < ValidationErrors[FormID].length; i++) {
                    if (ValidationErrors[FormID][i] == id) 
                        ValidationErrors[FormID].splice(i, 1);
                }
				if (SelfID == 'username') {
					checkUser()
				}
				if (SelfID == 'email') {
					checkEmail()
				}
                return true;
            }
        }
    };
    jQuery.fn.validated = function(callback){
        jQuery(this).each(function(){
            if (this.tagName == "FORM") {
                jQuery(this).submit(function(){
                    if (ValidationErrors[jQuery(this).attr("id")].length == 0) 
                        callback();
					return false;
                });
            }
        });
    };
})(jQuery);
