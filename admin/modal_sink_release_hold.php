<div class="modal fade" id="sink_release_modal" tabindex="-1" role="dialog" aria-labelledby="sink_release_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Accessory Release Hold</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="sink_release_form row">
						<input type="hidden" name="action" value="sink_release">
						<input type="hidden" id="sr-pid" name="pid" value="">
						<input type="hidden" id="sr-sink_id" name="sink_id" value="">
						<input type="hidden" id="sr-staff" name="sink_staff" value="">
						<h3 class="text-danger">Why are you releasing this accessory from hold?</h3>
						<fieldset class="form-group col-12 d-inline">
							<textarea class="form-control-lg w-100" rows="4" id="sr-release_reason" name="sink_release_reason"></textarea>
						</fieldset>
					</form>
					<div id="sink_releaseBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="sink_release()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>