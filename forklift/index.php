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

    <title>Amanzi Forklift Operator</title>

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

    <link rel="manifest" href="/manifest.json">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/ie10.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><img alt="Amanzi Granite" longdesc="http://amanzigranite.com" src="images/web-logo.png"></h3>
                    </div>
                </div>
                <div class="inner cover">
                    <section class="container align-middle" id="select-form">
                        <h1 class="head-text">Welcome!</h1>
                        <p style="color:#525252">All forklift operators must complete the inspection checklist before operating the forklift.</p>
                        <div class="row">
                            <div class="col-12 col-md-4 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="fl-checkout" link="checkout">Check Out Forklift</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="fl-checkin" link="checkout">Check In Forklift</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="fl-checkin" link="checkout">Maintenance Log</h2>
                                </div>
                            </div>
                        </div>
                    </section>




                    <section class="container align-middle" id="checkout" style="display:none;">
                        <div class="row float-right">
                            <div class="close close-form">
                                <i class="fa fa-xl fa-close"></i>
                            </div>
                        </div>
                        <h1 class="head-text">Forklift Checkout</h1>
                        <form class="container text-left text-dark" id="fl-co" name="fl-co">
							<input type="hidden" name="date_ci" id="todayDate"/>
                            <hr>
                            <h3 class="col-12">I have read and understood the Safety Regulations and agree that I am fully responsible for myself and any other guests or minors I am bringing onto the premises.</h3>
                            <div class="row">
                                <fieldset class="form-group col-md-6">
                                    <label for="fl-name">Forklift</label>
                                    <select class="form-control" id="fl-name" name="fl-name">
                                        <option value="0" selected>Select Forklift...</option>
                                        <option value="1">Forklift F1</option>
                                        <option value="2">Forklift F2</option>
                                        <option value="3">Forklift F3</option>
                                        <option value="4">Forklift F4</option>
                                        <option value="5">Forklift F5</option>
                                        <option value="6">Forklift F6</option>
                                        <option value="7">Forklift F7</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="row fl-row">
								<h3 class="col-12 col-lg-4">Power Source condition (LP or Electric)</h3>
								<div class="row col-12 col-lg-8">
									<div class="form-check col-3">
										<label class="form-check-label w-100 h-100 btn btn-danger" for="power1">
											<input class="form-check-input w-0" type="radio" name="power" id="power1" onClick="checkOption(this); return false;" value="Unsafe">
											<i class="fa fa-xl fa-ban w-100"></i>
											<div class="w-100 d-none d-md-block">Unsafe</div>
										</label>
									</div>
									<div class="form-check col-3">
										<label class="form-check-label w-100 h-100 btn btn-warning" for="power2">
											<input class="form-check-input" type="radio" name="power" id="power2" onClick="checkOption(this);" value="Needs Attention">
											<i class="fa fa-xl fa-warning"></i> 
											<div class="w-100 d-none d-md-block">Need Attention</div>
										</label>
									</div>
									<div class="form-check col-3">
										<label class="form-check-label w-100 h-100 btn btn-secondary" for="power3">
											<input class="form-check-input" type="radio" name="power" id="power3" onClick="checkOption(this);" value="N/A">
											<i class="fa fa-xl fa-minus"></i>
											<div class="w-100 d-none d-md-block text-wrap">Not Applicable</div>
										</label>
									</div>
									<div class="form-check col-3">
										<label class="form-check-label w-100 h-100 btn btn-success" for="power4">
											<input class="form-check-input" type="radio" name="power" id="power4" onClick="checkOption(this);" value="OK">
										<i class="fa fa-xl fa-check"></i>
										<div class="w-100 d-none d-md-block">OK</div>
										</label>
									</div>
								</div>
							</div>








                        </form>
                    </section>









                    <div class="mastfoot">
                        <div class="inner">
                            <p>For visitors to <a href="http://amanzigranite.com">Amanzi Marble, Granite and Tile</a>. Version 1.4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div aria-hidden="true" aria-labelledby="modalLabe4" class="modal fade" id="thank-you" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabe3">Submitted!</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
            </div>
            <div class="modal-body">
                <p>Thank you.  Your data has been submitted and an Amanzi representitive will be in touch soon.</p>
            </div>
            <div class="modal-footer">
                <button aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button"><i class="fa fa-xl fa-check"></i></button>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/ie10.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script>
function checkOption(element) {
	var e = element.id;
	var form = $(element).parent('form').attr('id');
	if ($(element).is(':checked') == true) {
		$(element).parent().parent().siblings().hide();
	} else {
		$(element).parent().parent().siblings().show();
	}
};


</script>

<script>
</script>
</body>
</html>