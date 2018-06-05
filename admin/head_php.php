<?
$check_if_logged_in = new login;
if ($check_if_logged_in->is_logged_in()) {
	$check_if_logged_in->dashboard_access("<",11);
} else {
	header('Location: /logout.php');
}
$check_if_logged_in->dashboard_access("<",11);
	
$user_info = new userData;
$user_info->set_selection("*",$_SESSION['id']);

$username = $user_info->get_results("username");
$userid = $user_info->get_results("id");
$access_level = $user_info->get_results("access_level");
$_SESSION["access_level"] = $access_level;

$first_name = $user_info->get_results("fname");
$last_name = $user_info->get_results("lname");
$user_email = $user_info->get_results("email");
$division = $user_info->get_results("division");
$department = $user_info->get_results("department");
$isManager = $user_info->get_results("isManager");
$_SESSION["division"] = $division;
$_SESSION["department"] = $department;
$_SESSION["isManager"] = $isManager;
?>