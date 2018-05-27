<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <title>Amanzi Material Calculator</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/ie10.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
				<div class="inner cover">
					<section class="container align-middle" id="select-form">
						<h1 class="head-text">Quartz</h1>
						<div class="stageOne">
<?PHP
$brand = '';
require_once('php/db_connect.php');
require_once('php/classes.php');

//Get Select Brand Dropdown
$brandQ = $conn->query("SELECT DISTINCT brand FROM category ORDER BY brand ASC");
$brandQ->setFetchMode(PDO::FETCH_CLASS, 'selectBrand');

echo '<select id="brandSelector" class="inputControl form-control form-control-lg col-12 col-md-6 m-auto"><option value="">Select Brand</option>', print_r($brandQ->fetchAll()), '</select>';

?>
							<div id="results" class="mt-1"></div>
						</div>
						<div class="calculator" style="display: none;">
							<h1 class="label"></h1>
							<div class="neo-nav container" role="tablist">
								<div id="retail" mat-val="4" class="industry col-md-3 p-0 active">
									<p>Retail</p>
								</div>
								<div id="cabinet" mat-val="4" class="industry col-md-3 p-0">
									<p>Cabinet Company</p>
								</div>
								<div id="builder" mat-val="4" class="industry col-md-3 p-0">
									<p>Builder</p>
								</div>
								<div id="commercial" mat-val="5" class="industry col-md-3 p-0">
									<p>Commercial</p>
								</div>
							</div>
							<div class="mob-select" style="display:none">
								<fieldset class="form-group selectpicker" data-style="btn-primary">
									<select class="form-control" id="indSelect">
										<option name="retail" value="4">Retail</option>
										<option name="cabinet" value="4">Cabinet Company</option>
										<option name="builder" value="4">Builder</option>
										<option name="commercial" value="5">Commercial</option>
									</select>
								</fieldset>
							</div>
							<div class="row">
								<div class="col-12 mt-5 mb-3">
									<h1 id="sqFtBox" class="price">Per Sq Ft: $<span id="sqFtPrice"></span></h1>
									<p id="sqFtWarning" class="text-danger">* There is an overage markup if SqFt is below 30sqft.</p>
									<h1 id="totPrice" class="price" style="display:none">Job Price: $<span id="finalPrice"></span></h1>
								</div>
							</div>
							<div class="row">
								<div id="unitCount" class="col-4 mt-5" style="display:none">
									<fieldset class="form-group">
										<label for="units">
											<h3 class="text-dark">Number of Units</h3>
											<input class="inputControl2 form-control form-control-lg" type="number" id="units">
										</label>
									</fieldset>
								</div>
								<div class="col-4 mt-5">
									<fieldset class="form-group">
										<label for="matPrice">
											<h3 class="text-dark">Thickness</h3>
											<select class="inputControl2 form-control form-control-lg" id="matCode">
												<option class="cmO cm3" value="">3cm</option>
												<option class="cmO cm2" value="">2cm</option>
												<option class="cmO cm1" value="">1cm</option>
											</select>
										</label>
									</fieldset>
								</div>
								<div class="col-4 mt-5">
									<fieldset class="form-group">
										<label for="sqFt">
											<h3 class="text-dark">Square Feet</h3>
											<input class="inputControl2 form-control form-control-lg" type="number" id="sqFt">
										</label>
									</fieldset>
								</div>
							</div>
						</div>
							<div class="row">
								<div class="col-12 mt-5 mb-3">
									<button id="backBut" class="btn btn-lg btn-success">Back</button>
									<button id="clearAll" class="btn btn-lg btn-danger">Reset All</button>
								</div>
							</div>
					</section>
                </div>
            </div>
        </div>
    </div>







<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/ie10.js"></script>
<script type="text/javascript" src="js/functions-quartz.js"></script>
<script>


</script>
</body>
</html>