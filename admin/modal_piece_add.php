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
									<select class="mdb-select md-form colorful-select dropdown-primary" id="shape" name="shape">
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
											<input class="form-control" type="number" id="SqFt" name="SqFt">
										</fieldset>
									</div>
								</div>
							
							</div>





							<hr class="w-100">
							<div class="container">
								<div class="row">
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<div class="col-7">
												<label class=""><u>Edging</u></label>
												<select class="mdb-select md-form colorful-select dropdown-primary " id="piece_edge" name="piece_edge">
									<?
	$get_accs = new project_action;
	$rows = $get_accs->get_edges();
	foreach ($rows as $row) {
		echo "<option value='" . $row['id'] . "' price='" . $row['edge_price'] . "' data-icon='https://amanziportal.com/images/SVG/" . $row['edge_img'] . "'>" . $row['edge_name'] . "</option>";
	}
									?>
												</select>
											</div>
											<div class="col-5">
												<label class="">Length: </label>
												<input class="form-control" id="edge_length" name="edge_length" value="0">
											</div>
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

