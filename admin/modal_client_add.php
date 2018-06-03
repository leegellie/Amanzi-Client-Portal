<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="addClientLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title">Add New Client</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h1>Add New User</h1>
					</div>
					<form name="user_data" id="user_data" action="#" class="AdvancedForm row">
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>User Role:</p>
								</div>
								<div class="col-7 p-0">
									<div id="user_typeDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="user_type" id="user_type" data-transform="input-control">
											<option value="0" selected>Select User Type</option> 
	
											<?
												if ($_SESSION['access_level'] == 1) {
					
													echo '<option value="0" disabled>&nbsp;&nbsp;Internal Employees</option>';
													$internal_user_roles = new user_action;
													$rows = $internal_role_rows = $internal_user_roles->get_user_roles("1","0");
													foreach ($rows as $row) {
														echo "<option value='$row[0]'>$row[2]</option>";
													}
													echo '<option value="0" disabled></option>';
													echo '<option value="0" disabled>&nbsp;&nbsp;External Customers</option>';
												}
												$internal_user_roles = new user_action;
												$rows = $internal_role_rows = $internal_user_roles->get_user_roles("0","1");
												foreach ($rows as $row) {
													echo "<option value='$row[0]'>$row[2]</option>";
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Username: </p>
								</div>
								<div class="col-7 p-0">
									<div id="usernameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="username" id="username" type="text" value="" data-transform="input-control"> <span id="usernameError"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-3 ">
									<p>Discount %: </p>
								</div>
								<div class="col-3 ">
									<input class="form-control" name="discount" id="discount"  type='number' step='0.01' value='0.00' data-transform="input-control">
									<span id="usernameError"></span>
								</div>
								<div class="col-3 ">
									<p>Qtz Disc. %: </p>
								</div>
								<div class="col-3 ">
									<input class="form-control" name="discount_quartz" id="discount_quartz" step='0.01' value='0.00' data-transform="input-control">
									<span id="usernameError"></span>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Password: </p>
								</div>
								<div class="col-7 p-0">
									<div id="passwordDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="password" id="password" type="password" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Verify Password: </p>
								</div>
								<div class="col-7 p-0">
									<div id="v_passwordDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="v_password" id="v_password" type="password" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 p-0">
							<h4>Contact Info:</h4>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>First Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="fnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="fname" id="fname" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Last Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="lnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="lname" id="lname" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Company: </p>
								</div>
								<div class="col-7 p-0">
									<div id="companyDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="company" id="company" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Email: </p>
								</div>
								<div class="col-7 p-0">
									<div id="emailDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="email" id="email" value="" data-transform="input-control">
										<span id="emailError"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Phone: </p>
								</div>
								<div class="col-7 p-0">
									<div id="phoneDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="phone" id="phone" value="" data-transform="input-control" placeholder="Just number, no spaces or format">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Address:</p>
								</div>
								<div class="col-7 p-0">
									<div id="address1DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="address1" id="address1" value="" data-transform="input-control">
									</div>
									<div id="address2DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="address2" id="address2" value="" placeholder="Optional" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>City: </p>
								</div>
								<div class="col-7 p-0">
									<div id="cityDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="city" id="city" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>State: </p>
								</div>
								<div class="col-7 p-0">
									<div id="stateDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="state" id="state" value="" data-transform="input-control">
											<option value="" selected>Choose a State</option>
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
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Zip: </p>
								</div>
								<div class="col-7 p-0">
									<div id="zipDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="zip" id="zip" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<input name="action" id="action" type="hidden" value="add_user_data">
							<input name="submit" class="btn btn-primary float-right" id="FormSubmit" type="submit" value="Add User" data-transform="input-control">
							<span id="user_email_error"></span>
						</div>
					</form>
					<form name="user_billing" id="user_billing" action="#" class="row pl-3" style="display: none">
						<div class="col-12 p-0">
							<h4>Billing Information:</h4>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-7 p-0">
									<p style="font-weight:bold">Same as User Account?</p>
								</div>
								<div class="col-5 p-0">
									<div style="display:inline-block" class="input-control switch margin10" data-role="input-control">
										<label style="display:inline-block">
											<input class="with-font" style="display:inline-block" id="sameAdd" name="sameAdd" type="checkbox" value="sameAs" data-transform="input-control" data-transform-type="switch" onChange="autoFillBilling()">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_fnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_name" id="billing_name" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Company: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_companyDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_company" id="billing_company" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Address: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_address1DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_address1" id="billing_address1" value="" data-transform="input-control">
									</div>
									<div id="billing_address2DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_address2" id="billing_address2" placeholder="Optional" value="" data-transform="input-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>City: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_cityDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_city" id="billing_city" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>State: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_stateDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="billing_state" id="billing_state" value="" data-transform="input-control">
											<option value="" selected>Choose a State</option>
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
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Zip: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_zipDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_zip" id="billing_zip" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<input name="action" id="action" type="hidden" value="add_user_billing">
							<input name="uid" id="uid" type="hidden" value="">
							<input name="submit" class="btn btn-primary float-right" id="BillingSubmit" type="submit" value="Save Billing Data" data-transform="input-control">
						</div>
					</form>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>