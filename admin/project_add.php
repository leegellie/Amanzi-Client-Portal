<?PHP include ('pj_menu_pages.php'); ?>
<div class="container pageLook">
	<div class="row">

            <div class="col-12" style="margin-left:0">
				<div id="addProject_wrapper">
        	        <div id="step1container">
            	        <div class="notice marker-on-bottom bg-lightBlue" href="#">
                	    	<h2 class="">Add Project</h2>
                    	</div>
                        <div id="project-block" class="content">
                            <form id="add_project" enctype="multipart/form-data">
								<div class="container pb-3">
									<ul class="nav nav-tabs md-tabs nav-justified blue-gradient darken-3" role="tablist">
										<li class="nav-item"><a onClick="proj_type('new');" class="nav-link active text-white" data-toggle="tab" href="#panel_new" role="tab">New Project</a></li>
										<li class="nav-item"><a onClick="proj_type('add');" class="nav-link text-white" data-toggle="tab" href="#panel_addition" role="tab">Addition</a></li>
										<li class="nav-item"><a onClick="proj_type('rew');" class="nav-link text-white" data-toggle="tab" href="#panel_rework" role="tab">Rework</a></li>
										<li class="nav-item"><a onClick="proj_type('rep');" class="nav-link text-white" data-toggle="tab" href="#panel_repair" role="tab">Repair</a></li>
									</ul>
									<div class="tab-content px-0">
										<div class="tab-pane fade in show active" id="panel_new" role="tabpanel"></div>
										<div class="tab-pane fade" id="panel_addition" role="tabpanel"></div>
										<div class="tab-pane fade" id="panel_rework" role="tabpanel"></div>
										<div class="tab-pane fade" id="panel_repair" role="tabpanel"></div>
									</div>
									<div class="row">
										<fieldset class="form-group col-4 col-md-3 text-left">
											<input class="filled-in form-check-input mr-4" name="no_charge" id="no_charge" type="checkbox" value="1">
											<label for="no_charge" class="text-left">No Charge</label>
										</fieldset>
										<fieldset class="form-group col-4 col-md-2 text-left servoption reoption">
											<input class="filled-in form-check-input mr-4" name="call_out_fee" id="call_out_fee" type="checkbox" value="1">
											<label for="call_out_fee" class="text-left">Call Out Fee</label>
										</fieldset>
										<fieldset class="input-group col-md-2 servoption reoption addoption">
											<label for="job_discount" class="w-100">Original Job #:</label>
											<div class="row">
												<div class="input-group mb-3">
													<input type="text" id="job_lookup" class="form-control" aria-label="Original Job Number" aria-describedby="search_jobs">
													<div class="input-group-append">
														<span class="input-group-text bg-primary text-white" onClick="job_lookup($('#job_lookup').val())" id="search_jobs" style="cursor:pointer;z-index: 4;"><i class="icon-search"></i></span>
													</div>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group col-4 col-md-2 text-left servoption reoption">
											<label for="responsible" class="text-left">Who is responsible</label>
											<select class="mdb-select md-form colorful-select dropdown-primary" name="responsible" id="responsible">
												<option value="0">Select one</option>
												<option value="11">Customer</option>
												<option value="2">Sales</option>
												<option value="3">Entry</option>
												<option value="4">Templaters</option>
												<option value="5">Programming</option>
												<option value="6">Materials</option>
												<option value="7">Saw</option>
												<option value="8">Montissor/CNC</option>
												<option value="9">Polishing</option>
												<option value="10">Installers</option>
												<option value="99">Unknown</option>
											</select>
										</fieldset>
										<fieldset class="form-group col-12 col-md-6 text-left servoption reoption reason">
											<label for="reason" class="text-left w-100">Please detail the reason for Repair/Rework/No-Charge</label>
											<textarea class="filled-in form-check-input rounded mr-4 w-100" name="reason" id="reason"></textarea>
										</fieldset>
									</div>

									<hr>

									<div class="row">
										<div class="col-12 col-md-2 mt-2 form-label">
											<h4>CLIENT: </h4>
										</div>
										<div class="col-12 col-md-7 mt-2 form-box">
											<div id="user_infoDIV" class="input-control text input-box" data-role="input-control">
												<input class="form-control" id="user_info" name="user_info" type="text" value="" disabled>
												<input id="uid" name="uid" type="hidden" value="">
												<input type="hidden" id="repair" name="repair" value="0">
												<input type="hidden" id="rework" name="rework" value="0">
												<input type="hidden" id="addition" name="addition" value="0">
												<input type="hidden" id="job_lat" name="job_lat">
												<input type="hidden" id="job_long" name="job_long">
												<input type="hidden" id="address_verif" name="address_verif" value="0">
												<input type="hidden" id="install_team" name="install_team" value="0">
											</div>
										</div>
										<div class="col-3 pt-1">
											<button class="btn btn-primary w-100" id="searchUser" style="height:36px; font-size: x-large;padding-top: 0;"  data-toggle="modal" data-target="#selectCompany">Select <i class="icon-search"></i></button>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
										<div class="row">
											<fieldset class="form-group col-md-6">
												<label for="job-name">Job Name:</label>
												<input required class="form-control" id="job_name" name="job_name" type="text" data-required="true">
												<input type="text" class="form-control" id="p-geo-lat" hidden>
												<input type="text" class="form-control" id="p-geo-long" hidden>
												<input type="text" class="form-control" id="p-job-sqft" hidden>
											</fieldset>
											<fieldset class="form-group col-md-6">
												<label for="account-rep">Account Rep:</label>
												<select class="mdb-select md-form colorful-select dropdown-primary" id="acct_rep" name="acct_rep">
													<option value="0">Unspecified</option>
<?
	$uOptions = ''; 
	$salesReps = new project_action; 
	foreach($salesReps->get_reps() as $results) {
		$uOptions .= '<option value="' . $results['id'] . '">' . $results['fname'] . ' ' . $results['lname'] . '</option>'; 
	} 
	echo $uOptions; 
?>
												</select>
											</fieldset>
											<fieldset class="form-group col-md-6">
												<label for="builder-name">Builder / Cabinet Company:</label>
												<input class="form-control" id="builder" name="builder" type="text">
											</fieldset>
											<fieldset class="form-group col-6 col-md-3">
												<label for="po-cost">Deposit Paid:</label>
												<input class="form-control" id="po_cost" name="po_cost" type="text" 
<? 
													if ($_SESSION['access_level'] != 1 && $_SESSION['access_level'] != 3) {
													    echo ' readonly data="' . $_SESSION['access_level'] . '"';
													   }
?>
													   >
											</fieldset>
											<fieldset class="form-group col-6 col-md-3">
												<label for="po-num">P.O. #:</label>
												<input class="form-control" id="po_num" name="po_num" type="text">
											</fieldset>
										</div>
									</div>
									<fieldset class="form-group col-4 col-md-2 text-center">
										<input class="filled-in form-check-input mr-4" name="urgent" id="urgent" type="checkbox" value="1">
										<label for="urgent" class="w-100 text-center">911?:</label>
										<input class="filled-in form-check-input mr-4" name="tax_free" id="tax_free" type="checkbox" value="1">
										<label class="w-100 text-center" for="tax_free">No Tax:</label>
									</fieldset>

									<fieldset class="form-group col-4 col-md-2">
										<label class="w-100 text-center" for="job_tax">Tax Rate:</label>
										<input class="form-control" name="job_tax" id="job_tax" type="text" value="6.75">
									</fieldset>
			
									<fieldset class="form-check col-md-2">
										<label for="job_discount" class="w-100">Job Discount:</label>
										<input id="job_discount" class="form-control" name="job_discount" type="text" value="0">
									</fieldset>
		
									<fieldset class="form-group col-3 col-md-2">
										<label for="quote-num">Quote #:</label>
										<input class="form-control" id="quote_num" name="quote_num" type="text">
									</fieldset>
									<fieldset class="form-group col-3 col-md-2">
										<label for="order-num">Order #:</label>
										<input class="form-control" id="order_num" name="order_num" type="text">
									</fieldset>
									<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
										<div class="row">
											<fieldset class="form-group col-12">
												<label for="site-address">Site Address:</label>
												<input class="form-control" id="address_1" name="address_1" type="text">
											</fieldset>
											<fieldset class="form-group col-12">
												<input class="form-control" id="address_2" name="address_2" type="text">
											</fieldset>
											<fieldset class="form-group col-md-4">
												<label for="site-address">City:</label>
												<input class="form-control" id="city" name="city" type="text">
											</fieldset>
											<fieldset class="form-group col-8 col-md-3">
												<label for="site-address">State:</label>
												<select class="mdb-select md-form colorful-select dropdown-primary" id="state" name="state">
													<option value="AL">Alabama</option>
													<option value="AK">Alaska</option>
													<option value="AZ">Arizona</option>
													<option value="AR">Arkansas</option>
													<option value="CA">California</option>
													<option value="CO">Colorado</option>
													<option value="CT">Connecticut</option>
													<option value="DE">Delaware</option>
													<option value="DC">District Of Columbia</option>
													<option value="FL">Florida</option>
													<option value="GA">Georgia</option>
													<option value="HI">Hawaii</option>
													<option value="ID">Idaho</option>
													<option value="IL">Illinois</option>
													<option value="IN">Indiana</option>
													<option value="IA">Iowa</option>
													<option value="KS">Kansas</option>
													<option value="KY">Kentucky</option>
													<option value="LA">Louisiana</option>
													<option value="ME">Maine</option>
													<option value="MD">Maryland</option>
													<option value="MA">Massachusetts</option>
													<option value="MI">Michigan</option>
													<option value="MN">Minnesota</option>
													<option value="MS">Mississippi</option>
													<option value="MO">Missouri</option>
													<option value="MT">Montana</option>
													<option value="NE">Nebraska</option>
													<option value="NV">Nevada</option>
													<option value="NH">New Hampshire</option>
													<option value="NJ">New Jersey</option>
													<option value="NM">New Mexico</option>
													<option value="NY">New York</option>
													<option value="NC" selected>North Carolina</option>
													<option value="ND">North Dakota</option>
													<option value="OH">Ohio</option>
													<option value="OK">Oklahoma</option>
													<option value="OR">Oregon</option>
													<option value="PA">Pennsylvania</option>
													<option value="RI">Rhode Island</option>
													<option value="SC">South Carolina</option>
													<option value="SD">South Dakota</option>
													<option value="TN">Tennessee</option>
													<option value="TX">Texas</option>
													<option value="UT">Utah</option>
													<option value="VT">Vermont</option>
													<option value="VA">Virginia</option>
													<option value="WA">Washington</option>
													<option value="WV">West Virginia</option>
													<option value="WI">Wisconsin</option>
													<option value="WY">Wyoming</option>
												</select>
											</fieldset>
											<fieldset class="form-group col-4 col-md-2">
												<label for="site-address">Zip:</label>
												<input class="form-control addChg" id="zip" name="zip" type="text">
											</fieldset>
											<div class="col-3 pt-4">
												<div class="btn btn-primary w-100 addLU" onclick="check_address()">Address Lookup <i class="fas fa-search"></i></div>
												<div class="btn btn-success w-100 addVF hidden">Address Located <i class="fas fa-check"></i></div>
												<div class="btn btn-danger w-100 addFA hidden">Address Failed <i class="fas fa-times"></i></div>
											</div>
											<fieldset class="form-group col-12">
												<label for="address_notes"><b>Address Notes:</b></label>
												<textarea class="form-control" id="address_notes" name="address_notes" type="text" rows="2"></textarea>
											</fieldset>
										</div>
									</div>
									<fieldset class="form-group col-12 col-md-4">
										<div class="container">
											<div class="row">
												<label class="col-md-4" for="template-date">Template Date:</label>											
												<div class="input-group mb-3 col-md-8">
													<input class=" form-control datepicker" type="text" id="template_date" name="template_date" autocomplete="off">
													<div class="input-group-append" onClick="$('#template_date').val('')" style="cursor: pointer; height:38px">
														<span class="input-group-text text-danger"><i class="fas fa-times"></i></span>
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" id="temp_am" name="temp_am" type="checkbox" value="1">
										<label for="temp_am">AM</label>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" id="temp_first_stop" name="temp_first_stop" type="checkbox" value="1">
										<label for="temp_first_stop">1<sup>st</sup> Stop</label>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" id="temp_pm" name="temp_pm" type="checkbox" value="1">
										<label for="temp_pm">PM?</label>
									</fieldset>
									<fieldset class="form-group col text-left">
										<input class="filled-in form-check-input mr-4" name="in_house_template" id="in_house_template" type="checkbox" value="1">
										<label for="in_house_template" class="text-left">In-House</label>
									</fieldset>
									<fieldset class="form-group col text-left">
										<input class="filled-in form-check-input mr-4" name="no_template" id="no_template" type="checkbox" value="1">
										<label for="no_template" class="text-left">No Templ.</label>
									</fieldset>
									<hr>

									<fieldset class="form-group col-12 col-md-4">
										<div class="container">
											<div class="row">
												<label class="col-md-4" for="install-date">Install Date:</label>
												<div class="input-group mb-3 col-md-8">
													<input class=" form-control datepicker" type="text" id="install_date" name="install_date" autocomplete="off">
													<div class="input-group-append" onClick="$('#install_date').val('')" style="cursor: pointer; height:38px">
														<span class="input-group-text text-danger"><i class="fas fa-times"></i></span>
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" name="am" id="am" type="checkbox" value="1">
										<label for="am">AM</label>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" name="first_stop" id="first_stop" type="checkbox" value="1">
										<label for="first_stop">1<sup>st</sup> Stop</label>
									</fieldset>
									<fieldset class="form-group col">
										<input class="filled-in form-check-input" name="pm" id="pm" type="checkbox" value="1">
										<label for="pm">PM</label>
									</fieldset>
									<fieldset class="form-group col text-left">
										<input class="filled-in form-check-input mr-4" name="pick_up" id="pick_up" type="checkbox" value="1">
										<label for="pick_up" class="text-left">Pick Up</label>
									</fieldset>
	
									
									<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
										<div class="row">
											<fieldset class="form-group col-md-6">
												<label for="contact-name">Site Contact:</label>
												<input class="form-control" id="contact_name" name="contact_name" type="text" placeholder="Name">
												<!--<label for="contact-phone">Contact Telephone:</label>-->
												<input class="form-control" id="contact_number" name="contact_number" type="tel" placeholder="phone">
												<!--<label for="contact-phone">Contact Email:</label>-->
												<input class="form-control" id="contact_email" name="contact_email" type="email" placeholder="email">
											</fieldset>
											<fieldset class="form-group col-md-6">
												<label for="contact-name2">Alternative Contact:</label>
												<input class="form-control" id="alternate_name" name="alternate_name" type="text" placeholder="Name">
												<!--<label for="contact-phone2">Alternative Telephone:</label>-->
												<input class="form-control" id="alternate_number" name="alternate_number" type="tel" placeholder="phone">
												<!--<label for="contact-phone2">Alternative Email:</label>-->
												<input class="form-control" id="alternate_email" name="alternate_email" type="email" placeholder="email">
											</fieldset>
										</div>
									</div>
									<fieldset class="form-group col-12">
										<label for="site-address">Notes:</label>
										<textarea class="form-control" id="job_notes" name="job_notes" type="text" rows="4"></textarea>
									</fieldset>
									<fieldset class="form-group container">
										<label id="uploadContain" class="row" for="imgUploads">
										</label>
									</fieldset>
									<div class="col-12 mt-2 form-box">
										<div class="row">
											<input id="isActive" name="isActive" type="hidden" value="1">
											<input id="action" name="action" type="hidden" value="add_project_step1"><br>
											<div class="btn btn-primary" name="add_pjt_btn" id="add_pjt_btn" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Add Installs</div>
										</div>
									</div>
								</div>
                            </form>
                        </div>
					</div>
				</div>
            </div>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#add_project").submit(function(e) {
		e.preventDefault();
	});

	addUpload();
	//$('#uploadContain').children().change(function(){
	//	addUpload();
	//});

	
});
</script>
