<div class="modal fade" id="sinkOrder" tabindex="-1" role="dialog" aria-labelledby="sinkOrderLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fab fa-telegram-plane"></i>
				<div class="modal-title">Ordered <span class="aAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="ordered_sink" class="accs odrerSink row">
						<input type="hidden" name="action" value="ordered_sink">
						<input type="hidden" name="sink_id" value="">
						<input type="hidden" name="sinkName" value="">
						<input type="hidden" name="pid" value="">
						<input type="hidden" name="sink_status" value="2">
						<label class="col-2" for="assigned_sink">Order Reference:</label>
						<input class="col-3 form-control" type="text" name="assigned_sink">
						<label class="col-2" for="sink_date">Expected Date:</label>
						<input class="col-3 form-control" id="sink_date" name="sink_date" type="date">
						<button type="submit" class="btn btn-primary ml-3">Accessory Ordered</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
