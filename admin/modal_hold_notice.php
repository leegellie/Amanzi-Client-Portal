<div class="modal fade" id="job_hold" tabindex="-1" role="dialog" aria-labelledby="job_holdLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Job Hold</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="job_hold_form col-12">
							<input type="hidden" name="action" value="job_hold">
							<input type="hidden" id="jh-pid" name="pid" value="">
							<input type="hidden" id="jh-staff" name="staff" value="">
							<input type="hidden" id="jh-status" name="status" value="">
							<h3 class="text-danger">Why are you placing this job on hold?</h3>

							<div class="row w-100">
								<fieldset class="form-group col-12 d-inline">
									<input type="textarea" class="form-control-lg w-100" id="jh-hold_reason" name="hold_reason">
								</fieldset>
							</div>

						</form>
						<div id="job_holdBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="job_hold()">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>