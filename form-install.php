						<hr>
						<h2 class="col-10">Install 2</h2>
						<form class="row text-left text-dark" id="installForm" name="installForm">
							<input type="hidden" name="jobID" id="jobID" value="">
							<input type="hidden" name="installID" id="installID" value="">
							<fieldset class="form-group col-12">
								<label for="install-name">Area/Install Name:</label>
								<input class="form-control" id="install-name" name="install-name" type="text">
							</fieldset>
							<fieldset class="form-group col-12 col-md-6 col-lg-4">
								<div class="row">
									<legend class="col-form-legend col-12">Job Type:</legend>
									<div class="col-12">
										<div class="form-check form-check-inline col-6">
											<label for="job-typea">
												<input checked class="form-check-input with-font" id="job-typea" name="job-type" type="radio" value="new">
												<p>New Install</p>
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label for="job-typeb">
												<input class="form-check-input with-font" id="job-typeb" name="job-type" type="radio" value="remodel"><p>Remodel</p>
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
											<label for="tear-outa">
												<input checked class="form-check-input with-font" id="tear-outa" name="tear-out" type="radio" value="Yes"><p>Yes</p>
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label for="tear-outb">
													<input class="form-check-input with-font" id="tear-outb" name="tear-out" type="radio" value="no">
													<p>No</p>
											</label>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-lg-6">
								<label for="material">Material:</label>
								<input class="form-control" id="material" name="material" type="text">
							</fieldset>
							<fieldset class="form-group col-12 col-md-6">
								<label for="color">Color:</label>
								<input class="form-control" id="color" name="color" type="text">
							</fieldset>
							<fieldset class="form-group col-6 col-md-3">
								<label for="lot">Lot #:</label>
								<input class="form-control" id="lot" name="lot" type="text">
							</fieldset>
							<fieldset class="form-group col-6 col-md-3">
								<div class="row">
									<legend class="col-form-legend col-12">Customer Selected?</legend>
									<div class="col-12">
										<div class="form-check form-check-inline col-6">
											<label for="selecteda">
												<input checked class="form-check-input with-font" id="selecteda" name="selected" type="radio" value="Yes">
												<p>Yes</p>
											</label>
										</div>
										<div class="form-check form-check-inline">
											<label for="selectedb">
												<input class="form-check-input with-font" id="selectedb" name="selected" type="radio" value="no">
												<p>No</p>
											</label>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-12">
								<label for="edge">Edge:</label> 
								<select class="form-control" id="edge" name="edge">
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
													<input class="form-check-input controller with-font" data-control="bs-detail" id="backsplash" name="backsplash" type="checkbox">
												</label>
											</div>
											<input class="form-control form-inline col-9 col-lg-10 bs-detail" id="bs-detail" name="bs-detail" placeholder="Details" style="display:none;" type="text">
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
													<input class="form-check-input controller with-font" data-control="rs-detail" id="riser" name="riser" type="checkbox" value="Yes">
												</label>
											</div>
											<input class="form-control form-inline col-9 col-lg-10 rs-detail" id="rs-detail" name="rs-detail" placeholder="Details" style="display:none;" type="text">
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
												<label class="form-check-label" for="sinks">
													<input class="form-check-input controller with-font" data-control="sk-detail" id="sinks" name="sinks" type="checkbox" value="Yes">
												</label>
											</div>
											<input class="form-control form-inline col-9 col-lg-10 sk-detail" id="sk-detail" name="sk-detail" placeholder="Details/Model" style="display:none;" type="text">
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-6">
								<div class="row">
									<div class="form-group col-12">
										<label for="range">Range Type:</label>
										<select class="form-control" id="range" name="range">
											<option value="None">None</option>
											<option value="Free Standing">Free Standing</option>
											<option value="Cooktop">Cooktop</option>
											<option value="Slide-In">Slide-In</option>
										</select>
									</div>
								</div>
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="model">Model #:</label>
										<input class="form-control" id="model" name="model" type="text">
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-6">
								<div class="row">
									<div class="form-group col-12">
										<label for="spread">Faucet Spread / Holes:</label>
										<select class="form-control holeOpt" id="spread" name="spread">
											<option value="None">None</option>
											<option value="1 Hole - Center">1 Hole - Center</option>
											<option value="3 Hole - 4 Inch">3 Hole - 4"</option>
											<option value="3 Hole - 8 Inch">3 Hole - 8"</option>
											<option class="controller" data-control="holes" value="Other">Other Holes</option>
										</select>
									</div>
								</div>
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="cutout">Cutout:</label>
										<input class="form-control" id="cutout" name="cutout" type="text">
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 hole" style="display:none;">
								<label for="holes">Specify other holes needed:</label>
								<input class="form-control" id="holes" name="holes" type="text">
							</fieldset>
							<fieldset class="form-group col-12">
								<label for="notes">Install Notes:</label> 
								<textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
							</fieldset>
						</form>