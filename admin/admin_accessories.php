			<div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Sinks, Faucets &amp; Accessories</h1>
						<div class="btn btn-primary col-2 mx-0" onClick="$('#materialAddAccs').modal('show');"><i class="fas fa-plus"></i> Add</div>
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
										<th class="text-center" scope="col">Count</th>
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
<?
	$marble = '';
	$get_marble = new project_action;
	foreach($get_accs->get_accs() as $results) {
		$editString = $results['accs_id'] . ",'" . $results['accs_code'] . "'," . $results['accs_model'] . "'," . $results['accs_name'] . ',' . $results['accs_cost'] . ',' . $results['accs_price'] . ',' . $results['accs_status'] . ',' . $results['accs_width'] . ',' . $results['accs_depthe'];
?>
								<tr class="filter">
									<td class="text-center"><?= $results['accs_id'] ?></td>
									<td>
										<?
										if ($results['accs_code'] == 1) {
											echo "Sink";
										} elseif ($results['accs_code'] == 2){
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
									<td class="text-center"><?= $results['price_4'] ?></td>
									<td class="text-center"><?= $results['price_5'] ?></td>
									<td class="text-center"><?= $results['price_6'] ?></td>
									<td class="text-center"><?= $results['price_7'] ?></td>
									<td class="text-center btn-sm btn-primary m-0" onClick="editMarbModal(<?= $editString ?>)"><i class="fas fa-wrench"></i></td>
									<td class="text-center btn-sm btn-danger m-0" onClick="delete_marble(<?= $results['id'] ?>)"><i class="fas fa-trash"></i></td>
								</tr>
		<?
	}
	echo $marble;
?>

							</table>
						</div>
           			</div>
					<div class="row mb-5 pt-5 d-flex" style="position: sticky; top: 0 text-right align-right">
						<div class="btn btn-primary col-2 mx-0 float-right" onClick="$('#materialAddMarble').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>

				</div>
			</div>
