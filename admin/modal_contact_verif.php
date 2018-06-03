<div aria-hidden="true" aria-labelledby="contact_verificationLabel" class="modal fade" id="contact_verif" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-phone-square h2 text-warning"></i> Has the customer confirmed the <span id="verif_type"></span>? - <span id="verif_date"></span> : <span id="verif_time"></span></h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">Job: <span id="verif_customer"></span></h2>
						<h3 class="col-6">Phone: <span id="verif_phone"></span></h3>
						<h3 class="col-6">Email: <span id="verif_email"></span></h3>
					</div>
					<form id="customer_verif" class="row">
						<input name="action" type="hidden" value="customer_verif"> <input name="cmt_ref_id" type="hidden" value="">
						<fieldset class="form-group col-12">
							<div class="row">
								<legend class="col-form-legend col-12">Job Type:</legend>
								<div class="form-check col-4">
									<input checked class="form-check-input with-gap ml-4" id="not_confirmed" name="type" type="radio" value="0">
									<label class="w-100" for="not_confirmed">Not Conformed</label>
									<p class="d-inline ml-4"></p>
								</div>
								<div class="form-check col-4">
									<input class="form-check-input with-gap ml-4" id="confirmed" name="type" type="radio" value="1">
									<label class="w-100" for="confirmed">Confirmed</label>
								</div>
								<div class="form-check col-4">
									<input class="form-check-input with-gap ml-4" id="reschedule" name="type" type="radio" value="2">
									<label class="w-100" for="reschedule">To be Rescheduled</label>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-12">
							<label class="w-100" for="confirm_notes">Notes:</label> 
							<textarea class="form-control" id="confirm_notes" name="confirm_notes" rows="4"></textarea>
						</fieldset>
					</form>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>