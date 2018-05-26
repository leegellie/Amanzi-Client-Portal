						<hr>
						<h2 class="col-12">Add Customer</h2>
                        <form class="row text-left text-dark" id="form1" name="form1">
					    	<input type="hidden" name="formID" id="formID" value="">
							<input type="hidden" name="startdate" id="todayDate"/>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="firstname">Customer Name:</label>
								<input required class="form-control" id="firstname" name="firstname" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="lastname">Customer Name:</label>
								<input required class="form-control" id="lastname" name="lastname" type="text" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="phone">Customer Phone Number:</label>
								<input required class="form-control" id="phone" name="phone" type="tel" data-required="true">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="email">Customer Email:</label>
								<input required class="form-control" id="email" name="email" type="email">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="account-rep">Account Rep:</label>
								<select class="form-control" id="rep" name="rep">
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
                            <fieldset class="form-group col-12">
                                <label for="address">Billing Address:</label>
								<input class="form-control" id="address" name="address" type="text" data-required="true">
                            </fieldset>
						</form>