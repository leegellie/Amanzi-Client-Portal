			<div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Marble &amp; Granite</h1>
						<div class="btn btn-primary col-2 mx-0" onClick="$('#materialAddMarble').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>
					<hr>
                    <div id="user-block" class="content">
						<div class="col-12" id="tableResults">
							<table class="table table-striped table-hover table-sm">
								<thead class="mdb-color darken-3 text-white" style="position: sticky">
									<tr>
										<th scope="col">id</th>
										<th scope="col">Name</th>
										<th class="text-center" scope="col">Amanzi</th>
										<th class="text-center" scope="col">AllStone</th>
										<th class="text-center" scope="col">Bramati</th>
										<th class="text-center" scope="col">Cosmos</th>
										<th class="text-center" scope="col">Marva</th>
										<th class="text-center" scope="col">MSI</th>
										<th class="text-center" scope="col">OHM</th>
										<th class="text-center" scope="col">Stone Basyx</th>
										<th class="text-center" scope="col">Edit</th>
										<th class="text-center" scope="col">Delete</th>
									</tr>
								</thead>
								<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
									<tr>
										<th scope="col">id</th>
										<th scope="col">Name</th>
										<th class="text-center" scope="col">Amanzi</th>
										<th class="text-center" scope="col">AllStone</th>
										<th class="text-center" scope="col">Bramati</th>
										<th class="text-center" scope="col">Cosmos</th>
										<th class="text-center" scope="col">Marva</th>
										<th class="text-center" scope="col">MSI</th>
										<th class="text-center" scope="col">OHM</th>
										<th class="text-center" scope="col">Stone Basyx</th>
										<th class="text-center" scope="col">Edit</th>
										<th class="text-center" scope="col">Delete</th>
									</tr>
								</tfoot>
<?
	$marble = '';
	$get_marble = new project_action;
	foreach($get_marble->get_marble() as $results) {
		$editString = $results['id'] . ",'" . $results['name'] . "'," . $results['price_0'] . ',' . $results['price_1'] . ',' . $results['price_2'] . ',' . $results['price_3'] . ',' . $results['price_4'] . ',' . $results['price_5'] . ',' . $results['price_6'] . ',' . $results['price_7'] . ',' . $results['notes'];
?>
								<tr class="filter">
									<td class="text-center"><?= $results['id'] ?></td>
									<td><?= $results['name'] ?></td>
									<td class="text-center"><?= $results['price_0'] ?></td>
									<td class="text-center"><?= $results['price_1'] ?></td>
									<td class="text-center"><?= $results['price_2'] ?></td>
									<td class="text-center"><?= $results['price_3'] ?></td>
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
