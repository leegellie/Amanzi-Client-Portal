		<div class="row w-100">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row">
						<h1 class="text-primary col-10">Invoice Status</h1>
					</div>
                    <div id="user-block" class="content">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-justified mdb-color darken-3" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#panel_to_invoice" role="tab">To Invoice</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#panel_outstanding" role="tab">Outstanding</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#panel_disputed" role="tab">Disputed</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#panel_paid" role="tab">Paid</a>
						</li>
					</ul>
					<!-- Tab panels -->
					<div class="tab-content px-0">
						<!--Panel 1-->
						<div class="tab-pane fade in show active" id="panel_to_invoice" role="tabpanel">
						</div>
						<div class="tab-pane fade" id="panel_outstanding" role="tabpanel">
						</div>
						<div class="tab-pane fade" id="panel_disputed" role="tabpanel">
						</div>
						<div class="tab-pane fade" id="panel_paid" role="tabpanel">
						</div>
           			</div>
				</div>
				<div id="pjt-block" class="content">
					<div class="col-12" id="pjtResults"></div>
				</div>
				<div id="inst-list" class="content">
					<div class="col-12" id="pjtDetails"></div>
				</div>
				<div id="inst-block" class="content">
					<div class="col-12" id="instDetails"></div>
				</div>
			</div>
		</div>
<script>
$(document).ready(function(){
    loadInvoices();
});
</script>
