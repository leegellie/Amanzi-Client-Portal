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
// If the values are posted, insert them into the database.
    if (isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
	$email = $_POST['email'];
        $password = $_POST['password'];
 
        $query = "INSERT INTO `user` (username, password, email) VALUES ('$username', '$password', '$email')";
        $result = mysqli_query($connection, $query);
        if($result){
            $smsg = "User Created Successfully.";
        }else{
            $fmsg ="User Registration Failed";
        }
    }
?>

						<div class="container">
							  <form class="form-signin" method="POST">
							  <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
							  <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
								<h2 class="form-signin-heading">Please Register</h2>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1 col-2"><i class="fa fa-user m-auto"></i></span>
									<input type="text" name="username" class="form-control" placeholder="Username" required>
								</div>
								<div class="input-group">
									<label for="inputEmail" class="sr-only">Email address</label>
									<span class="input-group-addon" id="basic-addon1 col-2"><i class="fa fa-envelope m-auto"></i></span>
									<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
								</div>
								<div class="input-group">
									<label for="inputPassword" class="sr-only">Password</label>
									<span class="input-group-addon" id="basic-addon1 col-2"><i class="fa fa-lock m-auto"></i></span>
									<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
								</div>
									<button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Register</button>
									<a class="btn btn-lg btn-primary btn-block" href="/">Login</a>
							  </form>
						</div>

					</section>
				</div>
			</div>
		</div>
	</div>
</body>