<div class="modal fade" id="editPjt">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="pjt_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">

					<form id="editPjtOne" class="row">
						<input type="hidden" id="p-pid" name="id" value="">
						<input type="hidden" id="p-uid" name="uid" value="">
						<input type="hidden" id="p-job_lat" name="job_lat">
						<input type="hidden" id="p-job_long" name="job_long">

						<input type="hidden" id="p-job_sqft">


						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-md-4">
									<label for="job-name">Job Name:</label>
									<input required class="form-control" id="p-job_name" name="job_name" type="text" data-required="true">
                  <input type="text" class="form-control" id="p-geo-lat" hidden>
                  <input type="text" class="form-control" id="p-geo-long" hidden>
                  <input type="text" class="form-control" id="p-job-sqft" hidden>
								</fieldset>
								<fieldset class="form-group col-md-3">
									<label for="account-rep">Account Rep:</label>
									<select class="mdb-select md-form colorful-select dropdown-primary" id="p-acct_rep" name="acct_rep">
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

								<fieldset class="form-group col-6 col-md-2">
									<label for="quote-num">Quote #:</label>
									<input class="form-control text-center" id="p-quote_num" name="quote_num" type="text">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="order-num">Order #:</label>
									<input class="form-control text-center" id="p-order_num" name="order_num" type="text">
								</fieldset>
								<fieldset class="form-check col-4 col-md-1">
									<input id="p-isActive" class="form-check-input filled-in form-check-input" name="isActive" type="checkbox" value="1">
									<label for="p-isActive" class="w-100">Active?</label>
								</fieldset>




							</div>
						</div>

						<div class="container pt-3 mb-3">
							<div class="row">
								<fieldset class="form-group col-4 col-md-2 ">
									<input class="filled-in form-check-input mr-4" name="urgent" id="p-urgent" type="checkbox" value="1">
									<label for="p-urgent" class="w-100 ">911?:</label>
									<input class="filled-in form-check-input mr-4" name="tax_free" id="p-tax_free" type="checkbox" value="1">
									<label for="p-tax_free" class="w-100 ">No Tax:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<label class="w-100" for="job_tax">Tax Rate:</label>
									<input class="form-control text-center" name="job_tax" id="p-job_tax" type="text">
								</fieldset>
								<fieldset class="form-group col-md-2">
									<label for="builder-name">Company:</label>
									<input class="form-control" id="p-builder" name="builder" type="text">
								</fieldset>
								<fieldset class="form-check col-md-2">
									<label for="p-job_discount" class="w-100">Job Discount:</label>
									<input id="p-job_discount" class="form-control text-center" name="job_discount" type="text" value="0">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="po-cost">Deposit Paid:</label>
									<input class="form-control currency" id="p-po_cost" name="po_cost" type="text">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="po-num">P.O. #:</label>
									<input class="form-control" id="p-po_num" name="po_num" type="text">
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="site-address">Site Address:</label>
									<input class="form-control addChg" id="p-address_1" name="address_1" type="text">
								</fieldset>
								<fieldset class="form-group col-12">
									<input class="form-control addChg" id="p-address_2" name="address_2" type="text">
								</fieldset>
								<fieldset class="form-group col-md-4">
									<label for="site-address">City:</label>
									<input class="form-control addChg" id="p-city" name="city" type="text">
								</fieldset>
								<fieldset class="form-group col-8 col-md-3">
									<label for="site-address">State:</label>
									<select class="mdb-select md-form colorful-select dropdown-primary addChg" id="p-state" name="state">
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
										<option value="NC">North Carolina</option>
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
									<input class="form-control addChg" id="p-zip" name="zip" type="text">
								</fieldset>
								<div class="col-3">
									<div class="w-100 btn btn-primary addLU" onClick="check_address()">Address Lookup <i class="fas fa-search"></i></div>
									<div class="w-100 btn btn-success addVF hidden">Address Located <i class="fas fa-check"></i></div>
									<div class="w-100 btn btn-danger addFA hidden">Address Failed <i class="fas fa-times"></i></div>
								</div>
								<fieldset class="form-group col-12">
									<label for="address_notes"><b>Address Notes:</b></label>
									<textarea class="form-control" id="p-address_notes" name="address_notes" type="text" rows="2"></textarea>
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3">
							<div class="row">
								<fieldset class="form-group col-6 col-md-6">
									<div class="container">
										<div class="row">
											<label class="col-md-5" for="template-date">Template Date:</label>
											<!--<input class="col-md-7 form-control" id="p-template_date" name="template_date" type="date">-->
											<input class="col-md-7 form-control datepicker" type="text" id="p-template_date" name="template_date">
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" id="p-temp_am" name="temp_am" type="checkbox" value="1">
									<label for="p-temp_am">AM?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" id="p-temp_first_stop" name="temp_first_stop" type="checkbox" value="1">
									<label for="p-temp_first_stop">1st Stop?:</label>
								</fieldset>
		
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" id="p-temp_pm" name="temp_pm" type="checkbox" value="1">
									<label for="p-temp_pm">PM?:</label>
								</fieldset>
								<hr>
								<fieldset class="form-group col-6 col-md-6">
									<div class="container">
										<div class="row">
											<label class="col-md-5" for="install-date">Install Date:</label>
											<input class="col-md-7 form-control datepicker1" type="text" id="p-install_date" name="install_date">
											<!--<input class="col-md-7 form-control" id="p-install_date" name="install_date" type="date">-->
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" name="am" id="p-am" type="checkbox" value="1">
									<label for="p-am">AM?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" name="first_stop" id="p-first_stop" type="checkbox" value="1">
									<label for="p-first_stop">1st Stop?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in form-check-input" name="pm" id="p-pm" type="checkbox" value="1">
									<label for="p-pm">PM?:</label>
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-md-6">
									<label for="contact-name">Site Contact:</label>
									<input class="form-control" id="p-contact_name" name="contact_name" type="text" placeholder="Name">
									<!--<label for="contact-phone">Contact Telephone:</label>-->
									<input class="form-control" id="p-contact_number" name="contact_number" type="tel" placeholder="phone">
									<!--<label for="contact-phone">Contact Email:</label>-->
									<input class="form-control" id="p-contact_email" name="contact_email" type="email" placeholder="email">
								</fieldset>
								<fieldset class="form-group col-md-6">
									<label for="contact-name2">Alternative Contact:</label>
									<input class="form-control" id="p-alternate_name" name="alternate_name" type="text" placeholder="Name">
									<!--<label for="contact-phone2">Alternative Telephone:</label>-->
									<input class="form-control" id="p-alternate_number" name="alternate_number" type="tel" placeholder="phone">
									<!--<label for="contact-phone2">Alternative Email:</label>-->
									<input class="form-control" id="p-alternate_email" name="alternate_email" type="email" placeholder="email">
								</fieldset>
							</div>
						</div>


						<fieldset class="form-group col-12">
							<label for="site-address">Job Notes:</label>
							<textarea class="form-control" id="p-job_notes" name="job_notes" type="text" rows="4"></textarea>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
							</label>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
								<input class="col-6 mb-2" onChange="addUpload(this);" name="imgUploads[]" type="file">
							</label>
						</fieldset>
						<div class="col-12 mt-2 form-box">
							<div class="row">
								<input id="p-action" name="action" type="hidden" value="update_project_data"><br>
								<div class="btn btn-primary" name="pjtUpdate" id="pjtUpdate" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Update Project</div>
							</div>
						</div>
					</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>