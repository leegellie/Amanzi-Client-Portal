<div class="modal fade" id="approval_reject" tabindex="-1" role="dialog" aria-labelledby="approval_rejectLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Reject Approval Request</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="approval_reject_form row">
						<input type="hidden" name="action" value="approval_reject">
						<input type="hidden" id="ar-pid" name="pid" value="">
						<input type="hidden" id="ar-staff" name="staff" value="">
						<input type="hidden" id="ar-status" name="status" value="">
						<h3 class="text-danger">Why are you rejecting this job?</h3>
						<fieldset class="form-group col-12 d-inline">
							<textarea class="form-control-lg w-100" rows="4" id="ar-reject_reason" name="reject_reason"></textarea>
						</fieldset>
					</form>
					<div id="approval_rejectBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="approval_reject()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>