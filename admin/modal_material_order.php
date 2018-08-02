<div class="modal fade" id="materialOrder" tabindex="-1" role="dialog" aria-labelledby="materialOrderLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fab fa-telegram-plane"></i>
				<div class="modal-title">Ordered Materials for <span class="mAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="ordered_material" class="mats odrerMaterial row">
						<input type="hidden" name="action" value="ordered_material">
						<input type="hidden" name="iid" value="">
						<input type="hidden" name="material_status" value="2">
						<label class="col-2" for="assigned_material">Order Reference:</label>
						<input class="col-3 form-control" type="text" name="assigned_material">
						<label class="col-2" for="material_date">Expected Date:</label>
						<input class="col-3 form-control" id="material_date" name="material_date" type="date">
						<button type="submit" class="btn btn-primary ml-3">Materials Ordered</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
