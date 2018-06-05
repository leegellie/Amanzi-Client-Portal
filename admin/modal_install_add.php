<div class="modal fade" id="addInstall" tabindex="-1" role="dialog" aria-labelledby="addInstallLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title">Add New Install</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="step2container">
					<div id="user-block" class="content">
						<form id="add_new_step2" class="step2form">
							<input id="instUID" name="instUID" type="hidden" value="">
							<input id="pid" name="pid" type="hidden" value="">
							<input id="cpSqFr" name="cpSqFt" type="hidden" value="0">
							<input id="action" name="action" type="hidden" value="add_install_step2">
							<input type="hidden" id="materials_cost" name="materials_cost" value="0">
							<div class="row">
								<fieldset class="form-group col-3">
									<label for="install_room">Room Type:</label>
									<select class="mdb-select" id="install_room" name="install_room" type="text" data-required="true">
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
									<input class="form-control" id="install_name" name="install_name" type="text" data-required="true" required>
								</fieldset>

								<fieldset class="form-group col-12 col-md-6 col-lg-2">
									<div class="row">
										<legend class="col-form-legend col-12">Job Type:</legend>
										<div class="col-12">
											<div class="form-check form-check-inline col-12">
												<input class="form-check-input with-gap" id="typea" name="type" type="radio" value="New">
												<label for="typea">New Install</label>
											</div>
											<div class="form-check form-check-inline col-12">
												<input class="form-check-input with-gap" id="typeb" name="type" type="radio" value="Remodel">
												<label for="typeb">Remodel</label>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-12 col-md-6 col-lg-2">
									<div class="row">
										<legend class="col-form-legend col-12">Tear Out:</legend>
										<div class="col-12">
											<div class="form-check form-check-inline col-12">
												<input class="form-check-input with-gap" id="tear_outa" name="tear_out" type="radio" value="Yes">
												<label for="tear_outa">Yes</label>
											</div>
											<div class="form-check form-check-inline col-12">
												<input class="form-check-input with-gap" id="tear_outb" name="tear_out" type="radio" value="No">
												<label for="tear_outb">No</label>
											</div>
										</div>
									</div>
								</fieldset>

                                <fieldset class="input-group col-12 col-lg-4">
                                    <label for="material">Material:</label>
                                    <select class="mdb-select" id="material" name="material">
                                        <option value="0">Not Selected</option>
                                        <option value="marbgran">Marble/Granite</option>
                                        <option value="quartz">Quartz/Quartzite</option>
                                    </select>
                                </fieldset>
                                <fieldset class="form-group col-12 col-lg-2">
	                                    <label for="SqFt">SqFt:</label>
    	                                <input class="form-control matControl" id="SqFt" name="SqFt" type="number" value="0" readonly>
                                </fieldset>

								<fieldset class="form-group col-4 col-lg-2">
									<label for="slabs">Slabs:</label>
									<input class="form-control matControl px-0 text-center" id="slabs" name="slabs" type="number" value="0">
								</fieldset>

								<fieldset class="form-group col-4 col-lg-3">
									<label for="tearout_sqft">Tear out SqFt:</label>
									<input class="form-control matControl px-0 text-center" id="tearout_sqft" name="tearout_sqft" type="number" value="0">
								</fieldset>

								<fieldset class="form-group col-6 col-lg-3">
									<label for="price_calc">Material Cost:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
										</div>
										<input class="form-control" id="price_calc" name="price_calc" type="number" value="0" readonly>
									</div>
								</fieldset>

								<fieldset class="form-group col-6 col-lg-3">
									<label for="price_extra">Extra Costs:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
										</div>
										<input class="form-control" id="price_extra" name="price_extra" type="number" value="0">
									</div>
								</fieldset>
								<fieldset class="form-group col-6 col-lg-3">
									<label for="cpSqFt_override">Overide SqFt Cost:</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
										</div>
										<input class="form-control" id="cpSqFt_override" name="cpSqFt_override" type="number" value="0">
									</div>
								</fieldset>


                                <fieldset class="form-group col-12 col-md-6">
									<label for="color">Color:</label>
									<div class="input-group">
										<input class="form-control matControl" list="i-color" id="color-box" name="color" type="text">
										<div class="input-group-append">
											<span class="input-group-text input-group-addon bg-danger" onClick="$('#color-box').val('')"><i class="fas fa-times"></i></span>
										</div>
										<div class="input-group-append">
											<span class="input-group-text input-group-addon matPickerBtn bg-primary" onClick="matModalOpen(this);"><i class="fa fa-eye"></i></span>
										</div>
									</div>
                                </fieldset>
		
								<fieldset class="form-group col-6 col-md-3">
									<label for="lot">Lot #:</label>
									<input class="form-control matControl" id="lot" name="lot" type="text">
								</fieldset>


								<div class="container matHolder hidden">
									<div class="row px-3">
										<select class="levelFilter col-12 col-md-5 mb-3 mdb-select">
											<option class="btn btn-lg btn-dark mx-1 px-4" value="0">Filter...</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="1">Level 1</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="2">Level 2</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="3">Level 3</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="4">Level 4</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="5">Level 5</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="6">Level 6</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="7">Level 7</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="8">Level 8</option>
											<option class="btn btn-lg btn-dark mx-1 px-4" value="9">Specialty</option>
										</select>
										<input class="form-control input-lg searchMat col-12 col-md-5 mb-3" placeholder="Search">
										<div class="btn btn-danger col-2 mb-3" onClick="$('.matHolder').addClass('hidden')"><i class="fas fa-times"></i></div>
									</div>
									<div class="matSelectCards row"></div>
									<hr>
								</div>

								<fieldset class="form-group col-6 col-md-3">
									<div class="row">
										<legend class="col-form-legend col-12">Customer Selected?</legend>
										<div class="col-12">
											<div class="form-check form-check-inline">
												<input class="form-check-input with-gap" id="selecteda" name="selected" type="radio" value="Yes">
												<label for="selecteda">Yes</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input with-gap" id="selectedb" name="selected" type="radio" value="No">
												<label for="selectedb">No</label>
											</div>
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-3">
									<label for="edge">Default Edge:</label>
									<select class="mdb-select" id="edge" name="edge">
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
									<select class="mdb-select" id="range_type" name="range_type">
										<option value="0">None</option>
										<option value="1">Free Standing</option>
										<option value="2">Cooktop</option>
										<option value="3">Slide-In</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3">
									<div class="row">
										<fieldset class="form-group col-12">
											<label for="model">Model #:</label> <input class="form-control" id="range_model" name="range_model" type="text">
										</fieldset>
									</div>
								</fieldset>
								<fieldset class="form-group col-3">
									<div class="row">
										<fieldset class="form-group col-12">
											<label for="cutout">Cooktop Cutout:</label>
											<input class="form-control" id="cutout" name="cutout" type="text">
										</fieldset>
									</div>
								</fieldset>


								<div class="text-muted col-12 mb-3" style="height:0; border-radius:4px;border:2px solid #ccc;background-color: #e8e8e8; overflow:hidden">
									<div class="row" style="height:0;">

										<fieldset class="form-group col-6 col-sm-4">
											<div class="row">
												<legend class="col-form-legend col-12">Backsplash?</legend>
												<div class="col-12">
													<div class="row">
														<div class="form-check form-check-inline w-100">
															<label class="form-check-label container" for="backsplash">
																<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="bs_detail" id="backsplash" name="backsplash" type="checkbox">
																<input class="form-control form-inline col-9 col-lg-10 float-right bs_detail" id="bs_detail" name="bs_detail" placeholder="Details" style="display:none;" type="text">
															</label>
														</div>
													</div>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group col-6 col-sm-4">
											<div class="row">
												<legend class="col-form-legend col-12">Riser?</legend>
												<div class="col-12">
													<div class="row">
														<div class="form-check form-check-inline w-100">
															<label class="form-check-label container" for="riser">
																<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="rs_detail" id="riser" name="riser" type="checkbox">
																<input class="form-control form-inline col-9 col-lg-10 float-right rs_detail" id="rs_detail" name="rs_detail" placeholder="Details" style="display:none;" type="text">
															</label>
														</div>
													</div>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group col-6 col-sm-4">
											<div class="row">
												<legend class="col-form-legend col-12">Sink(s)?</legend>
												<div class="col-12">
													<div class="row">
														<div class="form-check form-check-inline w-100">
															<label class="form-check-label container" for="sinks">
																<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="sk_detail" id="sink" name="sink" type="checkbox">
																<input class="form-control form-inline col-9 col-lg-10 float-right sk_detail" id="sk_detail" name="sk_detail" placeholder="Details/Model" style="display:none;" type="text">
															</label>
														</div>
													</div>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group col-12 col-md-6">
											<div class="row">
												<fieldset class="form-group col-12">
													<label for="model">Model #:</label> <input class="form-control" id="range_model" name="range_model" type="text">
												</fieldset>
											</div>
										</fieldset>
										<fieldset class="form-group col-12 col-md-6">
											<div class="row">
												<div class="form-group col-12">
													<label for="holes">Faucet Spread / Holes:</label>
													<select class="form-control holeOpt" id="holes" name="holes">
														<option value="0">None</option>
														<option value="1">1 Hole - Center</option>
														<option value="2">3 Hole - 4"</option>
														<option value="3">3 Hole - 8"</option>
														<option class="controller" data-control="holes_other" value="Other">Other Holes</option>
													</select>
												</div>
											</div>
											<label for="holes">Specify other holes needed:</label>
											<input class="form-control" id="holes_other" name="holes_other" type="text">
										</fieldset>
									</div>
								</div>

								<fieldset class="form-group col-12">
									<label for="install_notes">Install Notes:</label>
									<textarea class="form-control" id="install_notes" name="install_notes" rows="3"></textarea>
								</fieldset>
								<hr>
							</div>
		

							<fieldset class="form-group container">
								<label id="uploadInstall" class="row" for="imgUploads">
								</label>
							</fieldset>
							<div class="row">
								<div class="col-12">
									<div class="btn btn-lg btn-primary col-12" id="addInstNew">Save Install Details</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>