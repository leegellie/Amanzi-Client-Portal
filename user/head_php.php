<?
$check_if_logged_in = new login;
if ($check_if_logged_in->is_logged_in())
{
	$check_if_logged_in->dashboard_access(">",10);
} else
{
	header('Location: /logout.php');
}
$check_if_logged_in->dashboard_access(">",10);
	
$user_info = new userData;
$user_info->set_selection("*",$_SESSION['id']);

$username = $user_info->get_results("username");
$access_level = $user_info->get_results("access_level");
$first_name = $user_info->get_results("fname");
$last_name = $user_info->get_results("lname");
$user_email = $user_info->get_results("email");
?>