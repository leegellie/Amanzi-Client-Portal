<div class="container pageLook">
	<div class="row">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12 px-0">

                    <div id="user-block" class="content">
                        <form name="findPjtUser" id="findPjtUser" action="#">
                            <div width="100%">
                                <div class="row">
                                    <div class="col-6 col-lg-3">
                                        <div id="user_type_findDIV" class="" data-role="input-control">
                                            <input class="form-control mt-2" name="search" id="search" type="text" placeholder="Search Term" value="">
                                            <input name="action" id="action" type="hidden" value="pjt_user_list">
                                            <input name="searchChild" id="action" type="hidden" value="0">
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div id="user_findDIV" class="text select" data-role="input-control">
                                            <select class="mdb-select" name="user_find" id="user_find" data-transform="input-control" >
                                                <option value="job_name">Job Name</option>
                                                <option value="order_num">Order Number</option>
                                                <option value="quote_num">Quote Number</option>
                                                <option value="username">Username</option>
                                                <option value="email">Email</option>
                                                <option value="company">Company</option> 
                                                <option value="fname">First Name</option>
                                                <option value="lname">Last Name</option>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div id="submit_findDIV" class="input-control text" data-role="input-control">
                                            <input id="searchSubmit" name="searchSubmit" type="submit" value="Search" style="width:100%" class="btn btn-primary">
                                        </div>
                                    </div>
                                    <div class="col-3 col-lg-3 mt-2">
                                    	<div id="isActiveDIV" class="input_control checkbox fg-white container" data-role="input-control">
											<input class="filled-in" name="isActive" id="isActive" type="checkbox" value="1" checked>
											<label class="form-check-label container col-10" for="isActive"><p>Active</p></label>
											<input class="filled-in" name="mine" id="mine" type="checkbox" value="1" <? if (!in_array($_SESSION['id'],array('1','2','13','14','985','2004','1541'),true)) {echo 'checked';}; ?> >
											<label class="form-check-label container col-10" for="mine"><p>My Jobs</p></label>
										</div>
                                    </div>
                                </div>
                            </div>
                        </form>
						<div class="col-12" id="tableResults"></div>
           			</div>
					<div id="pjt-block" class="content">
						<div class="col-12" id="pjtResults"></div>
					</div>
					<div id="inst-list" class="content">
						<div class="col-12" id="pjtDetails"></div>
					</div>
					<div id="inst-block d-print-none" class="content">
						<div class="col-12 d-print-none" id="instDetails"></div>
					</div>
				</div>
			</div>
	</div>
</div>
<?
include ('modal_install_add.php');
?>
