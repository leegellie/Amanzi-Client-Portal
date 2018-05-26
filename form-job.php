						<hr>
						<h2 class="col-12">Job Details</h2>
						<form class="row text-left text-dark" id="jobForm" name="jobForm">
							<input type="hidden" name="userID" id="userID" value="">
							<input type="hidden" name="jobID" id="jobID" value="">
							<fieldset class="form-group col-6 col-md-3">
								<label for="quote-num">Quote #:</label>
								<input class="form-control" id="quote-num" name="quote-num" type="text">
							</fieldset>
							<fieldset class="form-group col-6 col-md-3">
								<label for="order-num">Order #:</label>
								<input class="form-control" id="order-num" name="order-num" type="text">
							</fieldset>
							<fieldset class="form-group col-6 col-md-3">
								<label for="install-date">Install Date:</label>
								<input class="form-control" id="install-date" name="install-date" type="date">
							</fieldset>
							<fieldset class="form-group col-6 col-md-3">
								<label for="template-date">Template Date:</label>
								<input class="form-control" id="template-date" name="template-date" type="date">
							</fieldset>
							<fieldset class="form-group col-md-6">
								<label for="job-name">Job Name:</label> 
								<input required class="form-control" id="job-name" name="job-name" type="text" data-required="true">
							</fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="builder-name">Builder / Cabinet Company:</label>
								<input class="form-control" id="builder-name" name="builder-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-cost">P.O. Cost:</label>
								<input class="form-control" id="po-cost" name="po-cost" type="text">
                            </fieldset>
                            <fieldset class="form-group col-6 col-md-3">
                                <label for="po-num">P.O. #:</label>
								<input class="form-control" id="po-num" name="po-num" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name">Site Contact:</label>
								<input class="form-control" id="contact-name" name="contact-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone">Contact Telephone:</label>
								<input class="form-control" id="contact-phone" name="contact-phone" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-name2">Alternative Contact:</label>
								<input class="form-control" id="alt-name" name="alt-name" type="text">
                            </fieldset>
                            <fieldset class="form-group col-md-6">
                                <label for="contact-phone2">Alternative Telephone:</label>
								<input class="form-control" id="alt-phone" name="alt-phone" type="tel">
                            </fieldset>
                            <fieldset class="form-group col-12">
                                <label for="site-address">Site Address:</label>
								<input class="form-control" id="site-address" name="site-address" type="text">
                            </fieldset>
							<fieldset class="form-group col-12">
								<label for="notes2">Install Notes:</label> 
								<textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
							</fieldset>
						</form>