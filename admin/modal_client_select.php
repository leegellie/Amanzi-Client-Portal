<div class="modal fade" id="selectCompany" tabindex="-1" role="dialog" aria-labelledby="selectCompanyLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title"><h3>Search Project Owners</h3></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form name="findToAdd" id="findToAdd" action="#" class="AdvancedForm row">
						<fieldset class="col-6 col-md-3">
							<div id="user_infoDIV" class="input-control text input-box" data-role="input-control">
								<input class="form-control" name="search" id="search" type="text" placeholder="Search Term" value="" />
							</div>
						</fieldset>
						<fieldset class="col-6 col-md-2">
							<div id="user_infoDIV" class="input-control select" data-role="input-control">
								<select class="mdb-select" name="user_find" id="user_find" data-transform="input-control">
									<option value="username">Username</option>
									<option value="email">Email</option>
									<option value="company" selected>Company</option> 
									<option value="fname">First Name</option>
									<option value="lname">Last Name</option>   
								</select>
							</div>
						</fieldset>
						<fieldset class="col-3 col-md-2">
							<div id="user_infoDIV" class="form-check" data-role="input-control">
								
								<input class="filled-in" type="checkbox" name="isActive" id="s-isActive" value="1" checked >
								<label style="padding-bottom:9px;" for="s-isActive">Active?</label>
							</div>
						</fieldset>
						<fieldset class="col-3 col-md-2">
							<div id="user_infoDIV" class="form-check" data-role="input-control">
								<input class="filled-in" type="checkbox" name="mine" id="mine" value="1" <? if (!in_array($_SESSION['id'],array('1','13','14','985'),true)) {echo 'checked';}; ?> >
								<label style="padding-bottom:9px;" for="mine">My Clients</label>
							</div>
						</fieldset>
						<fieldset class="col-6 col-md-3">
							<input name="action" id="action" type="hidden" value="user_project_user_search" />
							<input name="searchChild" id="searchChild" type="hidden" value="0" />
							<div id="submitForm" class="btn btn-primary" style="height: 36px; width: 100%; padding-top: 14px;">
								<h3 style="line-height: .1;font-weight:400">Search</h3>
							</div>
						</fieldset>
					</form>
					<div id="tableHolder" style="overflow-y:scroll;overflow-x: hidden; max-height:380px; margin-bottom:5px">
						<div id="tableResults"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onClick="addClient();">Add Client <i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>