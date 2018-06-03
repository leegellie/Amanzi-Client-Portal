<div class="modal fade" id="add_piece" tabindex="-1" role="dialog" aria-labelledby="locationLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  <span id="piece_title">Add Pieces</span></h2> <div class="btn btn-circle btn-warning ml-2" onClick="$('#shape_info').modal('show')"><i class="fas fa-info"></i></div></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="add_piece">
							<input type="hidden" name="action" value="add_piece">
							<input type="hidden" id="piece_id" name="piece_id" value="0">
							<input type="hidden" id="iid" name="iid" value="">
							<input type="hidden" id="pid" name="pid" value="">
							<input type="hidden" id="pcPriceExtra" name="price_extra" value="">
							<input type="hidden" id="pcSqFt" name="cpSqFt" value="">
							<input type="hidden" name="piece_active" value="1">
							<div class="row">
								<fieldset class="form-group col-12 d-inline">
									<label>Name: </label>
									<input class="form-control" id="piece_name" name="piece_name">
								</fieldset>
		<!--
								<fieldset class="form-group form-check col-2 text-right d-inline">
									<label for="piece_active" class="pr-4">Is active?</label>
									<input id="piece_active" class="form-check-input with-font" name="piece_active" type="checkbox" value="1" checked>
								</fieldset>
		-->

								<fieldset class="form-group col-3 d-inline">
									<label>Shape: </label>
									<select class="mdb-select" id="shape" name="shape">
										<option value="1">Rectangle</option>
										<option value="2">L-Shape</option>
										<option value="3" disabled>Beveled L</option>
										<option value="1">Odd Shape</option>
										<option value="4">SqFt</option>
									</select>
								</fieldset>
								<div class="col-2 rect_shape">
									<div class="row">
										<fieldset class="form-group col-6 d-inline-block">
											<label class="">x: </label>
											<input class="form-control" id="size_x" name="size_x">
										</fieldset>
										<fieldset class="form-group col-6 d-inline-block">
											<label class="">y: </label>
											<input class="form-control" id="size_y" name="size_y">
										</fieldset>
									</div>
								</div>
								<div class="col-6 rect_shape">
									<div class="row">
										<img class="col-6" src="../images/shape-Rect.jpg">
										<img class="col-6" src="../images/shape-Odd.jpg">
									</div>
								</div>



								<div class="col-6 l_shape d-none">
									<div class="row">
										<fieldset class="form-group col-2">
											<label class="">a: </label>
											<input class="form-control cInside cOutside" id="size_a" name="size_a">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">b: </label>
											<input class="form-control cInside" id="size_b" name="size_b">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">c: </label>
											<input class="form-control cInside" id="size_c" name="size_c">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">d: </label>
											<input class="form-control cVariable" id="size_d" name="size_d">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">e: </label>
											<input class="form-control cOutside" id="size_e" name="size_e">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">f: </label>
											<input class="form-control cOutside" id="size_f" name="size_f">
										</fieldset>
										<div class="btn btn-primary calcOutside col-6" onClick="calcOutside()">Calculate From Outside</div>
										<div class="btn btn-primary calcInside col-6" onClick="calcInside()">Calculate From Inside</div>
									</div>
								</div>
								<div class="col-3 l_shape d-none">
									<img class="w-100" src="../images/shape-L2.jpg">
								</div>

								<div class="col-6 bevel_shape d-none">
									<div class="row">
									</div>
								</div>
								<div class="col-3 bevel_shape d-none">
									<img class="w-100" src="../images/shape-L2.jpg">
								</div>

								<div class="col-2 sqft_shape d-none">
									<div class="row">
										<fieldset class="form-group col-12 d-inline-block">
											<label class="">SqFt: </label>
											<input class="form-control type="number" id="SqFt" name="SqFt">
										</fieldset>
									</div>
								</div>
							
							</div>





							<hr class="w-100">
							<div class="container">
								<div class="row">
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Edging</u></label>
											<select class="mdb-select col-6" id="piece_edge" name="piece_edge">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_edges();
										foreach ($rows as $row) {
											echo "<option value='" . $row['id'] . "' price='" . $row['edge_price'] . "'>" . $row['edge_name'] . "</option>";
										}
									?>
											</select>
											<label class="col-3">Length: </label>
											<input class="form-control col-3" id="edge_length" name="edge_length" value="0">
										</div>
									</fieldset>
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Backsplash</u></label>
											<label class="col-3">Height: </label>
											<input class="form-control col-3" id="bs_height" name="bs_height" value="0">
											<label class="col-3">Length: </label>
											<input class="form-control col-3" id="bs_length" name="bs_length" value="0">
										</div>
									</fieldset>
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Riser</u></label>
											<label class="col-3">Height: </label>
											<input class="col-3 form-control" id="rs_height" name="rs_height" value="0">
											<label class="col-3">Length: </label>
											<input class="col-3 form-control" id="rs_length" name="rs_length" value="0">
										</div>
									</fieldset>
								</div>
							</div>
						</form>
						<div class="btn btn-lg btn-primary mt-3 w-100" onClick="addPiece('add_piece')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="shape_info" tabindex="-1" role="dialog" aria-labelledby="locationLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-info h2 text-warning"></i>  Entering Shapes</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<h2>Recatanguar Shapes</h2>
					<p>Rectangular shapes just need to have the width (<em>x</em>) and depth/height (<em>y</em>) entered. The square footage will be calculated from this.</p>
					<div class="w-100 text-center"><img src="../images/shape-Rect.jpg" width="300" height="250"></div>
					<hr>
					<h2>L Shapes</h2>
					<p>L-shaped pieces need to have all sides entered. See lableing in diagram A for each shape. If piece has beveled angles inside or on the back side of the L-shape, you must include the distance of this bevel in the dimensions. See diagram B.</p>
					<p>The length of <em><strong>a</strong></em> and <em><strong>c</strong></em> will be matched against <em><strong>e</strong></em> and the lenght of <em><strong>b</strong></em> and <em><strong>d</strong></em> will be matched against <em><strong>f</strong></em> to ensure there are no errors in the calculations.</p>
					<div class="w-100 text-center"><img src="../images/shape-L.jpg" width="300" height="250"><img src="../images/shape-L2.jpg" width="300" height="250"></div>

					<hr>
					<h2>Odd Shapes</h2>
					<p>Odd shapes that do not easily fall into the other 2 categories will just need the overall width (<em>x</em>) and overall depth/height (<em>y</em>) as cut off remainders are not usable remnants.</p>
					<div class="w-100 text-center"><img src="../images/shape-Odd.jpg" width="300" height="250"></div>
					<hr>
					<h2>Wrap Around Pieces</h2>
					<p>Pieces that are larger and will wrap around an area will classify as an "Odd Shape" unless it will need two slabs and then the piece can be divided into 2 or more "L-Shapes" and "Rectangle" shapes at your discression. It is not of vital importance that the seem would be in the correct place, this is just for calculating the square footage.</p>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_sink" tabindex="-1" role="dialog" aria-labelledby="add_sinkLabel" aria-hidden="true">
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
						<form id="add_sink">
							<input type="hidden" name="action" value="add_sink">
							<input type="hidden" id="sink_iid" name="sink_iid" value="">
							<input type="hidden" id="sink_price" name="sink_price" value="">
							<input type="hidden" id="faucet_price" name="faucet_price" value="">
							<input type="hidden" id="cutout_price" name="cutout_price" value="">

							<div class="row">
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_part"><u>To which piece does the sink belong</u>: </label>
									<select class="mdb-select" id="sink_part" name="sink_part">
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_provided"><u>Customer provided</u>? </label>
									<select class="mdb-select" id="sink_provided" name="sink_provided">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-5 d-inline">
									<label for="sink_faucet"><u>Faucet</u>: </label>
                                    <div class="input-group">
										<input type="text" list="faucets" class="form-control" id="sink_faucet" name="sink_faucet">
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
							</div>

							<hr class="w-100">
							<div class="row">
<!--								<fieldset class="form-group col-3 d-inline">
									<label for="sink_style"><u>Sink Type</u>: </label>
									<select class="mdb-select" id="sink_style" name="sink_style">
										<option value="None">None</option>
										<option value="Drop-In">Drop-In</option>
										<option value="Undermount">Undermount</option>
										<option value="Vessel">Vessel</option>
										<option value="Apron/Farm Style">Apron/Farm Style</option>
										<option value="Top Zero">Top Zero</option>
									</select>
								</fieldset>
-->								<fieldset class="form-group col-9 d-inline">
									<label for="sink_model"><u>Sink Model</u>: </label>
                                    <div class="input-group">
										<input class="form-control" list="sinks" type="text" id="sink_model" name="sink_model">
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
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_mount"><u>Cutout</u>: </label>
									<select class="mdb-select" id="sink_mount" name="sink_mount">
										<option value="0">None</option>
										<option value="1">Undermount</option>
										<option value="2">Drop-In</option>
										<option value="3">Vessel</option>
										<option value="4">Apron/Farm Style</option>
										<option value="5">Top Zero</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes"><u>Faucet Spread / Holes</u>:</label>
									<select class="mdb-select holeOpt" id="sink_holes" name="sink_holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="sink_holes_other" value="99">Other Holes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes_other"><u>Sink Holes Data</u>:</label>
									<input type="text" class="form-control" id="sink_holes_other" name="sink_holes_other">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<input type="checkbox" class="filled-in form-control" id="sink_soap" name="sink_soap" value="1">
									<label for="sink_soap"><u>Soap Hole</u>?</label>
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_width"><u>Cutout Width</u>:</label>
									<input type="text" class="form-control" id="cutout_width" name="cutout_width" value="0">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_depth"><u>Cutout Depth</u>:</label>
									<input type="text" class="form-control" id="cutout_depth" name="cutout_depth" value="0">
								</fieldset>
							</div>

						</form>
						<div id="addSinkBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="add_sink('add_sink')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>