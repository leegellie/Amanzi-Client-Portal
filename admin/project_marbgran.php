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
						<h1 class="text-primary col-10 pl-5">Marble &amp; Granite Pricing</h1>
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

								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$marble = '';
										$get_marble = new project_action;
										foreach($get_marble->get_marble() as $results) {
											$count = 0;
											$price = 0;
											if ($results['price_0'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_0'];
											}
											if ($results['price_1'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_1'];
											}
											if ($results['price_2'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_2'];
											}
											if ($results['price_3'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_3'];
											}
											if ($results['price_4'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_4'];
											}
											if ($results['price_5'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_5'];
											}
											if ($results['price_6'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_6'];
											}
											if ($results['price_7'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_7'];
											}
											$level = 0;
											$cost =  ceil($price / $count);
											$price = $cost * 6;
											if ($price < 48.01) {
												$price = 48;
												$level = 1;
											} elseif ($price < 60.01) {
												$price = 60;
												$level = 2;
											} elseif ($price < 78.01) {
												$price = 78;
												$level = 3;
											} elseif ($price < 102.01) {
												$price = 102;
												$level = 4;
											} elseif ($price < 132.01) {
												$price = 132;
												$level = 5;
											} elseif ($price < 168.01) {
												$price = 168;
												$level = 6;
											} elseif ($price < 216.01) {
												$price = 216;
												$level = 7;
											} elseif ($price < 252.01) {
												$price = 252;
												$level = 8;
											}  else {
												$level = 9;
											}
											if ( $level === 1 ) {
												$level1r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 2 ) {
												$level2r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 3 ) {
												$level3r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 4 ) {
												$level4r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 5 ) {
												$level5r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 6 ) {
												$level6r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 7 ) {
												$level7r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 8 ) {
												$level8r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}
											if ( $level === 9 ) {
												$level9r .= '<p class="qItem">' . $results['name'] . ' </p><div class="clearfix"></div>';
											}

									?>

									<tr class="filter">
										<td class="text-center align-middle">Level <?= $level ?></td>
										<td class="align-middle"><h4><b><?= $results['name'] ?></b></h4></td>
										<td class="text-center align-middle"><h4>$ <?= $price ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? } else { ?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px">
										</td>
										<?
										}
										?>
									</tr>
		<?
	}
	echo $marble;
?>

								</table>
							</div>
							<div class="tab-pane fade" id="panel_builder" role="tabpanel">
								<div class="w-100 text-right">
									<div class="btn btn-success" onClick="$('.printable').removeClass('d-print-block');$('#printBuilder').addClass('d-print-block');window.print();"><i class="fas fa-print"></i> Print</div>
								</div>


								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$marble = '';
										$get_marble = new project_action;
										foreach($get_marble->get_marble() as $results) {
											$count = 0;
											$price = 0;
											if ($results['price_0'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_0'];
											}
											if ($results['price_1'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_1'];
											}
											if ($results['price_2'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_2'];
											}
											if ($results['price_3'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_3'];
											}
											if ($results['price_4'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_4'];
											}
											if ($results['price_5'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_5'];
											}
											if ($results['price_6'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_6'];
											}
											if ($results['price_7'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_7'];
											}
											$cost =  ceil($price / $count);
											$price = $cost * 6;
											if ($price < 48.01) {
												$price = 48;
												$level = 1;
											} elseif ($price < 60.01) {
												$price = 60;
												$level = 2;
											} elseif ($price < 78.01) {
												$price = 78;
												$level = 3;
											} elseif ($price < 102.01) {
												$price = 102;
												$level = 4;
											} elseif ($price < 132.01) {
												$price = 132;
												$level = 5;
											} elseif ($price < 168.01) {
												$price = 168;
												$level = 6;
											} elseif ($price < 216.01) {
												$price = 216;
												$level = 7;
											} elseif ($price < 252.01) {
												$price = 252;
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
										<td class="text-center align-middle"><h4>$ <?= ceil($price*.85) ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? } else { ?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px">
										</td>
										<?
										}
										?>
									</tr>
		<?
	}
	echo $marble;
?>

								</table>
							</div>
							<div class="tab-pane fade" id="panel_cabinet" role="tabpanel">
								<div class="w-100 text-right">
									<div class="btn btn-success" onClick="$('.printable').removeClass('d-print-block');$('#printCabinet').addClass('d-print-block');window.print();"><i class="fas fa-print"></i> Print</div>
								</div>

								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<tfoot class="mdb-color darken-3 text-white" style="position: sticky; bottom:0">
										<tr>
											<th class="text-center" scope="col">Level</th>
											<th scope="col">Name</th>
											<th class="text-center" scope="col">Price</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
									<?
										$marble = '';
										$get_marble = new project_action;
										foreach($get_marble->get_marble() as $results) {
											$count = 0;
											$price = 0;
											if ($results['price_0'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_0'];
											}
											if ($results['price_1'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_1'];
											}
											if ($results['price_2'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_2'];
											}
											if ($results['price_3'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_3'];
											}
											if ($results['price_4'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_4'];
											}
											if ($results['price_5'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_5'];
											}
											if ($results['price_6'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_6'];
											}
											if ($results['price_7'] > 0) {
												$count = $count + 1;
												$price = $price + $results['price_7'];
											}
											$cost =  ceil($price / $count);
											$price = $cost * 6;
											if ($price < 48.01) {
												$price = 48;
												$level = 1;
											} elseif ($price < 60.01) {
												$price = 60;
												$level = 2;
											} elseif ($price < 78.01) {
												$price = 78;
												$level = 3;
											} elseif ($price < 102.01) {
												$price = 102;
												$level = 4;
											} elseif ($price < 132.01) {
												$price = 132;
												$level = 5;
											} elseif ($price < 168.01) {
												$price = 168;
												$level = 6;
											} elseif ($price < 216.01) {
												$price = 216;
												$level = 7;
											} elseif ($price < 252.01) {
												$price = 252;
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
												$level9c .= '<p class="qItem">' . $results['name'] . ' <span class="float-right">$ ' . $price . '</span></p><div class="clearfix"></div>';
											}
									?>
									<tr class="filter">
										<td class="text-center align-middle">Level <?= $level ?></td>
										<td class="align-middle"><h4><b><?= $results['name'] ?></b></h4></td>
										<td class="text-center align-middle"><h4>$ <?= ceil($price*.70) ?></h4></td>
										<? 
										if (!(is_null($results['image']))) {
											?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/<?= $results['image'] ?>" width="250px">
										</td>
										<? 
										} else { ?>
										<td class="text-center d-none d-md-block">
											<img class="img-thumbnail" src="/price/images/no-img.jpg" width="250px">
										</td>
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

				</div>
			</div>
		</div>
<style type="text/css" media="print">
	p { padding-bottom: 0; margin-bottom: 0; }
	@page { size: landscape; }
</style>
<div class="printable d-none" id="printRetail">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Marble &amp; Granite - $ 48</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Marble &amp; Granite - $ 60</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Marble &amp; Granite - $ 78</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Marble &amp; Granite - $ 102</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Marble &amp; Granite - $ 132</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Marble &amp; Granite - $ 168</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6r ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Marble &amp; Granite - $ 216</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7r ?>
		</div>
	</div>
</div>



<div class="printable d-none" id="printBuilder">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Marble &amp; Granite - $41 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Marble &amp; Granite - $51 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Marble &amp; Granite - $67 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Marble &amp; Granite - $87 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Marble &amp; Granite - $113 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Marble &amp; Granite - $143 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6b ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Marble &amp; Granite - $184 - Gold Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 3;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7b ?>
		</div>
	</div>
</div>



<div class="printable d-none" id="printCabinet">
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 1 Marble &amp; Granite - $34 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue; float: none">
			<?= $level1c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 2 Marble &amp; Granite - $42 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level2c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 3 Marble &amp; Granite - $55 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level3c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 4 Marble &amp; Granite - $72 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level4c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 5 Marble &amp; Granite - $93 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level5c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 6 Marble &amp; Granite - $118 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level6c ?>
		</div>
	</div>
	<div class="clearfix"style="page-break-before: always"></div>
	<div class="print-block" style="page-break-after: always; float: none">
		<h4 class="text-primary border-bottom"><img src="../images/logo-bw.png" width="70px" class="float-right">Level 7 Marble &amp; Granite - $152 - Platinum Discount</h4>
		<h6 class="text-danger"><small>* All pricing based on a minimum of 30 sqft per material. Prices valid until <?= date('Y-m-d', strtotime("+30 days")); ?></small></h6>
		<div class="p1r " style="column-count: 4;column-gap: 25px;column-rule: 1px solid lightblue;float: none">
			<?= $level7c ?>
		</div>
	</div>
</div>
	</div>
</div>
