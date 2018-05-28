			<div class="col-12" style="margin-left:0">
                <div id="marbgran-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Quartz</h1>
						<div class="btn btn-primary col-2 mx-0" onClick="$('#materialAddQuartz').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>

                    <div id="user-block" class="content">
						<div class="col-12" id="tableResults">
							<table class="table table-striped table-hover table-sm">
								<thead class="mdb-color darken-3 text-white" style="position: sticky">
									<tr>
										<th scope="col">id</th>
										<th scope="col">Name</th>
										<th class="text-left" scope="col">Category</th>
										<th class="text-center" scope="col">Price p/SqFt</th>
										<th class="text-center" scope="col">Slab Cost</th>
										<th class="text-center" scope="col">Slab SqFt</th>
										<th class="text-center" scope="col">Slab Height</th>
										<th class="text-center" scope="col">Slab Width</th>
										<th class="text-center" scope="col">Edit</th>
										<th class="text-center" scope="col">Delete</th>
									</tr>
								</thead>
								<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
									<tr>
										<th scope="col">id</th>
										<th scope="col">Name</th>
										<th class="text-left" scope="col">Category</th>
										<th class="text-center" scope="col">Price p/SqFt</th>
										<th class="text-center" scope="col">Slab Cost</th>
										<th class="text-center" scope="col">Slab SqFt</th>
										<th class="text-center" scope="col">Slab Height</th>
										<th class="text-center" scope="col">Slab Width</th>
										<th class="text-center" scope="col">Edit</th>
										<th class="text-center" scope="col">Delete</th>
									</tr>
								</tfoot>
<?
	$quartz = '';
	$get_quartz = new project_action;
	foreach($get_quartz->get_quartz() as $results) {
		if ($results['price_3'] <= 1) {
			$results['price_3'] = "'NA'";
		}
		$editString = $results['id'] . ",'" . $results['name'] . "'," . $results['cat_id'] . ',' . $results['price_3'] . ',' . $results['slab_cost'] . ',' . $results['slab_sqft'] . ',' . $results['quartz_height'] . ',' . $results['quartz_width'] . ",'" . $results['notes'] . "'";
?>
								<tr class="filter">
									<td class="text-center"><?= $results['id'] ?></td>
									<td><?= $results['name'] ?></td>
									<td class="text-left"><?= $results['cat_id'] ?> - <?= $results['brand'] ?>-<?= $results['class'] ?>-<?= $results['group'] ?></td>
									<td class="text-center"><?= $results['price_3'] ?></td>
									<td class="text-center"><?= $results['slab_cost'] ?></td>
									<td class="text-center"><?= $results['slab_sqft'] ?></td>
									<td class="text-center"><?= $results['quartz_height'] ?></td>
									<td class="text-center"><?= $results['quartz_width'] ?></td>
									<td class="text-center btn-sm btn-primary m-0" onClick="editQuartzModal(<?= $editString ?>)"><i class="fas fa-wrench"></i></td>
									<td class="text-center btn-sm btn-danger m-0" onClick="delete_quartz(<?= $results['id'] ?>)"><i class="fas fa-trash"></i></td>
								</tr>
		<?
	}
	echo $quartz;
?>

							</table>
						</div>
           			</div>
					<div class="row mb-5 pt-5 d-flex" style="position: sticky; top: 0 text-right align-right">
						<div class="btn btn-primary col-2 mx-0 float-right" onClick="$('#materialAddMarble').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>
				</div>
			</div>
