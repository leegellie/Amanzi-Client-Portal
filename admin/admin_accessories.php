<div class="col-12" style="margin-left:0">
	<div id="user-data" class="col-12">
		<div class="row mb-3 pt-3" style="position: sticky; top: 0">
			<h1 class="text-primary col-10">Sinks, Faucets &amp; Accessories</h1>
			<div class="btn btn-primary col-2 mx-0" onClick="addAccs()"><i class="fas fa-plus"></i> Add</div>
		</div>
		<hr>
		<div id="user-block" class="content">
			<div class="col-12" id="tableResults">
				<table class="table table-striped table-hover table-sm">
					<thead class="mdb-color darken-3 text-white" style="position: sticky">
						<tr>
							<th scope="col">id</th>
							<th class="text-center" scope="col">Type</th>
							<th scope="col">Model</th>
							<th scope="col">Name</th>
							<th class="text-center" scope="col">Cost</th>
							<th class="text-center" scope="col">Price</th>
							<th class="text-center" scope="col">Available</th>
							<th class="text-center" scope="col">Width</th>
							<th class="text-center" scope="col">Depth</th>
							<th class="text-center" scope="col">Edit</th>
							<th class="text-center" scope="col">Delete</th>
						</tr>
					</thead>
					<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
						<tr>
							<th class="text-center" scope="col">id</th>
							<th class="text-center" scope="col">Type</th>
							<th class="text-center" scope="col">Model</th>
							<th scope="col">Name</th>
							<th class="text-right" scope="col">Cost</th>
							<th class="text-right" scope="col">Price</th>
							<th class="text-center" scope="col">Available</th>
							<th class="text-center" scope="col">Width</th>
							<th class="text-center" scope="col">Depth</th>
							<th class="text-center" scope="col">Edit</th>
							<th class="text-center" scope="col">Delete</th>
						</tr>
					</tfoot>
					<tbody>
<?
	$accs = '';
	$get_accs = new project_action;
	foreach($get_accs->get_all_accs() as $results) {
		$editString = $results['accs_name'] . "::" . $results['accs_id'] . "::" . $results['accs_code'] . "::" . $results['accs_model'] . "::" . $results['accs_cost'] . '::' . $results['accs_price'] . '::' . $results['accs_status'] . '::' . $results['accs_width'] . '::' . $results['accs_depth'] . '::' . $results['accs_count'];
		$sendString = htmlentities($editString);
		?>
					<tr class="filter">
						<td class="text-center"><?= $results['accs_id'] ?></td>
						<td>
							<?
							if ($results['accs_code'] == 1) {
								echo "Sink";
							} elseif ($results['accs_code'] == 2) {
								echo "Faucet";
							} else {
								echo "Accessory";
							}
							?>
						</td>
						<td class="text-center"><?= $results['accs_model'] ?></td>
						<td><?= $results['accs_name'] ?></td>
						<td class="text-right"><?= $results['accs_cost'] ?></td>
						<td class="text-right"><?= $results['accs_price'] ?></td>
						<td class="text-center">
							<?
							if ($results['accs_status'] == 1) {
								echo "Yes";
							} else {
								echo "No";
							}
							?>
						</td>
						<td class="text-center"><?= $results['accs_width'] ?></td>
						<td class="text-center"><?= $results['accs_depth'] ?></td>
						<td><div class="text-center btn-sm btn-primary m-0" onClick="editAccsModal('<?= $sendString ?>')"><i class="fas fa-wrench"></i></div></td>
						<td><div class="text-center btn-sm btn-danger m-0" onClick="delete_accessory(<?= $results['accs_id'] ?>)"><i class="fas fa-trash"></i></div></td>
					</tr>
		<?
	}
	echo $accs;
?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row mb-5 pt-5 d-flex" style="position: sticky; top: 0 text-right align-right">
			<div class="btn btn-primary col-2 mx-0 float-right" onClick="addAccs()"><i class="fas fa-plus"></i> Add</div>
		</div>

	</div>
</div>

<div aria-hidden="true" aria-labelledby="addAccsLabel" class="modal fade" id="addAccs" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-plus h2 text-success"></i> Add/Edit Accessory</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row" id="edit-text" style="display: none">
						<h2 class="col-12">Edit: <span class="text-primary" id="accsName"></span></h2>
					</div>
					<hr>
					<form id="add_accs" class=" row">
						<input type="hidden" id="action" name="action" value="">
						<input type="hidden" id="accs_id" name="accs_id" value="0">
						<input type="hidden" id="accs_count" name="accs_count" value="0">
						<label class="col-12 mb-3" for="accs_name">Accessory Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="accs_name" name="accs_name">
						<fieldset class="form-group col-4 col-md-2">
							<input class="filled-in form-check-input" id="accs_status" name="accs_status" type="checkbox" value="1">
							<label for="accs_status">Available?</label>
						</fieldset>
						<fieldset class="form-group col-2">
							<div class="row">
								<label class="col-6 mb-3" for="accs_count">Count:</label>
								<input class="col-6 mb-3 form-control" id="accs_count" name="accs_count" type="number" value="0">
							</div>
						</fieldset>
						<fieldset class="form-group col-2">
							<select class="mdb-select md-form colorful-select dropdown-primary" id="accs_code" name="accs_code" type="text" data-required="true">
								<option>Select...</option>
								<option value="1">Sink</option>
								<option value="2">Faucet</option>
								<option value="3">Other</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-6">
							<div class="row">
								<label class="col-2 mb-3" for="accs_model">Model:</label>
								<input class="col-10 mb-3 form-control" id="accs_model" name="accs_model" type="text" value="0">
							</div>
						</fieldset>
						<label class="col-1 mb-3" for="accs_cost">Cost:</label>
						<input class="col-2 mb-3 form-control" id="accs_cost" name="accs_cost" type="number" value="0.00">
						<label class="col-1 mb-3" for="accs_price">Price:</label>
						<input class="col-2 mb-3 form-control" id="accs_price" name="accs_price" type="number" value="0.00">
						<label class="col-2 mb-3" for="accs_width">Cutout Width:</label>
						<input class="col-1 mb-3 form-control" id="accs_width" name="accs_width" type="number" value="0">
						<label class="col-2 mb-3" for="accs_depth">Cutout Depth:</label>
						<input class="col-1 mb-3 form-control" id="accs_depth" name="accs_depth" type="number" value="0">

						<div class="btn btn-primary col-12" id="addAccsBtn" onClick="update_accs()">Update</div>
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
