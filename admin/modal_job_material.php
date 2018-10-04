<div class="modal fade" id="inv_request" tabindex="-1" role="dialog" aria-labelledby="inv_requestLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i> Request Inventory</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="inventory_request">
						<input type="hidden" name="action" value="inventory_request">
						<input type="hidden" id="sm-tie_uid" name="tie_uid" value="<?= $_SESSION['id'] ?>">
						<input type="hidden" id="sm-tie_status" name="tie_status" value="1">
						<input type="hidden" id="sm-sink_provided" name="sink_provided" value="0">
						<input type="hidden" id="sm-sink_price" name="sink_price" value="0.00">
						<input type="hidden" id="sm-cutout_price" name="cutout_price" value="0.00">
						<div class="row select_type">
							<h3 class="text-danger pr-4">What type of inventory are you adding?</h3>
							<select class="mdb-select md-form colorful-select dropdown-primary" id="sm-select_type" onChange="select_category_type(this.value)">
								<option value="" disabled selected>Choose inventory type</option>
<?
	$get_inv_types = new materials_action;
	$rows = $get_inv_types->get_inv_types();
	foreach ($rows as $row) {
		echo "<option value='" . $row['type_id'] . "' >" . $row['type_name'] . "</option>";
	}
?>
							</select>
						</div>
						<div class="row inv_row select_cat" style="display: none">
							<fieldset class="col-md-3">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Qty:</span>
									</div>
									<input type="number" class="form-control" aria-label="Quantity" id="sm-tie_qty" name="tie_qty" value="1">
								</div>
							</fieldset>
							<fieldset class="col-md-9">
								<select class="mdb-select md-form colorful-select dropdown-primary" onChange="get_mats_available(this.value)" id="sm-select_cat" name="tie_category" searchable="Search here..">
								</select>
							</fieldset>
							<hr>
						</div>
						<div class="row inv_row select_options" style="">
							<div class="select_opt_mat" style="display: none">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="sm-stock" name="mat_type_needed" value="in_stock" onClick="invOptions(this.value)">
									<label class="custom-control-label" for="sm-stock">Use/Order Stock Material</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="sm-hold_order" name="mat_type_needed" value="in_hold" onClick="invOptions(this.value)">
									<label class="custom-control-label" for="sm-hold_order">Hold Order?</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="sm-selected" name="mat_type_needed" value="in_select" onClick="invOptions(this.value)">
									<label class="custom-control-label" for="sm-selected">Customer Selected?</label>
								</div>
							</div>
							<div class="select_opt_sink col" style="display: none">
								<table class="table table-sm table-bordered">
									<tr><th>Amanzi Provided</th><th>Customer Provided</th></tr>
									<tr>
										<td>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="sm-soldby" name="sinkOptions" value="amanzi_sink" onClick="sinkOptions(this.value)">
												<label class="custom-control-label" for="sm-soldby">Sold by Amanzi</label>
											</div>
										</td>
										<td>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="sm-sink_pickup" name="sinkOptions" value="sink_pickup" onClick="sinkOptions(this.value)">
												<label class="custom-control-label" for="sm-sink_pickup">Pick Up on Template</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="sm-sink_onsite" name="sinkOptions" value="sink_onsite" onClick="sinkOptions(this.value)">
												<label class="custom-control-label" for="sm-sink_onsite">Stays on Location</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="sm-sink_to_us" name="sinkOptions" value="sink_to_us" onClick="sinkOptions(this.value)">
												<label class="custom-control-label" for="sm-sink_to_us">Delivery to Amanzi</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
												<input type="checkbox" class="filled-in form-check-input form-control" id="sm-delivery" name="delivery" value="1">
												<label for="sm-delivery" class="w-100"><u>Delivery Only</u></label>
										</td>
										<td>
											<div class="row px-3">
												<label for="sm-sink_location col"><u>Sink Location</u>:</label>
												<input type="text" class="form-control col" id="sm-sink_location" name="sink_location">
											</div>
										</td>
									</tr>
								</table>
								<hr>
								<div class="row">

									<div class=" col-6 d-inline">
										<label for="sm-sink_part"><u>To which piece does the sink belong</u>: </label>
										<select class="mdb-select md-form colorful-select dropdown-primary" id="sm-sink_part" name="sink_part"></select>
									</div>
									<div class="col-3 d-inline">
										<label for="sm-sink_mount"><u>Cutout</u>: </label>
										<select class="mdb-select md-form colorful-select dropdown-primary" id="sm-sink_mount" name="sink_mount">
											<option value="0">None</option>
											<option value="1">Undermount</option>
											<option value="2">Drop-In</option>
											<option value="3">Vessel</option>
											<option value="4">Apron/Farm Style</option>
											<option value="5">Top Zero</option>
										</select>
									</div>
									<fieldset class="form-group col-2 d-inline">
										<input type="checkbox" class="filled-in form-check-input form-control" id="sm-sink_soap" name="sink_soap" value="1">
										<label for="sm-sink_soap"><u>Soap Hole</u>?</label>
									</fieldset>
									<fieldset class="form-group col-3 d-inline">
										<label for="sm-sink_holes"><u>Faucet Spread / Holes</u>:</label>
										<select class="mdb-select md-form colorful-select dropdown-primary holeOpt" id="sm-sink_holes" name="sink_holes">
											<option value="0">None</option>
											<option value="1">1 Hole - Center</option>
											<option value="2">3 Hole - 4"</option>
											<option value="3">3 Hole - 8"</option>
											<option class="controller" data-control="sink_holes_other" value="99">Other Holes</option>
										</select>
									</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sm-sink_holes_other"><u>Sink Holes Data</u>:</label>
									<input type="text" class="form-control" id="sm-sink_holes_other" name="sink_holes_other">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="sm-cutout_width"><u>Cutout Width</u>:</label>
									<input type="text" class="form-control" id="sm-cutout_width" name="cutout_width" value="0">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="sm-cutout_depth"><u>Cutout Depth</u>:</label>
									<input type="text" class="form-control" id="sm-cutout_depth" name="cutout_depth" value="0">
								</fieldset>

								</div>
							</div>
							<div class="select_opt_accs" style="display: none">
							</div>
							<hr>
						</div>
						<div class="row inv_row select_stock" style="display: none">
							<p id="stock_count">There are ?? Available in Stock</p> 
						</div>
						<div class="row inv_row select_hold" style="display: none">
							<select class="mdb-select md-form col colorful-select dropdown-primary" id="sm-tie_supplier" name="tie_supplier" searchable="Search here..">
								<option value="" disabled selected>Choose Supplier</option>
								<option value="0">Other Supplier/Not Listed</option>
<?
	$get_suppliers = new materials_action;
	$rows = $get_suppliers->get_suppliers();
	foreach ($rows as $row) {
		echo "<option value='" . $row['id'] . "'>" . $row['company'] . "</option>";
	}
?>
							</select>
							<input class="form-control col" placeholder="Reference..." type="text" id="sm-tie_hold" name="tie_hold">
						</div>
						<div class="row inv_row selected_item" style="display: none">
							<select class="mdb-select md-form colorful-select dropdown-primary w-100" id="sm-tie_item_id" name="tie_item_id" onChange="showImage($('#sm-tie_item_id option:selected').data('icon'))" searchable="Search here..">
							</select>
						</div>
						<div class="row" id="item_image"></div>
						<hr>
						<div class="row inv_row selected_notes">
							<label for="sm-tie_notes">Notes on request</label>
							<textarea class="form-control" id="sm-tie_notes" name="tie_notes" rows="3"></textarea>
						</div>
					</form>
					<div id="tie_matBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="tie_mat()">Submit</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>