<div class="modal fade" id="materialAssignBulk" tabindex="-1" role="dialog" aria-labelledby="materialAssignBulkLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="far fa-hand-holding-box"></i>
				<div class="modal-title">Assign Materials</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="assign_material_bulk" class="mats_bulk setMaterial row">
						<input type="hidden" name="action" value="assign_material_bulk">
						<input type="hidden" name="pids" value="">
						<input type="hidden" name="material_status" value="3">
						<input type="hidden" name="material_color" value="">
						<label for="assigned_material" class="col-2">Assign Material:</label>
						<input type="text" name="assigned_material" class="col-4 form-control">
						<button type="submit" class="btn btn-primary ml-3">Assign Material</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>