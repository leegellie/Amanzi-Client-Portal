<div class="container-fluid px-3 pageLook">
	<div class="row">
		<div class="col-12" style="margin-left:0">
			<div id="user-data" class="col-12">
				<div class="row">
					<div class="col-md-8 d-block"></div>
					<div class="col-7 col-md-4">Filter: 
						<div class="input-group mb-3">
							<input id="filterJobs" class="form-control" onchange="filterJobs(this.value)" type="date" value="">
							<div class="input-group-append">
								<span class="input-group-text" onClick="$('.job').show();$('#filterJobs').val('')"><i class="far fa-calendar-times"></i></span>
							</div>
						</div>
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
<script>
$(document).ready(function(){
	loadTimelines(); 

});

</script>

<?
?>
