<div class="modal fade" id="select_installers" tabindex="-1" role="dialog" aria-labelledby="select_installersLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-users text-warning"></i> Job Installers</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="select_installers_form" class="row">
						<input type="hidden" name="action" value="select_installers">
						<input type="hidden" id="si-pid" name="pid" value="">
						<input type="hidden" id="si-sqft" name="sqft" value="">
						<input type="hidden" id="si-install_date" name="install_date" value="">
						<fieldset class="form-group col-md-4 text-left">
							<input class="filled-in mr-4 installer" name="000" type="checkbox" data-id="22" data-installer_name="Customer Pick Up" id="Customer" value="0">
							<label for="Customer" class="text-left">Customer Pick Up</label>
						</fieldset>
						<fieldset class="form-group col-md-4 text-left">
							<input class="filled-in mr-4 installer" name="999" type="checkbox" data-id="0" data-installer_name="Manager Install"  id="Manager" value="0">
							<label for="Manager" class="text-left">Manager Installed</label>
						</fieldset>
<?
	$uOptions = '';
	$salesReps = new project_action;
	foreach($salesReps->get_installers() as $results) {
		$installer_string = "'" . $results['lname'] . ', ' . $results['fname'] . "'";
		$uOptions .= '	<fieldset class="form-group col-md-4 text-left">';
		$uOptions .= '		<input class="filled-in mr-4 installer" name="inst_id_' . $results['id'] . '" type="checkbox" data-id="' . $results['id'] . '" data-installer_name="' . $installer_string . '" data-installer_rate="' . $results['installer_rate'] . '" id="' . $results['installer_id'] . '" value="0">';
		$uOptions .= '		<label for="' . $results['installer_id'] . '" class="text-left">' . $results['installer_id'] . ' - ' . $results['lname'] . ', ' . $results['fname'] . '</label>';
		$uOptions .= '	</fieldset>';
	}
	echo $uOptions;
?>
					</form>
					<div id="select_installersBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="select_installers()">Assign</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>