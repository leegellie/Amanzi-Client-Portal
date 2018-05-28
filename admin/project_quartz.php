<?
$level1r = '';
$level2r = '';
$level3r = '';
$level4r = '';
$level5r = '';
$level6r = '';
$level7r = '';
$level8r = '';
$level9r = '';
$level1b = '';
$level2b = '';
$level3b = '';
$level4b = '';
$level5b = '';
$level6b = '';
$level7b = '';
$level8b = '';
$level9b = '';
$level1c = '';
$level2c = '';
$level3c = '';
$level4c = '';
$level5c = '';
$level6c = '';
$level7c = '';
$level8c = '';
$level9c = '';

?>
<div class="container pageLook">
	<div class="row">

			<div class="col-12 px-0 d-print-none" style="margin-left:0">
                <div id="marbgran-data" class="col-12 px-0">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10 pl-5">Quartz Pricing</h1>
					</div>
					<hr>
                    <div id="user-block" class="content">
						<div class="col-12 table-responsive px-0" id="tableResults">
						<div id="mdb-lightbox-ui"></div>


						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-justified mdb-color darken-3" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#panel_retail" role="tab">Retail</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#panel_builder" role="tab">Builder</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#panel_cabinet" role="tab">Cabinet Company</a>
							</li>
						</ul>
						<!-- Tab panels -->

						<div class="tab-content px-0">
							<!--Panel 1-->
							<div class="tab-pane fade in show active" id="panel_retail" role="tabpanel">
								<div class="w-100 text-right">
									<div class="btn btn-success" onClick="$('.printable').removeClass('d-print-block');$('#printRetail').addClass('d-print-block');window.print();"><i class="fas fa-print"></i> Print</div>
								</div>

								<table class="table table-striped table-hover table-sm mdb-lightbox tableRetail" id="tableRetail">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">From</th>
											<th class="text-center" scope="col">To<sup class="text-danger" data-tooltip="Based on a minimum of 30 SqFt per slab">*</sup></th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">From<sup class="text-danger">*</sup></th>
											<th class="text-center" scope="col">to</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$get_quartz = new project_action;
										foreach($get_quartz->get_quartz() as $results) {
											$slab = intval($results['slab_cost']);
											$sqft = intval($results['slab_sqft']);
											$from = $slab / $sqft;
											$to = ceil((($slab / 30) + 20) * 1.45);
											$price = ceil(($from + 20) * 1.45) ;
											if ($price <= 47.01) {
												$level = 1;
											} elseif ($price < 55.01) {
												$level = 2;
											} elseif ($price < 61.01) {
												$level = 3;
											} elseif ($price < 68.01) {
												$level = 4;
											} elseif ($price < 78.01) {
												$level = 5;
											} elseif ($price < 87.01) {
												$level = 6;
											} elseif ($price < 111.01) {
												$level = 7;
											} elseif ($price < 150.01) {
												$level = 8;
											}  else {
												$level = 9;
											}
											if ( $level === 1 ) {
												$level1r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 2 ) {
												$level2r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 3 ) {
												$level3r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 4 ) {
												$level4r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 5 ) {
												$level5r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 6 ) {
												$level6r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 7 ) {
												$level7r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 8 ) {
												$level8r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}
											if ( $level === 9 ) {
												$level9r .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">From: $' . $price . ' - To: $' . $to . '</span></p><div class="clearfix"></div>';
											}

									?>

									<tr class="filter">
										<td class="text-center align-middle">Level <?= $level ?></td>
										<td class="align-middle"><h4><b><?= $results['name'] ?></b></h4></td>
										<td class="text-center align-middle"><h4>$ <?= $price ?></h4></td>
										<td class="text-center align-middle"><h4>$ <?= $to ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? } else { ?>
										<td class="text-center d-none d-md-block"><img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px"></td>
										<?
										}
										?>
									</tr>
									<?
										}
									?>
								</table>
							</div>
							<div class="tab-pane fade" id="panel_builder" role="tabpanel">
								<div class="w-100 text-right">
									<div class="btn btn-success" onClick="$('.printable').removeClass('d-print-block');$('#printBuilder').addClass('d-print-block');window.print();"><i class="fas fa-print"></i> Print</div>
								</div>
								<table class="table table-striped table-hover table-sm mdb-lightbox tableBuilder" id="tableBuilder">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$get_quartz = new project_action;
										foreach($get_quartz->get_quartz() as $results) {
											$slab = intval($results['slab_cost']);
											$sqft = intval($results['slab_sqft']);
											$from = $slab / $sqft;
											$to = ceil((($slab / 30) + 20) * 1.45);
											$price = ceil(($from + 20) * 1.45) ;
											$newprice = ceil((($price + $to)/2)*.9);
											if ($newprice <= 47.01) {
												$level = 1;
											} elseif ($newprice < 55.01) {
												$level = 2;
											} elseif ($newprice < 61.01) {
												$level = 3;
											} elseif ($newprice < 68.01) {
												$level = 4;
											} elseif ($newprice < 78.01) {
												$level = 5;
											} elseif ($newprice < 87.01) {
												$level = 6;
											} elseif ($newprice < 111.01) {
												$level = 7;
											} elseif ($newprice < 150.01) {
												$level = 8;
											}  else {
												$level = 9;
											}
											if ( $level === 1 ) {
												$level1b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 2 ) {
												$level2b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 3 ) {
												$level3b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 4 ) {
												$level4b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 5 ) {
												$level5b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 6 ) {
												$level6b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 7 ) {
												$level7b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 8 ) {
												$level8b .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 9 ) {
												$level9b .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">$ ' . $newprice . '</span></p><div class="clearfix"></div>';
											}
									?>
									<tr class="filter">
										<td class="text-center align-middle">Level <?= $level ?></td>
										<td class="align-middle"><h4><b><?= $results['name'] ?></b></h4></td>

										<td class="text-center align-middle"><h4>$ <?= $newprice ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? } else { ?>
										<td class="text-center d-none d-md-block"><img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px"></td>
										<?
										}
										?>
									</tr>
									<?
										}
									?>
								</table>
							</div>
							<div class="tab-pane fade" id="panel_cabinet" role="tabpanel">
								<div class="w-100 text-right">
									<div class="btn btn-success" onClick="$('.printable').removeClass('d-print-block');$('#printCabinet').addClass('d-print-block');window.print();"><i class="fas fa-print"></i> Print</div>
								</div>
								<table class="table table-striped table-hover table-sm mdb-lightbox tableCabinet" id="tableCabinet">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-left" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$get_quartz = new project_action;
										foreach($get_quartz->get_quartz() as $results) {
											$slab = intval($results['slab_cost']);
											$sqft = intval($results['slab_sqft']);
											$from = $slab / $sqft;
											$to = ceil((($slab / 30) + 20) * 1.45);
											$price = ceil(($from + 20) * 1.45) ;
											$newprice = ceil((($price + $to)/2)*.8);
											if ($newprice <= 44.01) {
												$level = 1;
											} elseif ($newprice < 53.01) {
												$level = 2;
											} elseif ($newprice < 60.01) {
												$level = 3;
											} elseif ($newprice < 66.01) {
												$level = 4;
											} elseif ($newprice < 76.01) {
												$level = 5;
											} elseif ($newprice < 85.01) {
												$level = 6;
											} elseif ($newprice < 111.01) {
												$level = 7;
											} elseif ($newprice < 150.01) {
												$level = 8;
											}  else {
												$level = 9;
											}
											if ( $level === 1 ) {
												$level1c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 2 ) {
												$level2c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 3 ) {
												$level3c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 4 ) {
												$level4c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 5 ) {
												$level5c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 6 ) {
												$level6c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 7 ) {
												$level7c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 8 ) {
												$level8c .= '<p class="qItem">' . $results['name'] . '</p><div class="clearfix"></div>';
											}
											if ( $level === 9 ) {
												$level9c .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">$ ' . $newprice . '</span></p><div class="clearfix"></div>';
											}
									?>
									<tr class="filter">
										<td class="text-center align-middle">Level <?= $level ?></td>
										<td class="align-middle"><h4><b><?= $results['name'] ?></b></h4></td>

										<td class="text-center align-middle"><h4>$ <?= $newprice ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? } else { ?>
										<td class="text-center d-none d-md-block"><img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px"></td>
										<?
										}
										?>
									</tr>
									<?
										}
									?>
								</table>
							</div>
						</div>
           			</div>
					<div class="row mb-5 pt-5 d-flex" style="position: sticky; top: 0 text-right align-right">
						<p><span class="text-danger">*</span> Based on minimum of 30 SqFt.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="print">
	p { padding-bottom: 0; margin-bottom: 0; }
	@page { size: landscape; }
</style>
<div class="printable d-none" id="printRetail">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Quartz</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7r ?>
		</div>
	</div>
	<?
	if ($level8r !== '') {
	?>
<!--
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom">Level 8 Quartz</h4>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level8r ?>
		</div>
	</div>
-->
	<?
	}
	?>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom">Specialty Quartz &amp; Agragates</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level9r ?>
		</div>
	</div>
</div>












<div class="printable d-none" id="printBuilder">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Quartz - $47 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Quartz - $55 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Quartz - $51 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Quartz - $67 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Quartz - $78 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Quartz - $86 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Quartz - $108 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7b ?>
		</div>
	</div>
	<?
	if ($level8r !== '') {
	?>
<!--
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 8 Quartz</h4>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level8b ?>
		</div>
	</div>
-->
	<?
	}
	?>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Specialty Quartz &amp; Agragates</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level9b ?>
		</div>
	</div>
</div>

























<div class="printable d-none" id="printCabinet">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Quartz - $44 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Quartz - $53 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Quartz - $60 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Quartz - $65 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Quartz - $76 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Quartz - $84 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Quartz - $108 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Specialty Quartz &amp; Agragates - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level9c ?>
		</div>
	</div>
</div>
