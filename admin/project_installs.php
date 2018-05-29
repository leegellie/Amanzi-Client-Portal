<div class="container pageLook">
	<div class="row">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row">
						<h1 class="text-primary col-10">Installs Scheduled</h1>
						<a class="btn btn-lg btn-success col-2" target="_blank" href="/admin/inst_route.php"><i class="fas fa-map h1"></i></a>
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
<script>
$(document).ready(function(){
    loadInstalls();
});

</script>

<?
include ('addInstallModal.php');
?>
