<div class="modal fade" id="mat_release_modal" tabindex="-1" role="dialog" aria-labelledby="mat_release_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Material Release Hold</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="mat_release_form row">
						<input type="hidden" name="action" value="mat_release">
						<input type="hidden" id="mr-pid" name="pid" value="">
						<input type="hidden" id="mr-iid" name="iid" value="">
						<input type="hidden" id="mr-staff" name="mat_staff" value="">
						<h3 class="text-danger">Why are you releasing this material from hold?</h3>
						<fieldset class="form-group col-12 d-inline">
							<textarea class="form-control-lg w-100" rows="4" id="mr-release_reason" name="mat_release_reason"></textarea>
						</fieldset>
					</form>
					<div id="mat_releaseBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="mat_release()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>