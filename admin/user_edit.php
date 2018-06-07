<div class="col-12" style="margin-left:0">
	<div id="user-data" class="frame ">
		<div id="user-block" class="content">
			<form name="findToEdit" id="findToEdit" action="#">
				<div width="100%">
					<div class="row">

						<div class="col-6 col-lg-3">
							<div id="user_type_findDIV" class="" data-role="input-control">
								<input class="form-control mt-3" name="search" id="search" type="text" placeholder="Search Term" value="">
								<input name="action" id="action" type="hidden" value="user_search_list">
								<input name="searchChild" id="action" type="hidden" value="0">
								<input name="userAccess" id="userAccess" type="hidden" value="<? echo $access_level; ?>">
							</div>
						</div>

						<div class="col-6 col-lg-3 pt-2">
							<div id="user_findDIV" class="text select" data-role="input-control">
								<select class="mdb-select" name="user_find" id="user_find" data-transform="input-control" >
									<option value="username">Username</option>
									<option value="email">Email</option>
									<option value="company" selected>Company</option> 
									<option value="fname">First Name</option>
									<option value="lname">Last Name</option>   
								</select>
							</div>
						</div>
						<div class="col-6 col-lg-3">
							<div id="submit_findDIV" class="input-control text" data-role="input-control">
								<div id="searchSubmit" name="searchSubmit" value="Search" style="width:100%" class="btn btn-primary">Search</div>
							</div>
						</div>
						<div class="col-3 col-lg-2 pt-2">
							<div id="isActiveDIV" class="input_control checkbox fg-white container" data-role="input-control">
								<input class="filled-in" name="isActive" id="isActive" type="checkbox" value="1" checked>
								<label class="form-check-label" for="isActive"><p>Active?</p></label>
								<input class="filled-in" name="mine" id="mine" type="checkbox" value="1" 
									   <? 
									   if (!in_array($_SESSION['id'],array('1','14','985'),true)) {
										   echo 'checked';
									   } 
									   ?> >
								<label class="form-check-label" for="mine"><p>My Clients</p></label>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div width="100%" id="tableResults" style="background:none"></div>
		</div>
	</div>
</div>
