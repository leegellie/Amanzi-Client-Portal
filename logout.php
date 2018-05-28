<?
session_start();
if (session_destroy())
{
	header('Location: /login.php');
} 
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
<meta charset="utf-8">
<title>Log Out</title>
</head>
<body>
	<div class="form-container">
		<form name="loginForm" id="loginForm" class="smart-red"> 
			<script>
				colorForm();
			</script>
			<h1 id="formHead">Logging Out</h1>
            <label>
            	<span>If you are not redirected in 5 seconds then click button: </span><br><br>
			</label>
			<a class="button" onclick='window.open("login.php", "_self");' >Log Out</a>
		</form>
	</div>
</body>
</html>