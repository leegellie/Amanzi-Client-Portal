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

    <title>Amanzi Client Portal</title>

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

    <link rel="manifest" href="/manifest.json" version="2">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/ie10.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">

</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><img alt="Amanzi Granite" longdesc="https://amanzigranite.com" src="/images/web-logo.png"></h3>
                        <nav class="nav nav-masthead">
                            <a class="btn btn-dark web" href="https://amanzigranite.com"><i class="fa fa-xl fa-globe"></i><p>Visit Website</p></a>
                            <a class="btn btn-light btn-lg call" href="tel:+13369939998"><i class="fa fa-xl fa-phone"></i><p>Call Amanzi</p></a>
                        </nav>
                    </div>
                </div>
                <div class="inner cover">

					<section class="container">
<?php  //Start the Session
session_start();
require('db_connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
	//3.1.1 Assigning posted values to variables.
	$username = $_POST['username'];
	$password = $_POST['password'];
	//3.1.2 Checking the values are existing in the database or not
	$query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";
	 
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($result);
	//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
	if ($count == 1){
		$_SESSION['username'] = $username;
	}else{
		//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
		$fmsg = "Invalid Login Credentials.";
	}
}
//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	echo "Hi " . $username . "
	";
	echo "This is the Projects Page
	";
	echo "<a href='/php/logout.php'>Logout</a>";
 
}else{
	//3.2 When the user visits the page first time, simple login form will be displayed.
?>

	<form class="form-signin" method="POST">
        <h2 class="form-signin-heading text-dark">Please Log In</h2>
        <div class="input-group">
			<label for="username" class="sr-only">User Name / Email</label>
			<span class="input-group-addon" id="basic-addon1 col-2"><i class="fa fa-user"></i></span>
			<input type="text" name="username" class="form-control" placeholder="Username" required>
		</div>
		<div class="input-group">
			<label for="inputPassword" class="sr-only">Password</label>
			<span class="input-group-addon" id="basic-addon1 col-2"><i class="fa fa-lock"></i></span>
			<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		</div>
        <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Login</button>
        <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
      </form>

<?
}
?>
					</section>
				</div>
			</div>
		</div>
	</div>
</body>