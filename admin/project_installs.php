<div class="container pageLook">
	<div class="row">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row">
						<h1 class="text-primary col-12 col-md-8">Installs Scheduled</h1>
						<div class="col-6 col-md-2">
							<a class="btn btn-primary w-100 mx-0" href="/admin/projects.php?completed"><i class="fas fa-check-circle"> Completed</i></a>
						</div>
						<div class="col-6 col-md-2">
							<a class="btn btn-lg btn-success w-100 mx-0" target="_blank" href="/admin/inst_route.php"><i class="fas fa-map h1"></i></a>
						</div>
					</div>
                    <div id="user-block" class="content">
						<div class="col-12" id="tableResults">




						</div>
           			</div>
					<div id="pjt-block" class="content">
						<div class="col-12" id="pjtResults"></div>
					</div>
					<div id="inst-list" class="content">
						<div class="col-12" id="pjtDetails"></div>
					</div>
					<div id="inst-block" class="content">
						<div class="col-12" id="instDetails"></div>
					</div>

				</div>
			</div>
	</div>
</div>
<?
include ('modal_install_add.php');
include ('modal_assign_installer.php');
?>

<script>
$(document).ready(function(){
    loadInstalls();
	//$('.mdb-select').material_select();
});

</script>

