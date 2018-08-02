<div class="modal fade" id="materialAssign" tabindex="-1" role="dialog" aria-labelledby="materialAssignLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fab fa-telegram-plane"></i>
				<div class="modal-title">Assign Material to <span class="mAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="assign_material" class="mats setMaterial row">
						<input type="hidden" name="action" value="assign_material">
						<input type="hidden" name="iid" value="">
						<input type="hidden" name="material_status" value="3">
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