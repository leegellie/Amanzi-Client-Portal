<?PHP 
// IF USER ACCESS  = 1 THEN USER IS AN ADMIN. SHOW ADMIN MENU
if ($access_level < 11) {
?>
<header class=" d-print-none">

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="top:0px; z-index:5">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        	<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#"><img src="../images/icon.png" style="max-width:52px"></a>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav m-auto">
				<li class="nav-item py-3 px-4">
					<a class="element" href="dashboard.php"><span class="icon-home"></span></a>
				</li>
<?
	if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="userdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
					<div class="dropdown-menu" aria-labelledby="userdropdown">
						<a class="dropdown-item text-dark" href="admin.php?profit">Profit/Loss</a>
						<a class="dropdown-item text-dark" href="admin.php?stats">Stats</a>
					</div>
				</li>
<?
	}
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="userdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Customers</a>
					<div class="dropdown-menu" aria-labelledby="userdropdown">
						<a class="dropdown-item text-dark" href="users.php?edit">View Customers</a>
<?
	if ($access_level < 4) {
?>
						<a class="dropdown-item text-dark" href="users.php?add">Add Customers</a>
<?
	}
	if ($access_level < 11) {
?>
					</div>
				</li>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="pjtdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Projects</a>
					<div class="dropdown-menu" aria-labelledby="pjtdropdown">
						<a class="dropdown-item text-dark" href="projects.php?edit">View Projects</a>
<?
	}
	if ($access_level < 4) {
?>
						<a class="dropdown-item text-dark" href="projects.php?add">Add a Project</a>
<?
	}
	if ($access_level == 1 || $access_level == 3) {
?>
						<a class="dropdown-item text-dark" href="projects.php?entry">To Enter</a>
<?
	}
?>
						<a class="dropdown-item text-dark" href="projects.php?templates">Templates</a>
						<a class="dropdown-item text-dark" href="projects.php?installs">Installs</a>
            <a class="dropdown-item text-dark" href="projects.php?timeline">Timeline</a>
						<!--<a class="dropdown-item text-dark" onclick="$('#qr_scanner').modal('show')">QR Test</a>-->
					</div>
				</li>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Prices</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/projects.php?marbgran">Marble/Granite</a>
						<a class="dropdown-item text-dark" href="/admin/projects.php?quartz">Quartz</a>

						<!--<a class="dropdown-item text-dark" onClick="window.open('/login.php')" href="#">Materials Pricing</a>-->
					</div>
				</li>

<?
	if ($access_level == 6 || $access_level == 1) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Materials</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/materials.php">Material Needed</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?marble">Marble/Granite</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?quartz">Quartz</a>

						<!--<a class="dropdown-item text-dark" onClick="window.open('/login.php')" href="#">Materials Pricing</a>-->
					</div>
				</li>

<?
	}
	if ($access_level < 11) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/time_off.php">Time Off</a>

						<!--<a class="dropdown-item text-dark" onClick="window.open('/login.php')" href="#">Materials Pricing</a>-->
					</div>
				</li>
				
<?
	}
	if ($access_level == 1) {
?>
<!-- 				<li class="nav-item py-3 px-4 dropdown">
						<a class="" href="/admin/testing.php">Testing</a>
				</li> -->

				<!--<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tools</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" target="_blank" href="/waiver/">Visitor's Waiver</a>
						<a class="dropdown-item text-dark" target="_blank" href="http://calc.amanzigranite.com/">Materials Calculator</a>
						<a class="dropdown-item text-dark" target="_blank" href="http://price.amanzigranite.com/">Materials Pricing</a>

					</div>
				</li>-->
<?
	}
?>
			</ul>
			<a href="/logout.php" class="btn nav-item btn-secondary my-auto text-white">Log Out</a>
		</div>
	</nav>
</header>
<?
}
?>
