<div aria-hidden="true" aria-labelledby="qr_scannerLabel" class="modal fade" id="qr_scanner" role="dialog" tabindex="55">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-qrcode h2 text-warning"></i> Scan Code</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<fieldset class="form-group col-6 col-lg-3">
						<label class="qrcode-text-btn"></label>
						<div class="input-group">
							<label class="qrcode-text-btn"></label>
							<div class="input-group-prepend">
								<label class="qrcode-text-btn"><button class="btn btn-muted" type="button"><label class="qrcode-text-btn"><i class="fas fa-qrcode"></i></label></button></label>
							</div><input accept="image/*" onchange="openQRCamera(this);" tabindex="-1" type="file">
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
				</div>
			</div>
		</div>
	</div>
</div>
