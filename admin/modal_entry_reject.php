<div aria-hidden="true" aria-labelledby="entryRejectLabel" class="modal fade" id="entryReject" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-thumbs-down h2 text-warning"></i> Reject from Entry</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">User Discount for: <span id="custDiscount"></span></h2>
					</div>
					<hr>
					<form id="entry_reject" class="row">
						<input name="action" type="hidden" value="entry_reject">
						<fieldset class="form-group col-12">
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="qDisc"><u>Quartz</u>:</label>
									<textarea class="form-control" id="r-cmt_comment" name="cmt_comment"></textarea>
								</fieldset>
							</div>
						</fieldset>
					</form>
					<div id="updateDiscounts" class="btn btn-lg btn-primary mt-3 w-100" onClick="update_discounts(<?= $_SESSION['access_level'] ?>)">Submit</div>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
