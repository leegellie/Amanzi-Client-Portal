<div class="modal fade" id="add_accs" tabindex="-1" role="dialog" aria-labelledby="add_accsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  Add Accessory</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="add_accs" class="row">
						<input type="hidden" name="action" value="add_accs">
						<input type="hidden" id="f-sink_iid" name="sink_iid" value="">
						<input type="hidden" id="f-faucet_price" name="faucet_price" value="">
						<fieldset class="form-group col-6 d-inline">
							<label for="sink_part"><u>To which piece does the accessory belong</u>: </label>
							<select class="mdb-select md-form colorful-select dropdown-primary" id="f-sink_part" name="sink_part">
							</select>
						</fieldset>
						<fieldset class="form-group col-6 d-inline">
							<label for="sink_provided"><u>Customer provided</u>? </label>
							<select class="mdb-select md-form colorful-select dropdown-primary" id="f-sink_provided" name="sink_provided">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</fieldset>
						<hr class="w-100">
						<fieldset class="form-group col-12 d-inline">
							<label for="sink_faucet"><u>Accessory</u>: </label>
							<div class="input-group">
								<input type="text" list="faucets" class="form-control" id="sink_faucet" name="sink_faucet" autocomplete="off">
								<div class="input-group-append">
									<button type="button" class="btn btn-muted" onClick="$('#sink_faucet').val('')"><i class="fas fa-times"></i></button>
								</div>
							</div>
							<datalist id="faucets">
								<?
								$get_accs = new project_action;
								$rows = $get_accs->get_accs(2);
								foreach ($rows as $row) {
									echo "<option accs_id='" . $row['accs_id'] . "' price='" . $row['accs_price'] . "' cost='" . $row['accs_cost'] . "'>" . $row['accs_model'] . " - " . $row['accs_name'] . "</option>";
								}
								?>
							</datalist>
						</fieldset>
					</form>
					<div id="addAccsBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="add_accs('add_accs')">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>