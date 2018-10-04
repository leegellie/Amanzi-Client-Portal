<div class="modal fade" id="adjust_material" tabindex="-1" role="dialog" aria-labelledby="adjust_materialLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-wrench text-warning"></i> Adjust Material</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="date_change_form row">
						<input type="hidden" name="action" value="adjust_material">
						<input type="hidden" id="am-pid" name="pid" value="">
						<input type="hidden" id="am-iid" name="iid" value="">
						<input type="hidden" id="am-staff" name="staff" value="">
						<input type="hidden" id="am-adjust_status" name="adjust_status" value="1">
						<div class="col-12 am-where" style="">
							<div class="select_opt_mat row" style="">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="am-order" name="mat_adjust_where" value="1" onClick="ajustOptions(this.value)">
									<label class="custom-control-label" for="am-order">To be Ordered</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="am-ordered" name="mat_adjust_where" value="2" onClick="ajustOptions(this.value)">
									<label class="custom-control-label" for="am-ordered">Ordered</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="am-here" name="mat_adjust_where" value="3" onClick="ajustOptions(this.value)">
									<label class="custom-control-label" for="am-here">Here</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="am-saw" name="mat_adjust_where" value="4" onClick="ajustOptions(this.value)">
									<label class="custom-control-label" for="am-saw">At Saw</label>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<fieldset class="form-group col-md-6">
								<label for="am-lot">Lot</label>
								<input type="text" class="form-control" rows="4" id="am-lot" name="adjust_lot">
							</fieldset>
							<fieldset class="form-group col-md-6">
								<label for="am-location">Location</label>
								<input type="text" class="form-control" rows="4" id="am-location" name="adjust_location">
							</fieldset>
						</div>
					</form>
					<div id="adjust_materialBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="adjust_material()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>