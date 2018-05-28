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

    <title>Amanzi Client Portal</title>

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

    <link rel="manifest" href="/manifest.json" version="2.1">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/ie10.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

    <script type="text/javascript" src="js/addtohomescreen.min.js"></script>
</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><img alt="Amanzi Granite" longdesc="https://amanzigranite.com" src="images/web-logo.png"></h3>
                        <nav class="nav nav-masthead">
                            <a class="btn btn-dark web" href="https://amanzigranite.com"><i class="fa fa-xl fa-globe"></i><p>Visit Website</p></a>
                            <a class="btn btn-light btn-lg call" href="tel:+13369939998"><i class="fa fa-xl fa-phone"></i><p>Call Amanzi</p></a>
                        </nav>
                    </div>
                </div>
                <div class="inner cover">
                    <section class="container align-middle" id="select-form">
                        <h1 class="head-text">Client Portal</h1>
                        <div class="row">
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="new-job">New Job Order</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="change-order">Change Order</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="service-ticket">Service Ticket</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="start-form" id="my-projects">Live Projects</h2>
                                </div>
                            </div>
                        </div>
                    </section>





                    <section class="container align-middle" id="new-job-form" style="display:none;">
                        <div class="row float-right">
                            <div class="close close-form">
                                <i class="fa fa-xl fa-close"></i>
                            </div>
                        </div>
                        <h1 class="head-text">New Job Order</h1>
                        <form class="row text-left text-dark" id="form1" name="form1">
                        	<input type="hidden" name="form-name" value="New Job Order">
                            <hr>
                            <h2 class="col-12">Job Details</h2>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="quote-num">Quote #:</label> <input class="form-control" id="quote-num" name="quote-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="order-num">Order #:</label> <input class="form-control" id="order-num" name="order-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="install-date">Install Date:</label> <input class="form-control" id="install-date" name="install-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="template-date">Template Date:</label> <input class="form-control" id="template-date" name="template-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="job-name">Job Name:</label> <input required class="form-control" id="job-name" name="job-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="account-rep">Account Rep:</label>
								<select class="form-control" id="account-rep" name="account-rep">
                                    <option data-email="" value="none">Unspecified</option>
                                    <option data-email="kclements@amanzigranite.com" value="Kim Clements">Kim Clements</option>
                                    <option data-email="mjones@amanzigranite.com" value="Melissa Jones">Melissa Jones</option>
                                    <option data-email="mmcbride@amanzigranite.com" value="Maureen McBride">Maureen McBride</option>
                                    <option data-email="mmusci@amanzigranite.com" value="Mark Musci">Mark Musci</option>
                                    <option data-email="apalma@amanzigranite.com" value="Alexandra Palma">Alexandra Palma</option>
                                    <option data-email="csheppard@amanzigranite.com" value="Chris Sheppard">Chris Sheppard</option>
                                    <option data-email="ksheppard@amanzigranite.com" value="Kate Sheppard">Kate Sheppard</option>
                                    <option data-email="cwilder@amanzigranite.com" value="Corry Wilder">Corry Wilder</option>
                                    <option data-email="omar@amanzigranite.com" value="Omar Kalaf">Omar Kalaf</option>
                                </select>
                            </fieldset>
                            <input type="hidden" name="repEmail" value="">
                            <fieldset class="form-group col-md-6">
                                <label for="customer-name">Customer Name:</label> <input required class="form-control" id="customer-name" name="customer-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="builder-name">Builder / Cabinet Company:</label> <input class="form-control" id="builder-name" name="builder-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-phone">Customer Phone #:</label> <input required class="form-control" id="customer-phone" name="customer-phone" type="tel" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-email">Customer Email:</label> <input required class="form-control" id="customer-email" name="customer-email" type="email">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-cost">P.O. Cost:</label> <input class="form-control" id="po-cost" name="po-cost" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-num">P.O. #:</label> <input class="form-control" id="po-num" name="po-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="billing-address">Billing Address:</label> <input class="form-control" id="billing-address" name="billing-address" type="text" data-required="true">
                            </fieldset>
                            <hr>
                            <h2 class="col-12">Site Details</h2>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name">Site Contact:</label> <input class="form-control" id="contact-name" name="contact-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone">Contact Telephone:</label> <input class="form-control" id="contact-phone" name="contact-phone" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name2">Alternative Contact:</label> <input class="form-control" id="contact-name2" name="contact-name2" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone2">Alternative Telephone:</label> <input class="form-control" id="contact-phone2" name="contact-phone2" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="site-address">Site Address:</label> <input class="form-control" id="site-address" name="site-address" type="text">
                            </fieldset>
                            <hr>
                            <h2 class="col-12">Install Details</h2>
                            <fieldset class="form-group col-12">
                                <label for="install1-name">Area/Install Name:</label> <input class="form-control" id="install1-name" name="install1-name" type="text" data-required="true" required>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6 col-lg-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Job Type:</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label for="job-type1a"><input checked class="form-check-input with-font" id="job-type1a" name="job-type1" type="radio" value="new"><p>New Install</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="job-type1b"><input class="form-check-input with-font" id="job-type1b" name="job-type1" type="radio" value="remodel"><p>Remodel</p></label>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6 col-lg-2">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Tear Out:</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label for="tear-out1a"><input checked class="form-check-input with-font" id="tear-out1a" name="tear-out1" type="radio" value="Yes"><p>Yes</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="tear-out1b"><input class="form-check-input with-font" id="tear-out1b" name="tear-out1" type="radio" value="no"><p>No</p></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>



                            <fieldset class="form-group col-12 col-lg-6">
                                <label for="material1">Material:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="material1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                                <label for="color1">Color:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="color1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="lot1">Lot #:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="lot1" type="text">
                            </fieldset>

							<input type="hidden" name="materialToUse1" id="materialToUse1" value="">

                            <fieldset class="form-group col-6 col-md-3">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Customer Selected?</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label class="selected1a"><input checked class="form-check-input with-font" id="selected1a" name="selected1" type="radio" value="Yes"><p>Yes</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="selected1b"><input class="form-check-input with-font" id="selected1b" name="selected1" type="radio" value="no"><p>No</p></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="edge1">Edge:</label>
								<select class="form-control" id="edge1" name="edge1">
                                    <option value="None">None</option>
                                    <option value="1 inch bevel">1" Bevel</option>
                                    <option value="Half inch bevel">1/2" Bevel</option>
                                    <option value="Quarter inch bevel">1/4" Bevel</option>
                                    <option value="Half Bullnose">Half Bullnose</option>
                                    <option value="Full Bullnose">Full Bullnose</option>
                                    <option value="Demi Bullnose">Demi Bullnose</option>
                                    <option value="Flat">Flat</option>
                                    <option value="Pencil">Pencil</option>
                                    <option value="Heavy Pencil">Heavy Pencil</option>
                                    <option value="Ogee">Ogee</option>
                                    <option value="Other">Other</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Backsplash?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="backsplash1"><input class="form-check-input controller with-font" data-control="bs-detail1" id="backsplash1" name="backsplash1" type="checkbox" value="Yes"></label>
                                            </div><input class="form-control form-inline col-9 col-lg-10 bs-detail1" id="bs-detail1" name="bs-detail1" placeholder="Details" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Riser?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="riser1"><input class="form-check-input controller with-font" data-control="rs-detail1" id="riser1" name="riser1" type="checkbox" value="Yes"></label>
                                            </div><input class="form-control form-inline col-9 col-lg-10 rs-detail1" id="rs-detail1" name="rs-detail1" placeholder="Details" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Sink(s)?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="sinks1">
													<input class="form-check-input controller with-font" data-control="sk-detail1" id="sinks1" name="sinks1" type="checkbox" value="Yes">
												</label>
                                            </div>
											<input class="form-control form-inline col-9 col-lg-10 sk-detail1" id="sk-detail1" name="sk-detail1" placeholder="Details/Model" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                                <div class="row">
		                            <div class="form-group col-12">
                                        <label for="range1">Range Type:</label>
                                        <select class="form-control" id="range1" name="range1">
                                            <option value="None">None</option>
                                            <option value="Free Standing">Free Standing</option>
                                            <option value="Cooktop">Cooktop</option>
                                            <option value="Slide-In">Slide-In</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <fieldset class="form-group col-12">
                                        <label for="model1">Model #:</label> <input class="form-control" id="model1" name="model1" type="text">
                                    </fieldset>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                            	<div class="row">
		                            <div class="form-group col-12">
                                        <label for="spread1">Faucet Spread / Holes:</label>
                                        <select class="form-control holeOpt" id="spread1" name="spread1">
                                            <option value="None">None</option>
                                            <option value="1 Hole - Center">1 Hole - Center</option>
                                            <option value="3 Hole - 4 Inch">3 Hole - 4"</option>
                                            <option value="3 Hole - 8 Inch">3 Hole - 8"</option>
                                            <option class="controller" data-control="holes1" value="Other">Other Holes</option>
                                        </select>
                                    </div>
                                </div>
                            	<div class="row">
                                    <fieldset class="form-group col-12">
                                        <label for="cutout1">Cutout:</label>
                                        <input class="form-control" id="cutout1" name="cutout1" type="text">
                                    </fieldset>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 hole1" style="display:none;">
                                <label for="holes1">Specify other holes needed:</label>
                                <input class="form-control" id="holes1" name="holes1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="notes1">Install Notes:</label> 
                                <textarea class="form-control" id="notes1" name="notes1" rows="3"></textarea>
                            </fieldset>
                            <hr>
                            <div class="col-12 btn-surround">
                                <div class="btn btn-dark btn-lg sect-btn sect-add float-right" data-control="install2">
                                    <span>Add additional install</span> <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="col-12 install2" style="display:none">
                                <div class="row">
                                    <h2 class="col-10">Install 2</h2>
                                    <fieldset class="form-group col-12">
                                        <label for="install2-name">Area/Install Name:</label> <input class="form-control" id="install2-name" name="install2-name" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Job Type:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="job-type2a"><input checked class="form-check-input with-font" id="job-type2a" name="job-type2" type="radio" value="new"><p>New Install</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="job-type2b"><input class="form-check-input with-font" id="job-type2b" name="job-type2" type="radio" value="remodel"><p>Remodel</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-2">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Tear Out:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="tear-out2a"><input checked class="form-check-input with-font" id="tear-out2a" name="tear-out2" type="radio" value="Yes"><p>Yes</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="tear-out2b"><input class="form-check-input with-font" id="tear-out2b" name="tear-out2" type="radio" value="no"><p>No</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>




                                    <!--<fieldset class="form-group col-12 col-lg-6">
                                        <label for="material2">Material:</label> <input class="form-control" id="material2" name="material2" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <label for="color2">Color:</label> <input class="form-control" id="color2" name="color2" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-3">
                                        <label for="lot2">Lot #:</label> <input class="form-control" id="lot2" name="lot2" type="text">
                                    </fieldset>-->
		
									<fieldset class="form-group col-12 col-lg-6">
										<label for="material2">Material:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="material2" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<label for="color2">Color:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="color2" type="text">
									</fieldset>
									<fieldset class="form-group col-6 col-md-3">
										<label for="lot2">Lot #:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="lot2" type="text">
									</fieldset>
		
									<input type="hidden" name="materialToUse2" id="materialToUse2" value="">
		
									<fieldset class="form-group col-6 col-md-3">
										<div class="row">
											<legend class="col-form-legend col-12">Customer Selected?</legend>
											<div class="col-12">
												<div class="form-check form-check-inline col-6">
													<label for="selected2a">
														<input checked class="form-check-input with-font" id="selected2a" name="selected2" type="radio" value="Yes"><p>Yes</p>
													</label>
												</div>
												<div class="form-check form-check-inline">
													<label for="selected2b">
														<input class="form-check-input with-font" id="selected2b" name="selected2" type="radio" value="no"><p>No</p>
													</label>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col-12">
										<label for="edge2">Edge:</label> 
										<select class="form-control" id="edge2" name="edge2">
											<option value="None">None</option>
											<option value="1 inch bevel">1" Bevel</option>
											<option value="Half inch bevel">1/2" Bevel</option>
											<option value="Quarter inch bevel">1/4" Bevel</option>
											<option value="Half Bullnose">Half Bullnose</option>
											<option value="Full Bullnose">Full Bullnose</option>
											<option value="Demi Bullnose">Demi Bullnose</option>
											<option value="Flat">Flat</option>
											<option value="Pencil">Pencil</option>
											<option value="Heavy Pencil">Heavy Pencil</option>
											<option value="Ogee">Ogee</option>
											<option value="Other">Other</option>
										</select>
									</fieldset>
									<fieldset class="form-group col-6 col-sm-4">
										<div class="row">
											<legend class="col-form-legend col-12">Backsplash?</legend>
											<div class="col-12">
												<div class="row">
													<div class="form-check form-check-inline col-3 col-lg-2">
														<label class="form-check-label">
															<input class="form-check-input controller with-font" data-control="bs-detail2" id="backsplash2" name="backsplash2" type="checkbox">
														</label>
													</div>
													<input class="form-control form-inline col-9 col-lg-10 bs-detail2" id="bs-detail2" name="bs-detail2" placeholder="Details" style="display:none;" type="text">
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col-6 col-sm-4">
										<div class="row">
											<legend class="col-form-legend col-12">Riser?</legend>
											<div class="col-12">
												<div class="row">
													<div class="form-check form-check-inline col-3 col-lg-2">
														<label class="form-check-label">
															<input class="form-check-input controller with-font" data-control="rs-detail2" id="riser2" name="riser2" type="checkbox" value="Yes">
														</label>
													</div>
													<input class="form-control form-inline col-9 col-lg-10 rs-detail2" id="rs-detail2" name="rs-detail2" placeholder="Details" style="display:none;" type="text">
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col-6 col-sm-4">
										<div class="row">
											<legend class="col-form-legend col-12">Sink(s)?</legend>
											<div class="col-12">
												<div class="row">
													<div class="form-check form-check-inline col-3 col-lg-2">
														<label class="form-check-label" for="sinks2">
															<input class="form-check-input controller with-font" data-control="sk-detail2" id="sinks2" name="sinks2" type="checkbox" value="Yes">
														</label>
													</div>
													<input class="form-control form-inline col-9 col-lg-10 sk-detail2" id="sk-detail2" name="sk-detail2" placeholder="Details/Model" style="display:none;" type="text">
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<div class="row">
											<div class="form-group col-12">
												<label for="range2">Range Type:</label>
												<select class="form-control" id="range2" name="range2">
													<option value="None">None</option>
													<option value="Free Standing">Free Standing</option>
													<option value="Cooktop">Cooktop</option>
													<option value="Slide-In">Slide-In</option>
												</select>
											</div>
										</div>
										<div class="row">
											<fieldset class="form-group col-12">
												<label for="model2">Model #:</label>
												<input class="form-control" id="model2" name="model2" type="text">
											</fieldset>
										</div>
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<div class="row">
											<div class="form-group col-12">
												<label for="spread2">Faucet Spread / Holes:</label>
												<select class="form-control holeOpt" id="spread2" name="spread2">
													<option value="None">None</option>
													<option value="1 Hole - Center">1 Hole - Center</option>
													<option value="3 Hole - 4 Inch">3 Hole - 4"</option>
													<option value="3 Hole - 8 Inch">3 Hole - 8"</option>
													<option class="controller" data-control="holes2" value="Other">Other Holes</option>
												</select>
											</div>
										</div>
										<div class="row">
											<fieldset class="form-group col-12">
												<label for="cutout2">Cutout:</label>
												<input class="form-control" id="cutout2" name="cutout2" type="text">
											</fieldset>
										</div>
									</fieldset>
									<fieldset class="form-group col-12 hole2" style="display:none;">
										<label for="holes2">Specify other holes needed:</label>
										<input class="form-control" id="holes2" name="holes2" type="text">
									</fieldset>
									<fieldset class="form-group col-12">
										<label for="notes2">Install Notes:</label> 
										<textarea class="form-control" id="notes2" name="notes2" rows="3"></textarea>
									</fieldset>
									<hr>
									<div class="col-12 btn-surround">
										<div class="btn btn-dark btn-lg sect-btn sect-add float-right" data-control="install3">
											<span>Add additional install</span> <i class="fa fa-plus"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 install3" style="display:none">
								<div class="row">
									<h2 class="col-10">Install 3</h2>
		
		
									<fieldset class="form-group col-12">
										<label for="install3-name">Area/Install Name:</label>
										<input class="form-control" id="install3-name" name="install3-name" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6 col-lg-4">
										<div class="row">
											<legend class="col-form-legend col-12">Job Type:</legend>
											<div class="col-12">
												<div class="form-check form-check-inline col-6">
													<label for="job-type3a">
														<input checked class="form-check-input with-font" id="job-type3a" name="job-type3" type="radio" value="new"><p>New Install</p>
													</label>
												</div>
												<div class="form-check form-check-inline">
													<label for="job-type3b">
														<input class="form-check-input with-font" id="job-type3b" name="job-type3" type="radio" value="remodel"><p>Remodel</p>
													</label>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col-12 col-md-6 col-lg-2">
										<div class="row">
											<legend class="col-form-legend col-12">Tear Out:</legend>
											<div class="col-12">
												<div class="form-check form-check-inline col-6">
													<label for="tear-out3a">
														<input checked class="form-check-input with-font" id="tear-out3a" name="tear-out3" type="radio" value="Yes"><p>Yes</p>
													</label>
												</div>
												<div class="form-check form-check-inline">
													<label for="tear-out3b">
														<input class="form-check-input with-font" id="tear-out3b" name="tear-out3" type="radio" value="no"><p>No</p>
													</label>
												</div>
											</div>
										</div>
									</fieldset>




									<!--<fieldset class="form-group col-12 col-lg-6">
										<label for="material3">Material:</label> <input class="form-control" id="material3" name="material3" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<label for="color3">Color:</label> <input class="form-control" id="color3" name="color3" type="text">
									</fieldset>
									<fieldset class="form-group col-6 col-md-3">
										<label for="lot3">Lot #:</label> <input class="form-control" id="lot3" name="lot3" type="text">
									</fieldset>-->


									<fieldset class="form-group col-12 col-lg-6">
										<label for="material3">Material:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="material3" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<label for="color3">Color:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="color3" type="text">
									</fieldset>
									<fieldset class="form-group col-6 col-md-3">
										<label for="lot3">Lot #:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="lot3" type="text">
									</fieldset>

									<input type="hidden" name="materialToUse3" id="materialToUse3" value="">

                                    <fieldset class="form-group col-6 col-md-3">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Customer Selected?</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="selected3a">
														<input checked class="form-check-input with-font" id="selected3a" name="selected3" type="radio" value="Yes"><p>Yes</p>
													</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="selected3b">
														<input class="form-check-input with-font" id="selected3b" name="selected3" type="radio" value="no"><p>No</p>
													</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="edge3">Edge:</label>
										<select class="form-control" id="edge3" name="edge3">
											<option value="None">None</option>
											<option value="1 inch bevel">1" Bevel</option>
											<option value="Half inch bevel">1/2" Bevel</option>
											<option value="Quarter inch bevel">1/4" Bevel</option>
											<option value="Half Bullnose">Half Bullnose</option>
											<option value="Full Bullnose">Full Bullnose</option>
											<option value="Demi Bullnose">Demi Bullnose</option>
											<option value="Flat">Flat</option>
											<option value="Pencil">Pencil</option>
											<option value="Heavy Pencil">Heavy Pencil</option>
											<option value="Ogee">Ogee</option>
											<option value="Other">Other</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Backsplash?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label">
														<input class="form-check-input controller with-font" data-control="bs-detail3" id="backsplash3" name="backsplash3" type="checkbox" value="Yes"></label>
                                                    </div>
													<input class="form-control form-inline col-9 col-lg-10 bs-detail3" id="bs-detail3" name="bs-detail3" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Riser?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label">
														<input class="form-check-input controller with-font" data-control="rs-detail3" id="riser3" name="riser3" type="checkbox" value="Yes"></label>
                                                    </div><input class="form-control form-inline col-9 col-lg-10 rs-detail3" id="rs-detail3" name="rs-detail3" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Sink(s)?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label" for="sinks3">
														<input class="form-check-input controller with-font" data-control="sk-detail3" id="sinks3" name="sinks3" type="checkbox" value="Yes"></label>
                                                    </div><input class="form-control form-inline col-9 col-lg-10 sk-detail3" id="sk-detail3" name="sk-detail3" placeholder="Details/Model" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="range3">Range Type:</label>
                                                <select class="form-control" id="range3" name="range3">
                                                    <option value="None">None</option>
                                                    <option value="Free Standing">Free Standing</option>
                                                    <option value="Cooktop">Cooktop</option>
                                                    <option value="Slide-In">Slide-In</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="model3">Model #:</label>
												<input class="form-control" id="model3" name="model3" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="spread3">Faucet Spread / Holes:</label>
                                                <select class="form-control holeOpt" id="spread3" name="spread3">
                                                    <option value="None">None</option>
                                                    <option value="1 Hole - Center">1 Hole - Center</option>
                                                    <option value="3 Hole - 4 Inch">3 Hole - 4"</option>
                                                    <option value="3 Hole - 8 Inch">3 Hole - 8"</option>
                                                    <option class="controller" data-control="holes3" value="Other">Other Holes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="cutout3">Cutout:</label>
                                                <input class="form-control" id="cutout3" name="cutout3" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 hole3" style="display:none;">
                                        <label for="holes3">Specify other holes needed:</label>
										<input class="form-control" id="holes3" name="holes3" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="notes3">Install Notes:</label> 
                                        <textarea class="form-control" id="notes3" name="notes3" rows="3"></textarea>
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <h2 class="col-10">Attachments</h2>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmenta1">Attachment A</label>
                                        <input class="form-control-file" id="attachmenta1" name="attachmenta1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentb1">Attachment B</label>
                                        <input class="form-control-file" id="attachmentb1" name="attachmentb1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentc1">Attachment C</label>
                                        <input class="form-control-file" id="attachmentc1" name="attachmentc1" type="file">
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 col-md-3">
                                        <button class="btn btn-secondary btn-lg btn-block" data-target="#reset-form" data-toggle="modal" id="clear-form" type="button">Clear</button>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="reset-form" role="dialog" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Clear Form?</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to clear all data from the form?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button">No way!</button> <button class="btn btn-secondary reset-btn" data-dismiss="modal" type="reset">Yes. Delete it all!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>



                    <section class="container align-middle" id="change-order-form" style="display:none;">
                        <div class="row float-right">
                            <div class="close close-form">
                                <i class="fa fa-xl fa-close"></i>
                            </div>
                        </div>
                        <h1 class="head-text">Job Change Order</h1>
                        <form class="row text-left text-dark" id="form2" name="form2">
                        	<input type="hidden" name="form-name" value="Job Change Order">
                            <hr>
                            <h2 class="col-12">Job Details</h2>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="quote-num">Quote #:</label> <input class="form-control" id="quote-num" name="quote-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="order-num">Order #:</label> <input class="form-control" id="order-num" name="order-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="install-date">Install Date:</label> <input class="form-control" id="install-date" name="install-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="template-date">Template Date:</label> <input class="form-control" id="template-date" name="template-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="job-name">Job Name:</label> <input required class="form-control" id="job-name" name="job-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="account-rep">Account Rep:</label>
                                <select class="form-control" id="account-rep" name="account-rep">
                                    <option data-email="" value="none">Unspecified</option>
                                    <option data-email="kclements@amanzigranite.com" value="Kim Clements">Kim Clements</option>
                                    <option data-email="mjones@amanzigranite.com" value="Melissa Jones">Melissa Jones</option>
                                    <option data-email="mmcbride@amanzigranite.com" value="Maureen McBride">Maureen McBride</option>
                                    <option data-email="mmusci@amanzigranite.com" value="Mark Musci">Mark Musci</option>
                                    <option data-email="apalma@amanzigranite.com" value="Alexandra Palma">Alexandra Palma</option>
                                    <option data-email="csheppard@amanzigranite.com" value="Chris Sheppard">Chris Sheppard</option>
                                    <option data-email="ksheppard@amanzigranite.com" value="Kate Sheppard">Kate Sheppard</option>
                                    <option data-email="cwilder@amanzigranite.com" value="Corry Wilder">Corry Wilder</option>
                                    <option data-email="omar@amanzigranite.com" value="Omar Kalaf">Omar Kalaf</option>
                                </select>
                            </fieldset>
                            <input type="hidden" name="repEmail" value="">
                            <fieldset class="form-group col-md-6">
                                <label for="customer-name">Customer Name:</label> <input required class="form-control" id="customer-name" name="customer-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="builder-name">Builder / Cabinet Company:</label> <input class="form-control" id="builder-name" name="builder-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-phone">Customer Phone #:</label> <input class="form-control" id="customer-phone" name="customer-phone" type="tel" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-email">Customer Email:</label> <input class="form-control" id="customer-email" name="customer-email" type="email">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-cost">P.O. Cost:</label> <input class="form-control" id="po-cost" name="po-cost" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-num">P.O. #:</label> <input class="form-control" id="po-num" name="po-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="billing-address">Billing Address:</label> <input class="form-control" id="billing-address" name="billing-address" type="text" data-required="true">
                            </fieldset>
                            <hr>
                            <h2 class="col-12">Site Details</h2>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name">Site Contact:</label> <input class="form-control" id="contact-name" name="contact-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone">Contact Telephone:</label> <input class="form-control" id="contact-phone" name="contact-phone" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name2">Alternative Contact:</label> <input class="form-control" id="contact-name2" name="contact-name2" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone2">Alternative Telephone:</label> <input class="form-control" id="contact-phone2" name="contact-phone2" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="site-address">Site Address:</label> <input class="form-control" id="site-address" name="site-address" type="text">
                            </fieldset>
                            <hr>
                            <h2 class="col-12">Install Details</h2>
                            <fieldset class="form-group col-12">
                                <label for="install1-name">Area/Install Name:</label> <input class="form-control" id="install1-name" name="install1-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6 col-lg-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Job Type:</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label for="job-type1a"><input checked class="form-check-input with-font" id="job-type1a" name="job-type1" type="radio" value="new"><p>New Install</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="job-type1b"><input class="form-check-input with-font" id="job-type1b" name="job-type1" type="radio" value="remodel"><p>Remodel</p></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6 col-lg-2">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Tear Out:</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label for="tear-out1a"><input checked class="form-check-input with-font" id="tear-out1a" name="tear-out1" type="radio" value="Yes"><p>Yes</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="tear-out1b"><input class="form-check-input with-font" id="tear-out1b" name="tear-out1" type="radio" value="no"><p>No</p></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>




                            <!--<fieldset class="form-group col-12 col-lg-6">
                                <label for="material1">Material:</label> <input class="form-control" id="material1" name="material1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                                <label for="color1">Color:</label> <input class="form-control" id="color1" name="color1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="lot1">Lot #:</label> <input class="form-control" id="lot1" name="lot1" type="text">
                            </fieldset>-->

                            <fieldset class="form-group col-12 col-lg-6">
                                <label for="material1">Material:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="material1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                                <label for="color1">Color:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="color1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="lot1">Lot #:</label>
								<input class="form-control matControl" data-control="materialToUse1" id="lot1" type="text">
                            </fieldset>

							<input type="hidden" name="materialToUse1" id="materialToUse1" value="">



                            <fieldset class="form-group col-6 col-md-3">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Customer Selected?</legend>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline col-6">
                                            <label class="selected1a"><input checked class="form-check-input with-font" id="selected1a" name="selected1" type="radio" value="Yes"><p>Yes</p></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="selected1b"><input class="form-check-input with-font" id="selected1b" name="selected1" type="radio" value="no"><p>No</p></label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="edge1">Edge:</label>
								<select class="form-control" id="edge1" name="edge1">
                                    <option value="None">None</option>
                                    <option value="1 inch bevel">1" Bevel</option>
                                    <option value="Half inch bevel">1/2" Bevel</option>
                                    <option value="Quarter inch bevel">1/4" Bevel</option>
                                    <option value="Half Bullnose">Half Bullnose</option>
                                    <option value="Full Bullnose">Full Bullnose</option>
                                    <option value="Demi Bullnose">Demi Bullnose</option>
                                    <option value="Flat">Flat</option>
                                    <option value="Pencil">Pencil</option>
                                    <option value="Heavy Pencil">Heavy Pencil</option>
                                    <option value="Ogee">Ogee</option>
                                    <option value="Other">Other</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Backsplash?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="backsplash1"><input class="form-check-input controller with-font" data-control="bs-detail1" id="backsplash1" name="backsplash1" type="checkbox" value="Yes"></label>
                                            </div><input class="form-control form-inline col-9 col-lg-10 bs-detail1" id="bs-detail1" name="bs-detail1" placeholder="Details" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Riser?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="riser1"><input class="form-check-input controller with-font" data-control="rs-detail1" id="riser1" name="riser1" type="checkbox" value="Yes"></label>
                                            </div><input class="form-control form-inline col-9 col-lg-10 rs-detail1" id="rs-detail1" name="rs-detail1" placeholder="Details" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-6 col-sm-4">
                                <div class="row">
                                    <legend class="col-form-legend col-12">Sink(s)?</legend>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-check form-check-inline col-3 col-lg-2">
                                                <label class="form-check-label" for="sinks1"><input class="form-check-input controller with-font" data-control="sk-detail1" id="sinks1" name="sinks1" type="checkbox" value="Yes"></label>
                                            </div><input class="form-control form-inline col-9 col-lg-10 sk-detail1" id="sk-detail1" name="sk-detail1" placeholder="Details/Model" style="display:none;" type="text">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                                <div class="row">
		                            <div class="form-group col-12">
                                        <label for="range1">Range Type:</label>
                                        <select class="form-control" id="range1" name="range1">
                                            <option value="None">None</option>
                                            <option value="Free Standing">Free Standing</option>
                                            <option value="Cooktop">Cooktop</option>
                                            <option value="Slide-In">Slide-In</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <fieldset class="form-group col-12">
                                        <label for="model1">Model #:</label> <input class="form-control" id="model1" name="model1" type="text">
                                    </fieldset>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 col-md-6">
                            	<div class="row">
		                            <div class="form-group col-12">
                                        <label for="spread1">Faucet Spread / Holes:</label>
                                        <select class="form-control holeOpt" id="spread1" name="spread1">
                                            <option value="None">None</option>
                                            <option value="1 Hole - Center">1 Hole - Center</option>
                                            <option value="3 Hole - 4 Inch">3 Hole - 4"</option>
                                            <option value="3 Hole - 8 Inch">3 Hole - 8"</option>
                                            <option class="controller" data-control="holes1" value="Other">Other Holes</option>
                                        </select>
                                    </div>
                                </div>
                            	<div class="row">
                                    <fieldset class="form-group col-12">
                                        <label for="cutout1">Cutout:</label>
                                        <input class="form-control" id="cutout1" name="cutout1" type="text">
                                    </fieldset>
                                </div>
                            </fieldset>
                            <fieldset class="form-group col-12 hole1" style="display:none;">
                                <label for="holes1">Specify other holes needed:</label>
                                <input class="form-control" id="holes1" name="holes1" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="notes1">Install Notes:</label> 
                                <textarea class="form-control" id="notes1" name="notes1" rows="3"></textarea>
                            </fieldset>
                            <hr>
                            <div class="col-12 btn-surround">
                                <div class="btn btn-dark btn-lg sect-btn sect-add float-right" data-control="install2">
                                    <span>Add additional install</span> <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="col-12 install2" style="display:none">
                                <div class="row">
                                    <h2 class="col-10">Install 2</h2>
                                    <fieldset class="form-group col-12">
                                        <label for="install2-name">Area/Install Name:</label> <input class="form-control" id="install2-name" name="install2-name" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Job Type:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="job-type2a"><input checked class="form-check-input with-font" id="job-type2a" name="job-type2" type="radio" value="new"><p>New Install</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="job-type2b"><input class="form-check-input with-font" id="job-type2b" name="job-type2" type="radio" value="remodel"><p>Remodel</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-2">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Tear Out:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="tear-out2a"><input checked class="form-check-input with-font" id="tear-out2a" name="tear-out2" type="radio" value="Yes"><p>Yes</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="tear-out2b"><input class="form-check-input with-font" id="tear-out2b" name="tear-out2" type="radio" value="no"><p>No</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!--<fieldset class="form-group col-12 col-lg-6">
                                        <label for="material2">Material:</label> <input class="form-control" id="material2" name="material2" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <label for="color2">Color:</label> <input class="form-control" id="color2" name="color2" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-md-3">
                                        <label for="lot2">Lot #:</label> <input class="form-control" id="lot2" name="lot2" type="text">
                                    </fieldset>-->


		
									<fieldset class="form-group col-12 col-lg-6">
										<label for="material2">Material:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="material2" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<label for="color2">Color:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="color2" type="text">
									</fieldset>
									<fieldset class="form-group col-6 col-md-3">
										<label for="lot2">Lot #:</label>
										<input class="form-control matControl" data-control="materialToUse2" id="lot2" type="text">
									</fieldset>
		
									<input type="hidden" name="materialToUse2" id="materialToUse2" value="">



                                    <fieldset class="form-group col-6 col-md-3">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Customer Selected?</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="selected2a"><input checked class="form-check-input with-font" id="selected2a" name="selected2" type="radio" value="Yes"><p>Yes</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="selected2b"><input class="form-check-input with-font" id="selected2b" name="selected2" type="radio" value="no"><p>No</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="edge2">Edge:</label>
										<select class="form-control" id="edge2" name="edge2">
											<option value="None">None</option>
											<option value="1 inch bevel">1" Bevel</option>
											<option value="Half inch bevel">1/2" Bevel</option>
											<option value="Quarter inch bevel">1/4" Bevel</option>
											<option value="Half Bullnose">Half Bullnose</option>
											<option value="Full Bullnose">Full Bullnose</option>
											<option value="Demi Bullnose">Demi Bullnose</option>
											<option value="Flat">Flat</option>
											<option value="Pencil">Pencil</option>
											<option value="Heavy Pencil">Heavy Pencil</option>
											<option value="Ogee">Ogee</option>
											<option value="Other">Other</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Backsplash?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label"><input class="form-check-input controller with-font" data-control="bs-detail2" id="backsplash2" name="backsplash2" type="checkbox"></label>
                                                    </div>
                                                    <input class="form-control form-inline col-9 col-lg-10 bs-detail2" id="bs-detail2" name="bs-detail2" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Riser?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label"><input class="form-check-input controller with-font" data-control="rs-detail2" id="riser2" name="riser2" type="checkbox" value="Yes"></label>
                                                    </div>
                                                    <input class="form-control form-inline col-9 col-lg-10 rs-detail2" id="rs-detail2" name="rs-detail2" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Sink(s)?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label" for="sinks2"><input class="form-check-input controller with-font" data-control="sk-detail2" id="sinks2" name="sinks2" type="checkbox" value="Yes"></label>
                                                    </div>
                                                    <input class="form-control form-inline col-9 col-lg-10 sk-detail2" id="sk-detail2" name="sk-detail2" placeholder="Details/Model" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="range2">Range Type:</label>
                                                <select class="form-control" id="range2" name="range2">
                                                    <option value="None">None</option>
                                                    <option value="Free Standing">Free Standing</option>
                                                    <option value="Cooktop">Cooktop</option>
                                                    <option value="Slide-In">Slide-In</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="model2">Model #:</label> <input class="form-control" id="model2" name="model2" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="spread2">Faucet Spread / Holes:</label>
                                                <select class="form-control holeOpt" id="spread2" name="spread2">
                                                    <option value="None">None</option>
                                                    <option value="1 Hole - Center">1 Hole - Center</option>
                                                    <option value="3 Hole - 4 Inch">3 Hole - 4"</option>
                                                    <option value="3 Hole - 8 Inch">3 Hole - 8"</option>
                                                    <option class="controller" data-control="holes2" value="Other">Other Holes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="cutout2">Cutout:</label>
                                                <input class="form-control" id="cutout2" name="cutout2" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 hole2" style="display:none;">
                                        <label for="holes2">Specify other holes needed:</label> <input class="form-control" id="holes2" name="holes2" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="notes2">Install Notes:</label> 
                                        <textarea class="form-control" id="notes2" name="notes2" rows="3"></textarea>
                                    </fieldset>
                                    <hr>
                                    <div class="col-12 btn-surround">
                                        <div class="btn btn-dark btn-lg sect-btn sect-add float-right" data-control="install3">
                                            <span>Add additional install</span> <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 install3" style="display:none">
                                <div class="row">
                                    <h2 class="col-10">Install 3</h2>
                                    <fieldset class="form-group col-12">
                                        <label for="install3-name">Area/Install Name:</label> <input class="form-control" id="install3-name" name="install3-name" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Job Type:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="job-type3a"><input checked class="form-check-input with-font" id="job-type3a" name="job-type3" type="radio" value="new"><p>New Install</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="job-type3b"><input class="form-check-input with-font" id="job-type3b" name="job-type3" type="radio" value="remodel"><p>Remodel</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6 col-lg-2">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Tear Out:</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="tear-out3a"><input checked class="form-check-input with-font" id="tear-out3a" name="tear-out3" type="radio" value="Yes"><p>Yes</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="tear-out3b"><input class="form-check-input with-font" id="tear-out3b" name="tear-out3" type="radio" value="no"><p>No</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
									<fieldset class="form-group col-12 col-lg-6">
										<label for="material3">Material:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="material3" type="text">
									</fieldset>
									<fieldset class="form-group col-12 col-md-6">
										<label for="color3">Color:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="color3" type="text">
									</fieldset>
									<fieldset class="form-group col-6 col-md-3">
										<label for="lot3">Lot #:</label>
										<input class="form-control matControl" data-control="materialToUse3" id="lot3" type="text">
									</fieldset>
									<input type="hidden" name="materialToUse3" id="materialToUse3" value="">
                                    <fieldset class="form-group col-6 col-md-3">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Customer Selected?</legend>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline col-6">
                                                    <label for="selected3a"><input checked class="form-check-input with-font" id="selected3a" name="selected3" type="radio" value="Yes"><p>Yes</p></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label for="selected3b"><input class="form-check-input with-font" id="selected3b" name="selected3" type="radio" value="no"><p>No</p></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="edge3">Edge:</label>
										<select class="form-control" id="edge3" name="edge3">
											<option value="None">None</option>
											<option value="1 inch bevel">1" Bevel</option>
											<option value="Half inch bevel">1/2" Bevel</option>
											<option value="Quarter inch bevel">1/4" Bevel</option>
											<option value="Half Bullnose">Half Bullnose</option>
											<option value="Full Bullnose">Full Bullnose</option>
											<option value="Demi Bullnose">Demi Bullnose</option>
											<option value="Flat">Flat</option>
											<option value="Pencil">Pencil</option>
											<option value="Heavy Pencil">Heavy Pencil</option>
											<option value="Ogee">Ogee</option>
											<option value="Other">Other</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Backsplash?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label"><input class="form-check-input controller with-font" data-control="bs-detail3" id="backsplash3" name="backsplash3" type="checkbox" value="Yes"></label>
                                                    </div><input class="form-control form-inline col-9 col-lg-10 bs-detail3" id="bs-detail3" name="bs-detail3" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Riser?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label"><input class="form-check-input controller with-font" data-control="rs-detail3" id="riser3" name="riser3" type="checkbox" value="Yes"></label>
                                                    </div><input class="form-control form-inline col-9 col-lg-10 rs-detail3" id="rs-detail3" name="rs-detail3" placeholder="Details" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group col-6 col-sm-4">
                                        <div class="row">
                                            <legend class="col-form-legend col-12">Sink(s)?</legend>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-3 col-lg-2">
                                                        <label class="form-check-label" for="sinks3"><input class="form-check-input controller with-font" data-control="sk-detail3" id="sinks3" name="sinks3" type="checkbox" value="Yes"></label>
                                                    </div><input class="form-control form-inline col-9 col-lg-10 sk-detail3" id="sk-detail3" name="sk-detail3" placeholder="Details/Model" style="display:none;" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="range3">Range Type:</label>
                                                <select class="form-control" id="range3" name="range3">
                                                    <option value="None">None</option>
                                                    <option value="Free Standing">Free Standing</option>
                                                    <option value="Cooktop">Cooktop</option>
                                                    <option value="Slide-In">Slide-In</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="model3">Model #:</label> <input class="form-control" id="model3" name="model3" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-6">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="spread3">Faucet Spread / Holes:</label>
                                                <select class="form-control holeOpt" id="spread3" name="spread3">
                                                    <option value="None">None</option>
                                                    <option value="1 Hole - Center">1 Hole - Center</option>
                                                    <option value="3 Hole - 4 Inch">3 Hole - 4"</option>
                                                    <option value="3 Hole - 8 Inch">3 Hole - 8"</option>
                                                    <option class="controller" data-control="holes3" value="Other">Other Holes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group col-12">
                                                <label for="cutout3">Cutout:</label>
                                                <input class="form-control" id="cutout3" name="cutout3" type="text">
                                            </fieldset>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group col-12 hole3" style="display:none;">
                                        <label for="holes3">Specify other holes needed:</label> <input class="form-control" id="holes3" name="holes3" type="text">
                                    </fieldset>
                                    <fieldset class="form-group col-12">
                                        <label for="notes3">Install Notes:</label> 
                                        <textarea class="form-control" id="notes3" name="notes3" rows="3"></textarea>
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <h2 class="col-10">Attachments</h2>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmenta1">Attachment A</label>
                                        <input class="form-control-file" id="attachmenta1" name="attachmenta1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentb1">Attachment B</label>
                                        <input class="form-control-file" id="attachmentb1" name="attachmentb1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentc1">Attachment C</label>
                                        <input class="form-control-file" id="attachmentc1" name="attachmentc1" type="file">
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 col-md-3">
                                        <button class="btn btn-secondary btn-lg btn-block" data-target="#reset-form" data-toggle="modal" id="clear-form" type="button">Clear</button>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="reset-form" role="dialog" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Clear Form?</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to clear all data from the form?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button">No way!</button> <button class="btn btn-secondary reset-btn" data-dismiss="modal" type="reset">Yes. Delete it all!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>




                    <section class="container align-middle" id="service-ticket-form" style="display:none;">
                        <div class="row float-right">
                            <div class="close close-form">
                                <i class="fa fa-xl fa-close"></i>
                            </div>
                        </div>
                        <h1 class="head-text">Service Ticket</h1>
                        <form class="row text-left text-dark" id="form3" name="form3">
                        	<input type="hidden" name="form-name" value="Service Ticket">
                            <hr>
                            <h2 class="col-12">Job Details</h2>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="quote-num">Quote #:</label> <input class="form-control" id="quote-num" name="quote-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="order-num">Order #:</label> <input class="form-control" id="order-num" name="order-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="install-date">Install Date:</label> <input class="form-control" id="install-date" name="install-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="template-date">Template Date:</label> <input class="form-control" id="template-date" name="template-date" type="date">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="job-name">Job Name:</label> <input required class="form-control" id="job-name" name="job-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="account-rep">Account Rep:</label>
                                <select class="form-control" id="account-rep" name="account-rep">
                                    <option data-email="" value="none">Unspecified</option>
                                    <option data-email="kclements@amanzigranite.com" value="Kim Clements">Kim Clements</option>
                                    <option data-email="mjones@amanzigranite.com" value="Melissa Jones">Melissa Jones</option>
                                    <option data-email="mmcbride@amanzigranite.com" value="Maureen McBride">Maureen McBride</option>
                                    <option data-email="mmusci@amanzigranite.com" value="Mark Musci">Mark Musci</option>
                                    <option data-email="apalma@amanzigranite.com" value="Alexandra Palma">Alexandra Palma</option>
                                    <option data-email="csheppard@amanzigranite.com" value="Chris Sheppard">Chris Sheppard</option>
                                    <option data-email="ksheppard@amanzigranite.com" value="Kate Sheppard">Kate Sheppard</option>
                                    <option data-email="cwilder@amanzigranite.com" value="Corry Wilder">Corry Wilder</option>
                                    <option data-email="omar@amanzigranite.com" value="Omar Kalaf">Omar Kalaf</option>
                                </select>
                            </fieldset>
                            <input type="hidden" name="repEmail" value="">
                            <fieldset class="form-group col-md-6">
                                <label for="customer-name">Customer Name:</label> <input required class="form-control" id="customer-name" name="customer-name" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="builder-name">Builder / Cabinet Company:</label> <input class="form-control" id="builder-name" name="builder-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-phone">Customer Phone #:</label> <input required class="form-control" id="customer-phone" name="customer-phone" type="tel" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="customer-email">Customer Email:</label> <input required class="form-control" id="customer-email" name="customer-email" type="email">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-cost">P.O. Cost:</label> <input class="form-control" id="po-cost" name="po-cost" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-num">P.O. #:</label> <input class="form-control" id="po-num" name="po-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="billing-address">Billing Address:</label> <input class="form-control" id="billing-address" name="billing-address" type="text">
                            </fieldset>
                            <hr>
                            <h2 class="col-12">Site Details</h2>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name">Site Contact:</label> <input class="form-control" id="contact-name" name="contact-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone">Contact Telephone:</label> <input class="form-control" id="contact-phone" name="contact-phone" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name2">Alternative Contact:</label> <input class="form-control" id="contact-name2" name="contact-name2" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone2">Alternative Telephone:</label> <input class="form-control" id="contact-phone2" name="contact-phone2" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="site-address">Site Address:</label> <input class="form-control" id="site-address" name="site-address" type="text">
                            </fieldset>
                            <hr>

                            <h2 class="col-12">Report Issue</h2>
                            <fieldset class="form-group col-12">
                                <label for="service-report">Please give specifics:</label> 
                                <textarea class="form-control" id="service-report" name="service-report" rows="3" data-required="true" required></textarea>
                            </fieldset>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <h2 class="col-10">Attachments</h2>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmenta1">Attachment A</label>
                                        <input class="form-control-file" id="attachmenta1" name="attachmenta1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentb1">Attachment B</label>
                                        <input class="form-control-file" id="attachmentb1" name="attachmentb1" type="file">
                                    </fieldset>
                                    <fieldset class="form-group col-12 col-md-4">
                                        <label for="attachmentc1">Attachment C</label>
                                        <input class="form-control-file" id="attachmentc1" name="attachmentc1" type="file">
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 col-md-3">
                                        <button class="btn btn-secondary btn-lg btn-block" data-target="#reset-form3" data-toggle="modal" id="clear-form" type="button">Clear</button>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div aria-hidden="true" aria-labelledby="modalLabe3" class="modal fade" id="reset-form3" role="dialog" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabe3">Clear Form?</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to clear all data from the form?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button">No way!</button><button id="rst3" class="btn btn-secondary reset-btn" data-dismiss="modal" type="reset">Yes. Delete it all!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>



                    <section class="container align-middle" id="my-projects-form" style="display:none;">
                        <div class="row float-right">
                            <div class="close close-form">
                                <i class="fa fa-xl fa-close"></i>
                            </div>
                        </div>
                        <h1 class="head-text">Live Projects</h1>
						<p class="text-dark">Please enter your login information.</p>
                        <form id="login-form">
						<div class="row">
							<div class="col col-md-2"></div>
							<div class="col-md-8">
								<fieldset class="form-group col-12">
									<div class="row">
										<div class="col-6">
											<input type="text" class="form-control" name="username" id="username" placeholder="Email">
										</div>
										<div class="col-6">
											<input type="password" class="form-control" name="password" id="password" placeholder="Password">
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-12">
									<div class="row">
										<div class="col">
											<button class="btn btn-lg btn-primary col" type="submit">Login</button>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="col col-md-2"></div>
						</div>							
						</form>
                    </section>

                    <div class="mastfoot">
                        <div class="inner">
                            <p>For existing Clients of <a href="https://amanzigranite.com">Amanzi Marble, Granite and Tile</a>.</p>
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
                <h5 class="modal-title" id="modalLabe3">Submitted!</h5>
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
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
<script type="text/javascript" src="js/functions1.js"></script>
<script>
addToHomescreen();





$(document).ready(function(){    
    //loadstation();
	var formID = Math.random().toString().slice(2,11);
	$('#formID').val(formID);

	function getDate() {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
		today = yyyy+""+mm+""+dd;
	
		document.getElementById("todayDate").value = today;
	}

	//call getDate() when loading the page
	getDate();

});

function loadstation(){
    $("#station_data").load("userlist.php");
}
</script>
</body>
</html>