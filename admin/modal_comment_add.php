<div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="addCommentLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-comment"></i>
				<div class="modal-title">Add Comment</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h3>Add Comment to <span class="text-primary" id="cmt_name"></span></h3>
						<p class="col-12">Commenting as <span id="commentor" class="text-primary"></span> - Not you? <a href="/logout.php" class="text-primary">Log Out</a></p>
					</div>
					<hr>
					<form id="commentForm" class="row">
						<input type="hidden" name="action" value="submit_comment">
						<input type="hidden" id="cmt_ref_id" name="cmt_ref_id" value="">
						<input type="hidden" id="cmt_type" name="cmt_type" value="">
						<input type="hidden" id="cmt_user" name="cmt_user" value="">
						<label for="cmt_priority" class="form-label col-12 col-md-4">Priority: </label>
						<select name="cmt_priority" id="cmt_priority" class="mdb-select md-form colorful-select dropdown-primary col-12 col-md-8">
							<option value="Normal" selected>Regular</option>
							<option value="911">Important</option>
						</select>
						<label class="form-label col-12 col-md-4">Comment: </label>
						<textarea class="form-control" id="cmt_comment" name="cmt_comment" rows="5"></textarea>
						<hr>
						<div id="submitComments" class="btn btn-lg btn-primary col-12">Submit Comments <i class="fab fa-telegram-plane"></i></div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>