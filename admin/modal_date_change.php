<div class="modal fade" id="date_change" tabindex="-1" role="dialog" aria-labelledby="date_changeLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Date Change</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="date_change_form row">
						<input type="hidden" name="action" value="date_change">
						<input type="hidden" id="dc-pid" name="pid" value="">
						<input type="hidden" id="dc-staff" name="staff" value="">
						<h3 class="text-danger">Why are you changing the install date?</h3>
						<fieldset class="form-group col-12 d-inline">
							<textarea class="form-control-lg w-100" rows="4" id="date_change_reason" name="date_change_reason"></textarea>
						</fieldset>
						<label for="dc-install_date">New Install Date <input type="date" name="install_date" id="dc-install_date"></label>
					</form>
					<div id="date_changeBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="date_change()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>