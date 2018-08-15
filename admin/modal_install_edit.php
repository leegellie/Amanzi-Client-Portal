<div class="modal fade" id="editInstall">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="inst_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<form id="updateInstall" class="row">
					<input type="hidden" id="i-iid" name="id" value="">
					<input type="hidden" id="i-pid" name="pid" value="">
					<input type="hidden" id="i-cpSqFt" name="cpSqFt" value="0">
					<input type="hidden" id="i-materials_cost" name="materials_cost" value="0">

					<div class="container">
						<div class="row">
					<fieldset class="form-group col-3">
						<label for="install_room">Room Type:</label>
						<select class="mdb-select" id="i-install_room" name="install_room" type="text" data-required="true">
						<?
							$get_rooms = new project_action;
							$rows = $get_rooms->get_rooms();
							foreach ($rows as $row) {
								echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
							}
						?>
						</select>
					</fieldset>
					<fieldset class="form-group col-9">
						<label for="install1-name">Area/Install Name:</label>
						<input class="form-control" id="i-install_name" name="install_name" type="text" data-required="true" required>
					</fieldset>
					</div>
					</div>

					<div class="container pt-3  border border-light border-right-0 border-left-0 blue lighten-5">
						<div class="row">

					<fieldset class="form-group col-12 col-md-6 col-lg-3">
						<div class="row">
							<legend class="col-form-legend col-12">Job Type:</legend>
							<div class="col-12">
								<div class="form-check form-check-inline col-12">
										<input checked="" class="form-check-input with-gap" id="i-typea" name="type" type="radio" value="New">
									<label for="i-typea">
										<p class="d-inline ml-4">New Install</p>
									</label>
								</div>
								<div class="form-check form-check-inline">
										<input class="form-check-input with-gap" id="i-typeb" name="type" type="radio" value="Remodel">
									<label for="i-typeb">
										<p class="d-inline ml-4">Remodel</p>
									</label>

								</div>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-group col-12 col-md-6 col-lg-3">
						<div class="row">
							<legend class="col-form-legend col-12">Tear Out:</legend>
							<div class="col-12">
								<div class="form-check form-check-inline col-12">
										<input class="form-check-input with-gap" id="i-tear_outa" name="tear_out" type="radio" value="Yes">
									<label for="i-tear_outa">
										<p class="d-inline ml-4">Yes</p>
									</label>
								</div>
								<div class="form-check form-check-inline">
										<input checked="" class="form-check-input with-gap" id="i-tear_outb" name="tear_out" type="radio" value="No">
									<label for="i-tear_outb">
										<p class="d-inline ml-4">No</p>
									</label>
								</div>
							</div>
						</div>
					</fieldset>



					<fieldset class="form-group col-12 col-lg-6">
						<label for="i-material">Material:</label>
						<select class="mdb-select" id="i-material" name="material">
							<option value="0">Not Selected</option>
							<option value="marbgran">Marble/Granite</option>
							<option value="quartz">Quartz/Quartzite</option>
						</select>
					</fieldset>
					</div>
					</div>
					<div class="container pt-3 ">
						<div class="row">
							<div class="col-6">
								<div class="row">
									<fieldset class="form-group col-6 text-left">
										<input class="filled-in mr-4" name="no_mats" id="i-no_mats" type="checkbox" value="1">
										<label for="i-no_mats" class="text-left">No Materials</label>
									</fieldset>
									<fieldset class="form-group col-6 text-left">
										<input id="i-remnant" class="form-check-input filled-in" name="remnant" type="checkbox" value="1">
										<label for="i-remnant" class="w-100">Remnant</label>
									</fieldset>
									<fieldset class="form-group col-12">
										<label for="color">Color:</label>
										<div class="input-group">
											<input class="form-control matControl" list="i-color" id="i-color-box" name="color" type="text" autocomplete="off">
											<div class="input-group-append">
												<span class="input-group-text text-danger" onClick="$('#i-color-box').val('')"><i class="fas fa-times"></i></span>
												<span class="input-group-text text-primary" onClick="matModalOpen(this);"><i class="fa fa-eye"></i></span>
											</div>
											<datalist id="i-color" class="colorChoose"></datalist>
										</div>
									</fieldset>
								</div>
							</div>
							<div class="col-3">
								<div class="row">
									<fieldset class="form-group col-4 col-md-12">
										<label for="lot">Lot #:</label>
										<input class="form-control matControl" id="i-lot" name="lot" type="text">
									</fieldset>
									<fieldset class="form-group col-4 col-md-12">
										<label for="i-tearout_sqft">Tear-out SqFt:</label>
										<input class="form-control matControl" id="i-tearout_sqft" name="tearout_sqft" type="number">
									</fieldset>
								</div>
							</div>
							<div class="col-3">
								<div class="row">
									<fieldset class="form-group col-4 col-lg-6">
										<label for="SqFt">SqFt:</label>
										<input class="form-control matControl px-0 text-center" id="i-SqFt" name="SqFt" type="number" value="0" readonly>
									</fieldset>
									<fieldset class="form-group col-4 col-lg-6">
										<label for="slabs">Slabs:</label>
										<input class="form-control matControl px-0 text-center" id="i-slabs" name="slabs" type="number" value="0">
									</fieldset>
									<fieldset class="form-group col-4 col-lg-12">
										<label for="cpSqFt_override">Overide SqFt Price:</label>
										<input class="form-control matControl px-0 text-center" id="i-cpSqFt_override" name="cpSqFt_override" type="number" value="0">
									</fieldset>
								</div>
							</div>
						</div>
					</div>

					<div class="container matHolder hidden border pt-2">
						<div class="row">
							<div class="col-12 col-md-5">
								<select class="levelFilter mdb-select">
									<option value="0">Filter...</option>
									<option value="1">Level 1</option>
									<option value="2">Level 2</option>
									<option value="3">Level 3</option>
									<option value="4">Level 4</option>
									<option value="5">Level 5</option>
									<option value="6">Level 6</option>
									<option value="7">Level 7</option>
									<option value="8">Level 8</option>
									<option value="9">Specialty</option>
								</select>
							</div>
							<div class="col-12 col-md-5 pt-2">
								<input class="form-control searchMat" placeholder="Search...">
							</div>
							<div class="col-12 col-md-2 pt-1">
								<div class="btn btn-danger btn-sm w-100" onClick="$('.matHolder').addClass('hidden')"><i class="fas fa-times"></i></div>
							</div>
						</div>
						<hr>
						<div class="matSelectCards row"></div>
						<hr>
					</div>



					<div class="container pt-3  border border-light border-right-0 border-left-0 blue lighten-5">
						<div class="row">
							<fieldset class="form-group col-6 col-md-3">
								<div class="row">
									<legend class="col-form-legend col-12">Customer Selected?</legend>
									<div class="col-12">
										<div class="form-check form-check-inline col-6">
											<input class="form-check-input with-gap" id="i-selecteda" name="selected" type="radio" value="Yes">
											<label for="i-selecteda" class="form-check-label">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input with-gap" id="i-selectedb" name="selected" type="radio" value="No">
											<label for="i-selectedb" class="form-check-label">No</label>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-price_calc">Material Price:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-price_calc" name="price_calc" type="number" value="0" readonly>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-accs_prices">Sinks &amp; Faucets Prices:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-accs_prices" name="accs_prices" type="number" value="0" readonly>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-price_extra">Extra Prices:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-price_extra" name="price_extra" type="number" min="0" value="0" oninput="this.value = Math.abs(this.value)">
								</div>
							</fieldset>
						</div>
					</div>

					<div class="container pt-3  ">
						<div class="row">
							<fieldset class="form-group col-3">
								<label for="edge">Default Edge:</label>
								<select class="mdb-select" id="i-edge" name="edge">
<?
	$get_accs = new project_action;
	$rows = $get_accs->get_edges();
	foreach ($rows as $row) {
		echo "<option value='" . $row['id'] . "' price='" . $row['edge_price'] . "'>" . $row['edge_name'] . "</option>";
	}
?>
								</select>
							</fieldset>
							<fieldset class="form-group col-3">
								<label for="range_type">Range Type:</label>
								<select class="mdb-select" id="i-range_type" name="range_type">
									<option value="0">None</option>
									<option value="1">Free Standing</option>
									<option value="2">Cooktop</option>
									<option value="3">Slide-In</option>
								</select>
							</fieldset>
							<fieldset class="form-group col-md-3">
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="model">Model #:</label>
										<input class="form-control" id="i-range_model" name="range_model" type="text">
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-3">
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="cutout">Cooktop Cutout:</label>
										<input class="form-control" id="i-cutout" name="cutout" type="text">
									</fieldset>
								</div>
							</fieldset>
						</div>
					</div>

					<div class="container pt-3  border border-light border-right-0 border-left-0 red lighten-4">
						<div class="row">
							<h3 class="d-inline text-muted w-100 pl-3">To be discontinued</h3>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="backsplash">Backsplash</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right bs_detail" id="i-bs_detail" name="bs_detail" placeholder="Details" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="riser">Riser</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right rs_detail" id="i-rs_detail" name="rs_detail" placeholder="Details" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="sinks">Sinks</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right sk_detail" id="i-sk_detail" name="sk_detail" placeholder="Details/Model" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<div class="form-group col-12">
										<label for="holes">Faucet Spread / Holes:</label>
										<select class="mdb-select holeOpt" id="i-holes" name="holes" readonly>
											<option value="0">None</option>
											<option disabled value="1">1 Hole - Center</option>
											<option disabled value="2">3 Hole - 4"</option>
											<option disabled value="3">3 Hole - 8"</option>
											<option disabled class="controller" data-control="holes_other" value="99">Other Holes</option>
										</select>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<div class="form-group col-12">
										<label for="holes">Specify other holes needed:</label>
										<input class="form-control" id="i-holes_other" name="holes_other" type="text" readonly>
									</div>
								</div>
							</fieldset>
						</div>
					</div>

					<fieldset class="form-group col-12">
						<label for="install_notes">Install Notes:</label>
						<textarea class="form-control" id="i-install_notes" name="install_notes" rows="3"></textarea>
					</fieldset>
					<fieldset class="form-group container">
						<label id="uploadContain2" class="row" for="imgUploads">
							<input class="col-6 mb-2" onChange="addUpload(this);" name="imgUploads[]" type="file">
						</label>
					</fieldset>
					<input id="isActive" name="isActive" type="hidden" value="1">
					<input id="i-instUID" name="instUID" type="hidden" value="">
					<input id="i-action" name="action" type="hidden" value="update_install_data"><br>
					<div class="btn btn-primary" name="instUpdate" id="instUpdate" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Update Install</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
