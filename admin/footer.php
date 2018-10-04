
<div class="blank_high" style="display:block; height:60px"></div>
<div class="container tertiary-text bg-dark text-white" style="padding:10px; bottom:0; left:0px; right:0px; width:100%; text-align:center; margin-top:60px">
	<p class="text-white">Copyright &copy; <?PHP echo date('Y',time()); ?> Amanzi Client Portal. All rights reserved.</p>
</div>

<div class="modal fade" id="materialSelect" tabindex="-1" role="dialog" aria-labelledby="materialSelectLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fab fa-telegram-plane"></i>
				<div class="modal-title">Select Material</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="container">
						<div class="row px-0">
							<div class="btn btn-lg col-6">Marble / Granite</div>
							<div class="btn btn-lg col-6">Quartz / Quartzite</div>
						</div>
						<div class="row px-0">
							<select class="levelFilter col-12 mb-3 form-control input-lg">
								<option class="btn btn-lg btn-dark mx-1 px-4" value="0">Filter...</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="1">Level 1</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="2">Level 2</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="3">Level 3</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="4">Level 4</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="5">Level 5</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="6">Level 6</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="7">Level 7</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="8">Level 8</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="9">Specialty</option>
							</select>
							<input class="form-control input-lg searchMat col-12 mb-3" placeholder="Search">
						</div>
					</div>
					<div id="matModalCards" class="row"></div>
					<hr>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
<script src="../js/modules/lightbox.js"></script>

<script>

$al = <? print_r($_SESSION['access_level']) ?>;
//$al = <? print_r($_SESSION['token']) ?>;

(function($) {
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
    $(document).ready(function() {
        $("input[name=zip]").keyup(function(element) {
			if (this.value.length == 5) {

				var formUse = '#' + $(this).closest('form').attr('id');
				var zipcode = this.value;
				if (zipcode == "") {
					alert("Please Enter Zipcode");
				}
				console.log(formUse);
				jQuery.ajax({
					url: "https://zip.getziptastic.com/v2/US/" + zipcode,
					cache: false,
					dataType: "json",
					type: "GET",
					success: function(result, success) {
						console.log(result);
						$(formUse).find('select[name=state]').val(result.state_short);
						$(formUse).find("input[name=city]").val(result.city);
					},
					error: function(result, success) {
						jQuery(".zip-error").slideDown(300);
					}
				});
			}
        });
    });
})(jQuery)

</script>