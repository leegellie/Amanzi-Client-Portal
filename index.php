<?PHP
if(!session_id()) session_start();
// ini_set('session.gc_maxlifetime', 0);
// ini_set('cookie_secure','1');
// session_set_cookie_params(0,'/','',true,true);
require_once ('include/class/user.class.php');
/*
Checks if user login sessions exist. If they do, the session data
is matched to the db data. If that matches then the user has logged
in already and is forwarded to their dashboard.

If either of the above return false then a check is make to see if
post data exists. If it does, the data is passed on to verify the
credentials. If credentials are verified the user is forwarded
to their dashboard.

Else, generate a fresh token for the login form and session.

@ var token = The generate token.
@ var errorMsg = String containing any error messages.

<?= $errorMsg ?> will output the error message string.
*/
$check_if_logged_in = new login;
$errorMsg ="";
if ($check_if_logged_in->is_logged_in()) {
	$check_if_logged_in->set_access_headers();
} elseif (isset($_POST['token']) && isset($_POST['uname']) && isset($_POST['upass'])) {
	$token = $_SESSION['token'];
	$login_user = new login;
	$checkUsername = $login_user->set_user_login();
	if($login_user->get_user_login()) {
		$errorMsg = "Success";
	} else {
		$errorMsg = $login_user->get_error_message();
	}
} else {
	$token = $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <title>Amanzi Portal</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <link rel="manifest" href="/manifest.json">

    <link rel="stylesheet" type="text/css" href="css2/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css2/ie10.css">
    <link rel="stylesheet" type="text/css" href="css2/styles.css">
    <link rel="stylesheet" type="text/css" href="css2/font-awesome.min.css">

	<style>
    input[name=users]{
        font-size: 2rem;
    }
body {
	width: 100%;
	font-family: Arial, Helvetica, sans-serif;
	background-color: rgb(250,250,250);
	color: #333;
}
.form-container {
	text-align: center;
	width: 30vmin;
	margin: auto;
	border: solid 1px #DDD;
	padding: 1vmin;
}
#formLabelContainer {
	font-size: 2vmin;
	background-color: rgb(240,240,240);
}
#formBody {
	background-color: #FFF;
}
input {
	font-size: 1em;
	padding: 7px 5px;
	border-radius: .5vmin;
	border: solid 1px #DDD;
	outline: none;
}
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px #FFF inset;
}
input[type=submit] {
	width: 100%;
	background-color: rgb(100,140,100);
	color: #FFF;
	font-weight: bold;
	border: none;
}
input[type=submit]:hover {
	background-color: rgb(150,200,150);
	cursor: pointer;
}
input[type=text],input[type=password] {
	margin-bottom: 10px;
	width: 100%;
}
label {
    width: 100%;
}
</style>
<script>
// Form validation for email as username and password not blank.
function ValidateEmail(form){
	document.getElementById('email-error').innerHTML = '';
	document.getElementById('passw-error').innerHTML = '';
	var username = loginForm.uname.value;
	var password = loginForm.upass.value;
    var errors = 0;
	if (username=='') {
		errors += 1;
	}
    if (password=='') {
		errors += 2;
	}
    if (errors > 0) {
		reportErrors(errors);
		return false;
	}
	return true;
}
function reportErrors(errors){
	if (errors == 1) {
		document.getElementById('email-error').innerHTML = ' <span style="color:#F00">* You have entered an invalid user name!</span><br>';
	} else if (errors == 2) {
		document.getElementById('passw-error').innerHTML = ' <span style="color:#F00">* You have not entered a valid password!</span><br>';
	} else if (errors == 3) {
		document.getElementById('email-error').innerHTML = ' <span style="color:#F00">* You have entered an invalid user name!</span><br>';
		document.getElementById('passw-error').innerHTML = ' <span style="color:#F00">* You have not entered a valid password!</span><br>';
	}
}
</script>
</head>

<body onload='document.loginForm.uname.focus()'>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><img alt="Amanzi Granite" longdesc="https://amanzigranite.com" src="images2/web-logo.png"></h3>
                    </div>
                </div>
				<div class="inner cover">
					<section class="container align-middle" id="select-client">
						<h1 class="head-text text-center">Amanzi Portal</h1>
						<div class="row">
							<div class="m-auto card-holder">
								<div class="card">

	<div id="formLabelContainer" class="form-container">
       	Please Sign In
	</div>
	<div class="form-container" id="formBody">
        <form name="loginForm" id="loginForm" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" class="smart-green"> 
            <label>
			    <input name="uname" id="uname"  type="text" placeholder="Username" /><br>
				<div id="email-error"></div>
			</label>
		    <label>
		        <input name="upass" id="upass" type="password" placeholder="Password"  />
				<div id="passw-error"></div>
		    </label>
			<input name="token" id="token" type="hidden" value="<?= $token; ?>" />
			<label>
				<span id="error-mes" style="color:#F00" class="hide"><?= $errorMsg ?></span>
                <script>
					if (document.getElementById('error-mes').innerHTML == '') {
						document.getElementById('error-mes').className = 'hide';
					} else {
						document.getElementById('error-mes').className = 'show';
					}
				</script>
				<input name="submitForm" id="submitForm" type="submit" class="button" value="Login"  onclick="return ValidateEmail(document.loginForm.uname)" />
		    </label>
		</form>
	</div>

								</div>
							</div>
						</div>
					</section>
	            </div>
            </div>
        </div>
    </div>

</body>
</html>