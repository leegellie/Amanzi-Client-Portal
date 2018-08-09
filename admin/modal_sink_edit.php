<div class="modal fade" id="edit_sink" tabindex="-1" role="dialog" aria-labelledby="edit_sinkLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  Add Sink / Cutout</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="edit_sink">
							<input type="hidden" name="action" value="update_sink">
							<input type="hidden" id="e-sink_id" name="sink_id" value="">
							<input type="hidden" id="e-sink_iid" name="sink_iid" value="">
							<input type="hidden" id="e-sink_price" name="sink_price" value="">
							<input type="hidden" id="e-sink_cost" name="sink_cost" value="">
							<input type="hidden" id="e-cutout_price" name="cutout_price" value="">

							<div class="row">
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_part"><u>To which piece does the sink belong</u>: </label>
									<select class="mdb-select" id="e-sink_part" name="sink_part">
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_provided"><u>Customer provided</u>? </label>
									<select class="mdb-select" id="e-sink_provided" name="sink_provided">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</fieldset>
							</div>

							<hr class="w-100">
							<div class="row">
								<fieldset class="form-group col-9 d-inline">
									<label for="sink_model"><u>Sink Model</u>: </label>
                                    <div class="input-group">
										<input class="form-control" list="sinks" type="text" id="e-sink_model" name="sink_model" autocomplete="off">
                                    	<div class="input-group-append">
	                                        <button type="button" class="btn btn-muted" onClick="$('#sink_model').val('')"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
									<datalist id="sinks">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_accs(1);
										foreach ($rows as $row) {
											echo "<option accs_id='" . $row['accs_id'] . "'  width='" . $row['accs_width'] . "'  depth='" . $row['accs_depth'] . "' price='" . $row['accs_price'] . "' cost='" . $row['accs_cost'] . "'>" . $row['accs_model'] . " - " . $row['accs_name'] . "</option>";
										}
									?>
									</datalist>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_mount"><u>Cutout</u>: </label>
									<select class="mdb-select" id="e-sink_mount" name="sink_mount">
										<option value="0">None</option>
										<option value="1">Undermount</option>
										<option value="2">Drop-In</option>
										<option value="3">Vessel</option>
										<option value="4">Apron/Farm Style</option>
										<option value="5">Top Zero</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_holes"><u>Faucet Spread / Holes</u>:</label>
									<select class="mdb-select holeOpt" id="e-sink_holes" name="sink_holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="sink_holes_other" value="99">Other Holes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_holes_other"><u>Sink Holes Data</u>:</label>
									<input type="text" class="form-control" id="e-sink_holes_other" name="sink_holes_other">
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<input type="checkbox" class="filled-in form-control" id="e-sink_soap" name="sink_soap" value="1">
									<label for="e-sink_soap"><u>Soap Hole</u>?</label>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<input type="checkbox" class="filled-in form-control" id="e-sink_onsite" name="sink_onsite" value="1">
									<label for="e-sink_onsite"><u>Sink on Location</u>?</label>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<input type="checkbox" class="filled-in form-control" id="e-sink_pickup" name="sink_pickup" value="1">
									<label for="e-sink_pickup"><u>Templater Pick-up?</u>?</label>
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<label for="cutout_width"><u>Cutout Width</u>:</label>
									<input type="text" class="form-control" id="e-cutout_width" name="cutout_width" value="0">
								</fieldset>
								<fieldset class="form-group col-4 d-inline">
									<label for="cutout_depth"><u>Cutout Depth</u>:</label>
									<input type="text" class="form-control" id="e-cutout_depth" name="cutout_depth" value="0">
								</fieldset>
							</div>

						</form>
						<div id="updateSinkBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="update_sink('edit_sink')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>