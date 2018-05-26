<?
session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
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
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<title>User Dashboard</title>
<?PHP include('globalscripts.php'); ?>
</head>
<body>
<p><?= "Welcome $first_name $last_name"; ?>. <a href="/logout.php">Log Out</a></p>
<p style="font-weight:bold;">Your active projects:</p>

<?
$project_list = new project_action();
$project_list_array = $project_list -> client_get_projects($_SESSION['id']);
echo '<table><tr><th>Quote #</th><th>Order #</th><th>Project</th><th>Active?</th><th>View</th></tr>';
foreach ($project_list_array as $project_list_row) {
	if ($project_list_row['quote_num'] != "") {
		$qnum = $project_list_row['quote_num'];
	} else {
		$qnum = "None";
	}
	if ($project_list_row['order_num'] != "") {
		$onum = $project_list_row['order_num'];
	} else {
		$onum = "None";
	}
	$project_name = ($project_list_row['job_name'] !="" ? $project_list_row['job_name'] : "None");
	$active = ($project_list_row['isActive'] == "1" ? "Yes" : "No");

	echo "<tr><td>$qnum</td><td>$onum</td><td>$project_name</td><td>$active</td><td><a href='view_installs.php?r=" . $project_list_row['id'] . "'>View Project</a></td></tr>" ;
}
echo '</table>';
?>
<?PHP if ($access_level == "13") { ?>
<p style="font-weight:bold;">Your sub users:</p>
<p>Username | Name | Action</p>
<?
$user_list = new clientUserAction();
$user_list_array = $user_list -> get_use_list($_SESSION['id']);
foreach ($user_list_array as $user_list_row) {
	$users_name = $user_list_row['username'];
	
	$users_fullname = $user_list_row['fname'] . " ". $user_list_row['lname'];

	echo "$users_name | $users_fullname | <a href='view_user.php?u=" . $user_list_row['id'] . "'>View/Edit</a> <br>" ;
}
?>
<a href="user_add.php">Add a User</a>
<?PHP } ?>
</body>
</html>