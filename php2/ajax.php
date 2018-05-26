<?
// SEARCH JOBS. RETURN ARRAY

if ($action=="user_search_list") {
	$results = "";
	if ($_POST['isActive'] != '1') {
		$_POST['isActive'] = '0';
	}
	$_POST['user_find'] = trim(htmlspecialchars($_POST['user_find']));
	$_POST['search'] = "%" . $_POST['search'] . "%";
	if ($_POST['user_find'] == "username") {
		$_POST['search'] = strtolower($_POST['search']);
	}
	unset($_POST['action']);
	$search = new user_action;
	echo '<table id="resultsTable1" class="table hovered border striped nowrap dataTable dtr-inline">';
	echo "<thead style='text-align:left'><tr><th>Company</th><th>Username</th><th>Email</th><th>First name</th><th>Last Name</th><th>Edit</th></tr></thead>";
	echo "<tfoot style='text-align:left'><tr><th>Company</th><th>Username</th><th>Email</th><th>First name</th><th>Last Name</th><th>Edit</th></tr></tfoot>";
	foreach($search->user_data_search($_POST) as $results) {
		?>
        <tr>
        	<td><?= $results['company']; ?></td>
	        <td><?= $results['username']; ?></td>
	        <td><?= $results['email']; ?></td>
    	    <td><?= $results['fname']; ?></td>
        	<td><?= $results['lname']; ?></td>
	        <td><div id="<?= $results['id']; ?>" class="button fg-white bg-yellow" onClick="editThisUser(this.id);">Edit <i class="icon-wrench"></i></div></td>
        </tr>
		<?
	}
	echo "</table>";
}
?>