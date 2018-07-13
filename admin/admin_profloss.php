			<div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Profit / Loss</h1>
						<div class="btn btn-primary col-2 mx-0" onClick="$('#materialAddMarble').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>
					<hr>
                    <div id="user-block" class="content">
						<div class="col-12" id="tableResults">
							<table class="table table-striped table-hover compact">
								<thead class="mdb-color darken-3 text-white" style="position: sticky">
									<tr>
										<th scope="col">Quote #</th>
										<th scope="col">Order #</th>
										<th class="" scope="col">Job</th>
										<th class="text-center" scope="col">Install</th>
										<th class="text-right" scope="col">Price</th>
										<th class="text-right" scope="col">Cost</th>
										<th class="text-right" scope="col">Profit</th>
										<th class="text-right" scope="col">Rep</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
									<tr>
										<th scope="col">Quote #</th>
										<th scope="col">Order #</th>
										<th class="" scope="col">Job</th>
										<th class="text-center" scope="col">Install</th>
										<th class="text-right" scope="col">Price</th>
										<th class="text-right" scope="col">Cost</th>
										<th class="text-right" scope="col">Profit</th>
										<th class="text-right" scope="col">Rep</th>
										<th></th>
										<th></th>
									</tr>
								</tfoot>
<?
	$get_profloss = new project_action;
	foreach($get_profloss->get_profloss() as $results) {
?>
								<tr class="filter <? if ($results['profit'] < 0 ) { ?>text-danger<? } ?>">
									<td class="text-center"><?= $results['quote_num'] ?></td>
									<td class="text-center"><?= $results['order_num'] ?></td>
									<td><?= $results['job_name'] ?></td>
									<td class="text-center"><? 
		if ($results['install_date'] != '2200-01-01') { 
			echo $results['install_date'];
		} 
									?></td>
									<td class="text-right"><?= $results['job_price'] ?></td>
									<td class="text-right"><?= $results['costs_job'] ?></td>
									<td class="text-right"><?= $results['profit'] ?></td>
									<td class="text-right"><?= $results['fname'] ?></td>
									<td></td>
									<td class="text-right">
										<a class="btn btn-sm btn-primary" target="_blank" href="https://amanziportal.com/admin/projects.php?edit&pid=<?= $results['id'] ?>&uid=<?= $results['uid'] ?>">
											<i class="fas fa-eye"></i>
										</a>
									</td>
								</tr>
<?
	}
?>

							</table>
						</div>
           			</div>
					<div class="row mb-5 pt-5 d-flex" style="position: sticky; top: 0 text-right align-right">
						<div class="btn btn-primary col-2 mx-0 float-right" onClick="$('#materialAddMarble').modal('show');"><i class="fas fa-plus"></i> Add</div>
					</div>

				</div>
			</div>
