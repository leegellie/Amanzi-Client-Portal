<div aria-hidden="true" aria-labelledby="user_discountsLabel" class="modal fade" id="user_discounts" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-fas fa-percent h2 text-warning"></i> Adjust Customer Discounts</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">User Discount for: <span id="custDiscount"></span></h2>
					</div>
					<hr>
					<form id="user_discount_form" class="row">
						<input name="action" type="hidden" value="user_discount">
						<fieldset class="form-group col-12">
							<div class="row">
								<fieldset class="form-group col-6">
									<label for="mDisc"><u>Marble &amp; Granite</u>:</label>
									<input type="number" class="form-control form-control-lg" id="mDisc" name="mDisc" <? if($_SESSION['access_level'] != 1) { ?> max="15" <? } else { ?> max="35" <? } ?> step='0.01' value='0.00'>
								</fieldset>
								<fieldset class="form-group col-6">
									<label for="qDisc"><u>Quartz</u>:</label>
									<input type="number" class="form-control form-control-lg" id="qDisc" name="qDisc" <? if($_SESSION['access_level'] != 1) { ?> max="10" <? } else { ?> max="10" <? } ?> step='0.01' value='0.00' data-transform="input-control">
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