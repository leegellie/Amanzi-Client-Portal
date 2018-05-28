<?PHP
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
require_once (__DIR__ . '/../include/class/materials.class.php');
require_once (__DIR__ . '/../include/class/admin.class.php');
/*
ADMIN AJAX REQUESTS 
*/
$action = trim(htmlspecialchars($_POST['action']));










?>