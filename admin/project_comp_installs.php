<div class="container pageLook">
	<div class="row">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row">
						<h1 class="text-primary col-10">Completed Installs</h1>
						<a class="btn btn-success col-2 mx-0" href="/admin/projects.php?installs"><i class="far fa-calendar-alt"> Schedule</i></a>
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
    loadCompInstalls();
});

</script>

<?
include ('modal_install_add.php');
?>
