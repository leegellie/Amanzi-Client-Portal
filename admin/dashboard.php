<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once ('head_php.php');

/*
HERE ARE THE CODE SNIPPETS TO DISPLAY USER INFO.
WHAT TO DISPLAY = CODE TO INSERT THE VALUE
USERNAME = <?= $username ?>
ACCESS LEVEL (NUMERIC VALUE) = <?= $access_level ?>
FIRST NAME = <?= $first_name ?>
LAST NAME = <?= $last_name ?>
USER'S EMAIL = <?= $user_email ?>
*/
?>
<!doctype html>
<html>
<head>


<meta charset="UTF-8">
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<?
// INCLUDE THE JS and CSS files needed on all ADMIN PAGES
include('includes.php');
// INCLUDE THE javascript.php FILE. THIS FILE IS USED TO DISPLAYS JAVASCRIPT THAT WILL BE USED THROUGHOUT THE ADMIN AREA
include('javascript.php');
?>

</head>
<body class="pt-5" style="background-color: rgb(239, 234, 227);">
<?PHP /*echo password_hash("123456",PASSWORD_DEFAULT) . "<br>"*/ ?>
<!-- STARTING MENU -->
<?PHP 
// INCLUDE THE menu.php FILE. THIS FILE IS USED TO DISPLAYS THE MENU
include('menu.php'); 
?>
<!-- ENDING MENU -->
<!-- START TOP HEADER -->
<?PHP 
// INCLUDE THE header.php FILE. THIS FILE IS USED TO DISPLAYS EVERYTHING ABOVE THE MAIN CONTENT AREA
include('header.php'); 
?>
<div class="container mt-5 pt-5">
	<div class="grid fluid">
	</div>
</div>
<!-- END ADMIN TOP HEADER -->
<!-- START DASHBOARD CONTENT AREA -->
<div class="container">
	<div class="grid fluid">
    	<div class="row">
	    	<div class="col-md-6">
				<div class="dark-stone m-4">
					<div class="text-white text-left pt-4 px-4" >
						<img src="/images/users.png" class="mb-4 float-right">
						<h1 class="pt-2 text-uppercase">Customers</h1>
						<p>Add &amp; edit user accounts.</p>
					</div>
					<div class="row w-100 m-0">
						<div class="col-md-6">
							<div class="text-center">
								<a href="users.php?edit" class="block"><h1 class="text-white py-4">View</h1></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-center">
								<a href="users.php?add" class="block"><h1 class="text-white py-4">Add</h1></a>
							</div>
						</div>
					</div>
				</div>
            </div>
	    	<div class="col-md-6">
				<div class="dark-stone m-4">
					<div class="text-white text-left pt-4 px-4">
						<img src="/images/projects.png" class="mb-4 float-right">
						<h1 class="pt-2 text-uppercase">Projects</h1>
						<p>Add &amp; edit your projects.</p>
					</div>
					<div class="row w-100 m-0">
						<div class="col-md-6">
							<div class="text-center">
								<a href="projects.php?edit" class="block"><h1 class="text-white py-4">View</h1></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-center">
								<a href="projects.php?add" class="block"><h1 class="text-white py-4">Add</h1></a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<div>
<!--
	USERNAME = <?= $username ?><br>
	USER ID = <?= $userid ?><br>
	ACCESS LEVEL (NUMERIC VALUE) = <?= $access_level ?><br>
	FIRST NAME = <?= $first_name ?><br>
	LAST NAME = <?= $last_name ?><br>
	USER'S EMAIL = <?= $user_email ?><br>
	DIVISION = <?= $division ?><br>
	DEPARTMENT = <?= $department ?><br>
	MANAGER = <?= $isManager ?><br>
-->
</div>

<!-- END DASHBOARD CONTENT AREA -->
<!-- START FOOTER -->
<?PHP 
// INCLUDE THE footer.php FILE. THIS FILE IS USED TO DISPLAYS EVERYTHING UNDER THE MAIN CONTENT AREA (IE. COPYRIGHT INFO)
include ('footer.php'); 
?>
<!-- END FOOTER --> 
</body>
</html>