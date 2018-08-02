<div class="modal fade" id="sinkAssign" tabindex="-1" role="dialog" aria-labelledby="sinkAssignLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fab fa-telegram-plane"></i>
				<div class="modal-title">Location of <span class="aAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="assign_sink" class="accs setAccessory row">
						<input type="hidden" name="action" value="assign_sink">
						<input type="hidden" name="pid" value="">
						<input type="hidden" name="sink_id" value="">
						<input type="hidden" name="sinkName" value="">
						<input type="hidden" name="sink_status" value="3">
						<label for="assigned_sink" class="col-2">Assign Material:</label>
						<input type="text" name="assigned_sink" class="col-4 form-control">
						<button type="submit" class="btn btn-primary ml-3">Assign Accessory</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>