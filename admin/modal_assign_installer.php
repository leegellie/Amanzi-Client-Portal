<div class="modal fade" id="assign_installer" tabindex="-1" role="dialog" aria-labelledby="assign_installerLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-user-plus h2 text-primary"></i>
				<h2 class="modal-title">Assign Installer</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<input type="hidden" name="assign_installer_pjt" id="assign_installer_pjt" value="0">
						<select class='mdb-select md-form colorful-select dropdown-primary border-0 m-0' id='assign_installer_team' onchange='assign_installer();'>
							<?
							$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$q = $conn->prepare("SELECT * FROM install_teams WHERE isActive = 1");
							$q->execute();
							$rows = $q->fetchAll(PDO::FETCH_ASSOC);
							foreach ($rows as $row) { 
								echo '<option id="contactChoice' . $row['inst_team_id'] . '" value="' . $row['inst_team_id'] . '">' . $row['inst_team_name'] . '</option>';
							} 
							?>
						</select>
					</div>
					<hr>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>