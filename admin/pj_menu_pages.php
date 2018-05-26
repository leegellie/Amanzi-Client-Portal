            <div style="display:none">

<!---- TEMPLATE PICKER ----->

				<div id="templatePicker">
                	<div id="clonedSection1" class="menuToAdd" style="display:block">
					<!-- <form id="chooseTemplate" >
						<input id="pid" name="pid" type="hidden" value="1" /> -->
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>Earth Tones</h2>
                        	<input type="radio" name="project_theme" value="t1" checked />
                            <img src="../images/theme1-thumb.jpg" />
                        </label>
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>Royal Blues</h2>
                        	<input type="radio" name="project_theme" value="t2" />
                            <img src="../images/theme2-thumb.jpg" />
                        </label>
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>Earth Tones</h2>
                        	<input type="radio" name="project_theme" value="t4" />
                            <img src="../images/theme1-thumb.jpg" />
                        </label>
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>Royal Blues</h2>
                        	<input type="radio" name="project_theme" value="t5" />
                            <img src="../images/theme2-thumb.jpg" />
                        </label>
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>White Steel</h2>
                        	<input type="radio" name="project_theme" value="t6" />
                            <img src="../images/theme3-thumb.jpg" />
                        </label>
                        <label class="rad" style="display:inline-block; padding-right:20px">
                            <h2>Earth Tones</h2>
                        	<input type="radio" name="project_theme" value="t7" />
                            <img src="../images/theme1-thumb.jpg" />
                        </label>
                    <!-- </form> -->
                    </div>
                </div>


				<div id="imgUploadBlocks">
					<input class="col-lg-3 cloneUpload" onChange="addUpload();" name="imgUploads[]" type="file">
				</div>
<!---- Menu Blocks to Create ----->
<form>
            	<div id="menuItemBlocks">
                	<div id="clonedSection1" class="menuToAdd row">
						<fieldset class="form-group col-12">
							<label for="install1-name">Area/Install Name:</label>
							<input class="form-control" id="install_name" name="install_name" type="text" data-required="true" required>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6 col-lg-4">
							<div class="row">
								<legend class="col-form-legend col-12">Job Type:</legend>
								<div class="col-12">
									<div class="form-check form-check-inline col-6">
										<label for="typea">
											<input checked="" class="form-check-input with-font" id="typea" name="type" type="radio" value="New">
											<p>New Install</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="typeb">
											<input class="form-check-input with-font" id="typeb" name="type" type="radio" value="Remodel">
											<p>Remodel</p>
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
											<input checked="" class="form-check-input with-font" id="tear_outa" name="tear_out" type="radio" value="Yes">
											<p>Yes</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="tear-outb">
											<input class="form-check-input with-font" id="tear_outb" name="tear_out" type="radio" value="No">
											<p>No</p>
										</label>
									</div>
								</div>
							</div>
						</fieldset>



						<fieldset class="form-group col-12 col-lg-4">
							<label for="material">Material:</label>
							<input class="form-control matControl" id="material" name="material" type="text">
						</fieldset>
						<fieldset class="form-group col-12 col-lg-2">
							<label for="SqFt">SqFt:</label>
							<input class="form-control matControl" id="SqFt" name="SqFt" type="number" value="0">
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<label for="color">Color:</label>
							<input class="form-control matControl" id="color" name="color" type="text">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="lot">Lot #:</label>
							<input class="form-control matControl" id="lot" name="lot" type="text">
						</fieldset>


						<fieldset class="form-group col-6 col-md-3">
							<div class="row">
								<legend class="col-form-legend col-12">Customer Selected?</legend>
								<div class="col-12">
									<div class="form-check form-check-inline col-6">
										<label class="selected1a">
											<input class="form-check-input with-font" id="selecteda" name="selected" type="radio" value="Yes"><p>Yes</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="selected1b">
											<input checked="" class="form-check-input with-font" id="selectedb" name="selected" type="radio" value="No"><p>No</p>
										</label>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="edge">Edge:</label>
							<select class="form-control" id="edge" name="edge">
								<option value="0">None</option>
								<option value="1">1" Bevel</option>
								<option value="2">1/2" Bevel</option>
								<option value="3">1/4" Bevel</option>
								<option value="4">Half Bullnose</option>
								<option value="5">Full Bullnose</option>
								<option value="6">Demi Bullnose</option>
								<option value="7">Flat</option>
								<option value="8">Pencil</option>
								<option value="9">Heavy Pencil</option>
								<option value="10">Ogee</option>
								<option value="99">Other</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Backsplash?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="backsplash">
												<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="bs_detail" id="backsplash" name="backsplash" type="checkbox">
												<input class="form-control form-inline col-9 col-lg-10 float-right bs_detail" id="bs_detail" name="bs_detail" placeholder="Details" style="display:none;" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Riser?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="riser">
												<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="rs_detail" id="riser" name="riser" type="checkbox">
												<input class="form-control form-inline col-9 col-lg-10 float-right rs_detail" id="rs_detail" name="rs_detail" placeholder="Details" style="display:none;" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Sink(s)?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="sinks">
												<input class="form-check-input controller with-font ml-3 col-3 col-lg-2" data-control="sk_detail" id="sink" name="sink" type="checkbox">
												<input class="form-control form-inline col-9 col-lg-10 float-right sk_detail" id="sk_detail" name="sk_detail" placeholder="Details/Model" style="display:none;" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<div class="row">
								<div class="form-group col-12">
									<label for="range_type">Range Type:</label>
									<select class="form-control" id="range_type" name="range_type">
										<option value="0">None</option>
										<option value="1">Free Standing</option>
										<option value="2">Cooktop</option>
										<option value="3">Slide-In</option>
									</select>
								</div>
							</div>
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="model">Model #:</label> <input class="form-control" id="range_model" name="range_model" type="text">
								</fieldset>
							</div>
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="cutout">Cutout:</label>
									<input class="form-control" id="cutout" name="cutout" type="text">
								</fieldset>
							</div>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<div class="row">
								<div class="form-group col-12">
									<label for="holes">Faucet Spread / Holes:</label>
									<select class="form-control holeOpt" id="holes" name="holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="holes_other" value="Other">Other Holes</option>
									</select>
								</div>
							</div>
							<label for="holes">Specify other holes needed:</label>
							<input class="form-control" id="holes_other" name="holes_other" type="text">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="install_notes">Install Notes:</label>
							<textarea class="form-control" id="install_notes" name="install_notes" rows="3"></textarea>
						</fieldset>
						<hr>
                    </div>
					
				</div>
</form>





<!---- Home Page Edit Form ----->
                
            	<div id="pageBuild01">
                	<div id="clonedSection1" class="accordion-frame" >
                    	<div class="content">
		                    <form name="add_page_home" id="add_page_home" class="add_page" action="javascript:;" enctype="multipart/form-data" method="post"> 
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Home Image (1920x1080px):</p>
        		                <div id="home_bgDIV" class="input-control file">
                		            <input id="home_bg" name="home_background" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    <button class="btn-file"></button>
		                        </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Tag Under Logo: </p>
        		                <div id="home_tagDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                		        	<input id="home_tag" class="home_tag" name="home_tagline" type="text"  style="width:100%"  />
		                        </div>

        		            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Ticker Across Page: </p>
                		        <div id="home_tickerDIV" class="input-control textarea" data-role="input-control" style="width:100%;height:150px; display:inline-block; ">
                        			<textarea id="home_ticker" class="home_ticker" name="home_ticker" type="textarea"  style="width:100%; min-height:34px; max-height:150px" ></textarea>
		                        </div>
        		            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript:				 									<!--<div id="home-js-check" class="input-control switch" onClick="customCode(this.id)">
										<label>
											<input type="checkbox" onChange="" />
								    		<span class="check"></span>
										</label>
									</div>-->
                                </p>
                		        <div id="home_jsDIV" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
                        			<textarea id="home_js" class="home_js" name="home_js" type="textarea"  style="width:100%; min-height:100px; max-height:150px" ></textarea>
		                        </div>
        		            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom CSS: </p>
                		        <div id="home_cssDIV" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
                        			<textarea id="home_css" class="home_css" name="home_css" type="textarea"  style="width:100%; min-height:100px; max-height:150px" ></textarea>
                                    <!-- CHANGE THE VALUE OF MID TO THIS MENU ID OF THIS SECTION -->
		                        </div>
                                <input id="home_mid" class="home_mid" name="mid" type="hidden" value="">
                                <input name="hiddenPID" type="hidden" value="">
                                <input id="home_action" class="home_action" name="action" type="hidden" value="add_project_home">
	        		        </form>
                        </div>
                    </div>
				</div>



<!---- Area Map Page Edit Form ----->
                
            	<div id="pageBuild02">
                	<div id="clonedSection1" class="accordion-frame" >
       	            	<div class="content">
	                    	<form name="add_page_area" id="add_page_area" class="add_page"> 
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Area Map Image (1920x1080px):</p>
        		                <div id="area_bgDIV" class="input-control file">
                		        	<input id="area_bg" name="area_background" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
		                            <button class="btn-file"></button>
        		                </div>                  
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript: </p>
                		        <div id="area_jsDIV" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
                        			<textarea id="area_js" class="area_js" name="area_js" type="textarea"  style="width:100%;min-height:100px; max-height:150px" ></textarea>
		                        </div>

		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom CSS: </p>
                		        <div id="area_cssDIV" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
                        			<textarea id="area_css" class="area_css" name="area_css" type="textarea"  style="width:100%;min-height:100px; max-height:150px" ></textarea>
		                        </div>
                                <p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 2.5vw;">How many points of interest?</p>
                                <input id="area_input_number" name="area_input_number" class="input-control text" style="display:inline-block; width:40px; text-align:center" type="text" value="1" />
                                <div class="button bg-green fg-white" value="Add" style="display:inline-block; width:80px; margin-top:-11px" onClick="createPOIs($(this))"><h4 style="margin:3px">Add</h4></div>
                                <div id="poiFillerDiv"></div>
                                <input id="area_mid" class="area_mid" name="mid" type="hidden" value="">
                                <input name="hiddenPID" type="hidden" value="">
                                <input id="area_action" class="area_action" name="action" type="hidden" value="add_project_area">
                            </form>
                        </div>
                    </div>
				</div>




<!---- Site Map Page Edit Form ----->
                
            	<div id="pageBuild03">
                	<div id="clonedSection1" class="accordion-frame" >
       	            	<div class="content">                    	
	            	        <form id="add_page_site" class="add_page"> 
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Site Map Image (1920x1080px):</p>
        		                <div id="site_bgDIV" class="input-control file">
                		        	<input id="site_bg" name="site_background" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    <button class="btn-file"></button>
		                        </div>
				            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Tag Under Logo: </p>
                		        <div id="site_tagDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                        			<input id="site_tag" class="site_tag" name="site_tag" type="text"  style="width:100%"  />
		                        </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Ticker Across Page: </p>
        		                <div id="site_tickerDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                		        	<input id="site_ticker" class="site_ticker" name="site_ticker" type="text"  style="width:100%" />
		                        </div>
                                
				            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript: </p>
                		        <div id="site_jsDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; min-height:100px; ">
                        			<input id="site_js" class="site_js" name="site_js" type="text"  style="width:100%; min-height:100px;"  />
		                        </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom CSS: </p>
        		                <div id="site_cssDIV" class="input-control textarea" data-role="input-control" style="width:100%; min-height:100px; display:inline-block; ">
                		        	<input id="site_css" class="site_css" name="site_css" type="textarea"  style="width:100%; min-height:100px;" />
		                        </div>
		                    	<p style="width:25%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">How many lots? </p>
                                <input id="lot_input_number" name="lot_input_number" class="input-control text" style="display:inline-block; width:10%; text-align:center" type="text" value="1" />
		                    	<p style="width:30%; display:inline-block; vertical-align:top; font-size: x-large; line-height: 3vw; padding-left:4%">Starting at lot #: </p>
                                <input id="lot_start_number" name="lot_start_number" class="input-control text" style="display:inline-block; width:10%; text-align:center" type="text" value="1" />
                                <div class="button bg-green fg-white" value="Add" style="display:inline-block; width:10%; margin-top:-11px" onClick="createLots($(this))"><h4 style="margin:3px">Add</h4></div>
                                <div id="lotFillerDiv"></div>
                                 
                                 <!-- CHANGE THE VALUE OF MID TO THIS MENU ID OF THIS SECTION -->
                                 <input id="sm_mid" class="sm_mid" name="mid" type="hidden" value="">
                                <input name="hiddenPID" type="hidden" value="">
                                 <input id="sm_action" class="sm_action" name="action" type="hidden" value="add_project_sitemap">
							</form>
                        </div>
        	        </div>
				</div>



<!---- Floor Plans Page Edit Form ----->
                
            	<div id="pageBuild04">
                	<div id="clonedSection1" class="accordion-frame" >
    	            	<div class="content">
		                    <form id="add_page_floorp" class="add_page"> 
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Tag Under Logo: </p>
	    	                    <div id="floorp_tagDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	                		<input id="floorp_tag" class="floorp_tag" name="floorp_tag" type="text"  style="width:100%"  />
            	            	</div>
	                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Ticker Across Page: </p>
    	            	        <div id="floorp_tickerDIV" class="input-control textarea" data-role="input-control" style="width:100%; display:inline-block; min-height:100px ">
        	    	            	<input id="floorp_ticker" class="floorp_ticker" name="floorp_ticker" type="textarea"  style="width:100%; min-height:100px" />
            		            </div>
                                
	                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript: </p>
    	            	        <div id="floorp_jsDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	    	            	<input id="floorp_js" class="floorp_js" name="floorp_js" type="textarea"  style="width:100%" />
            		            </div>
	                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw; ">Custom CSS: </p>
    	            	        <div id="floorp_cssDIV" class="input-control textarea" data-role="input-control" style="width:100%; display:inline-block; min-height:100px ">
        	    	            	<input id="floorp_css" class="floorp_css" name="floorp_css" type="textarea"  style="width:100%; min-height:100px" />
                                </div>
                                <p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 2.5vw;">Number of Floor Plans</p>
                                <input id="fp_input_number" name="fp_input_number" class="input-control text" style="display:inline-block; width:40px; text-align:center" type="text" value="1" />
                                <div class="button bg-green fg-white" value="Add" style="display:inline-block; width:80px; margin-top:-11px" onClick="createFPs($(this))"><h4 style="margin:3px">Add</h4></div>
                                <div id="fpFillerDiv"></div>
                                    <!-- CHANGE THE VALUE OF MID TO THIS MENU ID OF THIS SECTION -->
                                <input id="floorp_mid" class="floorp_mid" name="mid" type="hidden" value="">
                                <input name="hiddenPID" type="hidden" value="">
                                <input id="floorp_action" class="floorp_action" name="action" type="hidden" value="add_project_floorp">
							</form>
       	                </div>
                	</div>
				</div>




<!---- Custom Page Edit Form ----->
                
            	<div id="pageBuild00">
                	<div id="clonedSection1" class="accordion-frame" >
                    	<div class="content">
		   	                <form id="add_page_custom" class="add_page"> 
		                    	<p style="width:22%; display:inline-block; vertical-align:sub; font-size: x-large; line-height: 3vw;">External Link? </p>
        		                <div id="custom_external_linkDIV" class="input-control checkbox" data-role="input-control" style="width:5%; display:inline-block; ">
   			                     	<label>
                                        <input id="is_external_link" class="is_external_link" name="is_external_link" type="checkbox" onClick="extLink($(this))">                                        <span class="check"></span>
                                    </label>
            		            </div>
                                <p style="width:10%; display:inline-block; vertical-align:sub; font-size: x-large; line-height: 3vw;">URL: </p>
        		                <div id="external_linkDIV" class="input-control text" data-role="input-control" style="width:61%; display:inline-block; ">
<input id="external_link" class="external_link" name="external_link" type="text" style="width:100%"  />
                                </div>
		                    	<p style="display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Page Title: </p>
        		                <div id="page_titleDIV" class="input-control checkbox" data-role="input-control" style="width:60%; display:inline-block; ">
                                    <label>
                                        <input id="page_hide" class="page_hide" name="hide" type="checkbox" value="1">
                                        <span class="check"></span>
                                        Hide from menu
                                    </label>
                                </div>
        		                <div id="page_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                                    <input id="custom_title" class="custom_title" name="custom_title" type="text" style="width:100%"  />
            		            </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Background Image (1920x1080px):</p>
        		                <div id="custom_bgDIV" class="input-control file">
                		        	<input id="page_background" name="page_background" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    <button class="btn-file"></button>
		                        </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript: </p>
        		                <div id="page_jsDIV" class="input-control textarea" data-role="input-control" style="width:100%; min-height:100px; display:inline-block; ">
   			                     	<textarea id="page_js" class="page_js" name="page_js" type="text" style="width:100%; min-height:100px" ></textarea>
            		            </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom CSS: </p>
        		                <div id="page_cssDIV" class="input-control textarea" data-role="input-control" style="width:100%; min-height:100px; display:inline-block; ">
   			                     	<textarea id="page_css" class="page_css" name="page_css" type="text" style="width:100%; min-height:100px"  ></textarea>
            		            </div>
		                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Page Content: </p>
        		                <div id="page_htmlDIV" class="input-control textarea" data-role="input-control" style="width:100%; min-height:100px; display:inline-block; ">
   			                     	<textarea id="page_html" class="page_html" name="page_html" type="text" style="width:100%; min-height:100px"  ></textarea>
            		            </div>
                                <input id="page_mid" class="page_mid" name="mid" type="hidden" value="">
                                <input name="hiddenPID" type="hidden" value="">
                                <input id="page_action" class="page_action" name="action" type="hidden" value="add_project_custom">
		                    </form>
                        </div>
                    </div>
				</div>









<!---- POI Blocks ----->
								<div id="POI">
        			                <p style="width:13%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 30px; text-align:right">Type Type: </p>
    	            		        <div id="poi_typeDIV" class="input-control select" data-role="input-control" style="width:26%; display:inline-block; vertical-align:top">
	                        			<select id="poi_type" class="poi_type" name="poi_type[] " value="" required >
                            				<option value="0" selected>Uncategorized</option>
		                        	        <option value="1">Education</option>
        		            	            <option value="2">Retail</option>
                			                <option value="3">Restaurants</option>
            	        		            <option value="4">Services</option>
        	                    		    <option value="5">Parks</option>
		    	                        </select>
	    		                    </div>

	                                <p style="width:100%; display:inline-block; width:100%; vertical-align:top;font-size: x-large;line-height: 3vw;">Coordinance: </p>
                                    
                                   	<p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw; width:4%; padding-right:1%">X: </p>			
                                    <div id="page_htmlDIV" class="input-control text" data-role="input-control" style="display:inline-block flex; width:14%; margin-right:1%">
                                    	<input id="cord_x" class="cord_x" name="cord_x[]" type="text" style="width:100%; display:inline-block"  />
                                    </div>
                                    <p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw; width:4%; padding-right:1%">Y: </p>			
                                    <div id="page_htmlDIV" class="input-control text" data-role="input-control" style="display:inline-block flex; width:14%; margin-right:1%">
	                                    <input id="cord_y" class="cord_y" name="cord_y[]" type="text" style="width:100%; display:inline-block"  />
                                    </div>
                                	<p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw; width:12%; padding-right:1%">Height:  </p>
                                    <div id="page_htmlDIV" class="input-control text" data-role="input-control" style="display:inline-block flex; width:19%; margin-right:1%">
                                    	<input id="svg_height" class="svg_height" name="svg_height[]" type="text" style="width:100%; display:inline-block"  />
                                    </div>
                                	<p style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw; width:11%; padding-right:1%">Width: </p>
                                    <div id="page_htmlDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block flex; width:19%; ">
                                    	<input id="svg_width" class="svg_width" name="svg_width[]" type="text" style="width:100%; display:inline-block"  />
                                    </div>
                                	<p class="link_to" style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Link to: </p>
                                    <div id="page_htmlDIV" class="input-control select" data-role="input-control" style="width:100%; display:inline-block flex; ">
										<select id="link_to" name="link_to[]" onChange="poiBlocks(this.value,$(this))">
                                            <option id="link_to_poi" value="poi">Point of Interest</option>
                                            <option id="link_to_sitemap" value="sitemap">Site Map</option>
                                        </select>
									</div>
                                </div>




<!---- POI Options Edit ----->

								<div id="poiOptions">
								<div id="poiOptionsHolder" class="poi">
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Image: </p>
    	    		                <div id="poi_imageDIV" class="input-control file">
        	        		            <input id="poi_image" class="poi_image" name="poi_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
            	            		    <button class="btn-file"></button>
		        	                </div>
		            	        	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Icon: </p>
        		        	        <div id="poi_iconDIV" class="input-control file">
                		    	        <input id="poi_icon" class="poi_icon" name="poi_icon[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        			    <button class="btn-file"></button>
			                        </div>
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Title: </p>
        			                <div id="poi_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
   										<input id="poi_title" class="poi_title" name="poi_title[]" type="text"  style="width:100%"  />
			                        </div>
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Address: </p>
        			                <div id="poi_address1DIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
            	    		        	<input id="poi_address1" class="poi_address1" name="poi_address1[]" type="text"  style="width:100%"  />
		        	                </div>
		            	        	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Address 2: </p>
        		        	        <div id="poi_address2DIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                		    	    	<input id="poi_address2" class="poi_address2" name="poi_address2[]" type="text"  style="width:100%"  />
		                        	</div>
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">City: </p>
    	    		                <div id="poi_cityDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	        		        	<input id="poi_city" class="poi_city" name="poi_city[]" type="text"  style="width:100%"  />
		    	                    </div>
		        	            	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">State: </p>
        		    	            <div id="poi_stateDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
                			        	<input id="poi_state" class="poi_state" name="poi_state[]" type="text"  style="width:100%"  />
		                    	    </div>
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Zip: </p>
	        		                <div id="poi_zipDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
 										<input id="poi_zip" class="poi_zip" name="poi_zip[]" type="text"  style="width:100%"  />
			                        </div>
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Notes: </p>
        			                <div id="poi_notesDIV" class="input-control textarea" data-role="input-control" style="width:100%; min-height:100px; display:inline-block; ">
            	    		        	<input id="poi_notes" class="poi_notes" name="poi_notes[]" type="textarea"  style="width:100%; min-height:100px;" />
		        	                </div>
			                    	<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Distance from development: </p>
    	    		                <div id="poi_distanceDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	        		        	<input id="poi_distance" class="poi_distance" name="poi_distance[]" type="text"  style="width:100%"  />
		    	                    </div>
                                </div>
                                </div>



<!---- Sitemap Options Edit ----->

								<div id="siteMapOpt">
                               	<div id="siteMapOptHolder" class="smh" style="display:none">
	                                <p style="width:28%; dispflay:inline-block; width:100%; vertical-align:top;font-size: x-large;line-height: 3vw;">Select Sitemap: </p>
                                    <div id="page_htmlDIV" class="input-control select" data-role="input-control" style="width:59%; display:inline-block flex; ">
       	                            	<select id="internal_link" name="internal_link[]">
           	                            	<option value="0">Select Sitemap</option>
										</select>
                   	                </div>
                       	        </div>
                                </div>




<!---- Floor Plan Page Options Edit ----->

								<div id="floorpOpt">
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Floorplan Image: </p>
    		            	        <div id="fp_floorplan_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                		        		<input id="fp_floorplan_image" class="fp_floorplan_image" name="fp_floorplan_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    	<button class="btn-file"></button>
									</div>
	            	        		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Floor plan Title: </p>
    	            		        <div id="fp_floorplan_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	    	    	        	<input id="fp_floorplan_title" class="fp_floorplan_title" name="fp_floorplan_title[]" type="textarea"  style="width:100%" />
            		        	    </div>
	                    			<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Beds: </p>
	    	            	        <div id="fp_floorplan_bedsDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
    	    	    	            	<input id="fp_floorplan_beds" class="fp_floorplan_beds" name="fp_floorplan_beds[]" type="number"  style="width:100%" />
        	    		            </div>
	        	            		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Bath: </p>
    	        	    	        <div id="fp_floorplan_bathsDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	    		            	<input id="fp_floorplan_baths" class="fp_floorplan_baths" name="fp_floorplan_baths[]" type="number" step="0.25"  style="width:100%" />
            		    	        </div>
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Sq Ft.: </p>
    		            	        <div id="fp_floorplan_sqftDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        		    	            	<input id="fp_floorplan_sqft" class="fp_floorplan_sqft" name="fp_floorplan_sqft[]" type="number"  style="width:100%" />
            			            </div>
	                	    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Priced from: </p>
    	            		        <div id="fp_floorplan_sqftDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	    	        	    	<input id="fp_floorplan_price" class="fp_floorplan_price" name="fp_floorplan_price[]" type="number"  style="width:100%" />
            		            	</div>
	                	    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Ticker Across Page: </p>
    	            		        <div id="fp_ticker" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
        	    	        	    	<input id="fp_ticker" class="fp_ticker" name="fp_ticker[]" type="text"  style="width:100%" />
            		            	</div>
	                	    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom Javascript: </p>
    	            		        <div id="fp_js" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
	                        			<textarea id="fp_js" class="fp_js" name="fp_js[]" type="textarea" style="width:100%; min-height:100px; max-height:150px"></textarea>
			                        </div>
	                	    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Custom CSS: </p>
    	            		        <div id="fp_css" class="input-control textarea" data-role="input-control" style="width:100%;min-height:100px; display:inline-block; ">
                        				<textarea id="fp_css" class="fp_css" name="fp_css[]" type="textarea" style="width:100%; min-height:100px; max-height:150px"></textarea>
		                       	 	</div>
								</div>





<!---- Floor Plans ----->


								<div id="floorPEach">
				                	<div id="clonedSection1" class="accordion-frame" >
				                    	<div class="content">
                                        	<form id="fpDetails" class="add_fp">

					                    		<p class="fp_flr" style="width:40%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Number of Floors: </p>
    			        	    		        <div id="fp_floor_numDIV" class="input-control text fp_flr" data-role="input-control" style="width:10%; display:inline-block; ">
        	    				    	        	<input id="fp_floor_num" class="fp_floor_num" name="fp_floor_num[]" type="number" step="1" style="width:100%"  />
            		    			    	    </div><br>


					                    		<p class="fp_elv" style="width:40%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Number of Elevations: </p>
    			        	    		        <div id="fp_elev_numDIV" class="input-control text fp_elv" data-role="input-control" style="width:10%; display:inline-block; ">
        	    				    	        	<input id="fp_elev_num" class="fp_elev_num" name="fp_elev_num[]" type="number" step="1" style="width:100%" />
            		    			    	    </div><br>


                                            </form>
                        		        </div>
									</div>
                                </div>


<!---- Floor Plan Floors ----->


								<div id="floorPFloor">
                                	
		                    		<p style="width:100%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Floor Name: </p>
	        	    		        <div id="fp_floor_numDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
										<input id="floor_title" class="floor_title" name="floor_title[]" type="textarea"  style="width:100%" />
									</div>
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Floor Base Image: </p>
    		            	        <div id="floor_base_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                		        		<input id="floor_base_image" class="floor_base_image" name="floor_base_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    	<button class="btn-file"></button>
									</div>
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Reversed Base Image: </p>
    		            	        <div id="floor_reversed_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                		        		<input id="floor_reversed_image" class="floor_reversed_image" name="floor_reversed_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        		    	<button class="btn-file"></button>
									</div>

                                </div>




<!---- Floor Plan Elevations ----->




								<div id="floorPElev">
                                
		                    		<p style="width:100%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Elevation Name: </p>
	        	    		        <div id="elev_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
										<input id="elev_title" class="elev_title" name="elev_title[]" type="textarea"  style="width:100%" />
									</div>
		                    		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Elevation Image: </p>
    		            	        <div id="elev_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                		        		<input id="" class="elev_image" name="elev_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                                        <input type="hidden" name="action" value="add_elevations">
                        		    	<button class="btn-file"></button>
									</div>

                                </div>



<!---- Floor Plan Styles ----->




								<div id="floorPStyles">
                                	<div id="clonedSection">
	                                    <!--<form>--><div>
				                    		<p style="width:100%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Style Name: </p>
			        	    		        <div id="style_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
												<input id="style_title" class="style_title" name="style_title[]" type="textarea"  style="width:100%" />
											</div>
		        		            		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Style Image: </p>
    		        		    	        <div id="elev_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                				        		<input id="style_image" class="style_image" name="style_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        				    	<button class="btn-file"></button>
											</div>
		                                	<p class="link_to" style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Link to Elevation? </p>
    		                                <div id="style_elevDIV" class="input-control select" data-role="input-control" style="width:100%; display:inline-block flex; ">
												<select id="style_elev" name="style_elev[]" >
        		                                    <option value="0">No. General Style</option>
            	    	                        </select>
											</div>
                                            <div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
                        	            <!--</form>--></div>
										<!--<div style="height:35px" id="holder" style="float:right; display:inline; vertical-align:middle;">
                                	    	<div id="make_styles" class="saveFPData button bg-yellow " style="float:right; display:inline-block">
                                    	    	<h4 class="fg-white" style="font-weight:300;line-height:0.3">Save Styles</h4>
                                        	</div>
	                                    </div>-->
    	                            </div>
                                </div>




<!---- Floor Plan Options ----->




								<div id="floorPOptions">
                                	<div id="clonedSection">
	                                    <!--<form>--><div>
				                    		<p style="width:100%; display:inline-block; vertical-align:sub;font-size: x-large;line-height: 3vw;">Option Name: </p>
			        	    		        <div id="option_titleDIV" class="input-control text" data-role="input-control" style="width:100%; display:inline-block; ">
												<input id="option_title" class="option_title" name="option_title[]" type="textarea"  style="width:100%" />
											</div>
		        		            		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Option Image: </p>
    		        		    	        <div id="option_imageDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                				        		<input id="option_image" class="option_image" name="option_image[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        				    	<button class="btn-file"></button>
											</div>
		        		            		<p style="width:100%; display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Button Image: </p>
    		        		    	        <div id="option_buttonDIV" class="input-control file" data-role="input-control" style="width:100%; display:inline-block; ">
                				        		<input id="option_button" class="option_button" name="option_button[]" type="file"   data-role="hint" data-hint-background="bg-green" data-hint-color="fg-white" data-hint-mode="2" data-hint="Click Box| to choose for upload" data-hint-position="right" style="width:100%" />
                        				    	<button class="btn-file"></button>
											</div>
		                                	<p class="link_to" style="display:inline-block; vertical-align:top;font-size: x-large;line-height: 3vw;">Link to Floor? </p>
    		                                <div id="style_elevDIV" class="input-control select" data-role="input-control" style="width:100%; display:inline-block flex; ">
												<select id="opt_floor" name="opt_floor[]" >
                                            
            	    	                        </select>
											</div>
                                            <div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
                        	            <!--</form>--></div>
										<!--<div style="height:35px" id="holder" style="float:right; display:inline; vertical-align:middle;">
                                	    	<div id="make_styles" class="saveFPData button bg-yellow " style="float:right; display:inline-block">
                                    	    	<h4 class="fg-white" style="font-weight:300;line-height:0.3">Save Styles</h4>
                                        	</div>
	                                    </div>-->
    	                            </div>
                                </div>




<!---- Elevations Dropdown ----->




								<div id="elevList">
									<div id="elevDropdown">
                                    	<select id="fpIDdd" name="specElev">
                                        </select>
                                    </div>
                                </div>




<!---- End of hidden ----->

            </div>                                    
