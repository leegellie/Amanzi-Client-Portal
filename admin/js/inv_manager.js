$(document).ready(function(){
	initial_table();
})
var show_id;
var show_type;
var show_name;

function initial_table() {
	$.ajax({
		url: 'ajax_inv.php',
		data: 'action=initial',
		type: 'POST',
		success: function(data) {
			$('#inv_table_sec').html('');
			$('#inv_table_sec').html(data);
			$('.table.dynamic').DataTable({
				"destroy": true,
				"pageLength": 10,
				"aoColumnDefs" : [{
					'bSortable' : false,
					'aTargets' : [ -1,-2,-3 ]
				}]
			});
			$('.mdb-select').material_select('destroy');
			$('select').addClass('mdb-select');
			$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
			$('select[name=slabs_table_length]').addClass('mdb-select');
			$('select[name=remnant_table_length]').addClass('mdb-select');
			$('.mdb-select').material_select();
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function add_category(){
	var form = $("form#add_cat");
	if(form[0].checkValidity()) {
		var formdata = new FormData();
		var form_array = form.serializeArray();
		$.each(form_array, function(index, value){
			formdata.append(value.name, value.value);
		});
		formdata.append('image', $("#add_cat #image")[0].files[0]);
		formdata.append('template', $("#add_cat #template")[0].files[0]);
		$.ajax({
			url: 'ajax_inv.php',
			data: formdata,
			type: 'POST',
			contentType: false,
			cache: false,
			processData:false,
			success: function(data) {
				if(data === 'success'){
					toastr.success('Add category Success!');
					$('#categoryAdd').modal('hide');
					initial_table();
				}else{
					toastr.error('Failed! Please check(Category ID, etc...) and try again');
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	}else{
		form[0].reportValidity();
	}
}
function update_category(){
	var form = $("form#edit_cat");
	var formdata = new FormData();
	var form_array = form.serializeArray();
	$.each(form_array, function(index, value){
		formdata.append(value.name, value.value);
	});
	formdata.append('image', $("#add_cat #image")[0].files[0]);
	formdata.append('template', $("#add_cat #template")[0].files[0]);
	$.ajax({
		url: 'ajax_inv.php',
		data: formdata,
		type: 'POST',
   	contentType: false,
		cache: false,
   	processData:false,
		success: function(data) {
			console.log(data);
			if(data === 'success'){
				toastr.success('Edit category Success!');
				$('#editInventory').modal('hide');
// 				location.reload();
				initial_table();
			}else{
				toastr.error('Failed! Please check(Category ID, etc...) and try again');
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}
function editInvModal(id) {
	var row = $('[name=\''+id+'\']');
	$('#p-category_id').val(row.find('.row_category_id').text());
	$('#ori_id').val(row.find('.row_category_id').text());
	$('#p-category_name').val(row.find('.row_category_name').text());
	$('#p-prefered_vendor').val(row.find('.row_company').text());
	$('#p-min_req').val(row.find('.row_min_req').text());
	$('#p-reorder_amt').val(row.find('.row_reorder_amt').text());
	$('#p-cost').val(row.find('.row_cost').text());
	$('#p-price').val(row.find('.row_price').text());
	$('#p-lead_time').val(row.find('.row_lead_time').text());
	$('#p-image').attr('src', row.find('.row_image').text());
	$('#p-template').attr('src', row.find('.row_template').text());
	
	$('.mdb-select').material_select('destroy');
	$('select').addClass('mdb-select');
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
	$('select[name=slabs_table_length]').addClass('mdb-select');
	$('select[name=remnant_table_length]').addClass('mdb-select');
	$('.mdb-select').material_select();


	var cur_cat_name = row.find('.row_type_name').text();
	$('#cat_edit').find('.select-dropdown li .filtrable:contains('+cur_cat_name+')').trigger('click');
	
	$('#editInventory').modal('show');
}
	
function hide_md() {
	$('#mi-modal').find('.more_alert').html('');
	$('#mi-modal').find('.delConfirmBtn').removeAttr('disabled');
	$("#mi-modal").modal('hide');
}
	
function confirm_del() {
	var type = $('#mi-modal #checktype').val();
	if (type == 'category'){
		var pdtid = $('#pdt_id').val();
		var datastring = 'action=del_inv' + '&id=' + pdtid;
		$.ajax({
			url: 'ajax_inv.php',
			data: datastring,
			type: 'POST',
			success: function(data) {
				console.log('done - ' + data);
				$('#mi-modal').find('.more_alert').html('');
				$('#mi-modal').find('.delConfirmBtn').removeAttr('disabled');
				$("#mi-modal").modal('hide');
// 				location.reload();
				initial_table();
			},
			error: function(data) {
				console.log(data);
			}
		});
	}else if(type == 'item'){
		var item_id = $('#mi-modal #item_id').val();
		var datastring = 'action=del_item' + '&id=' + item_id;
		$.ajax({
			url: 'ajax_inv.php',
			data: datastring,
			type: 'POST',
			success: function(data) {
				console.log('done - ' + data);
				$("#mi-modal").modal('hide');
				//location.reload();
				$('#itemAdd').modal('hide');
				showdetail(show_id,show_type,show_name);
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
}
	
function update_inv() {
	var datastring = 'action=edit_inv' + '&id=' + $('#editInventory #q-id').val() + '&name=' + $('#editInventory #pdt-name').val() + '&part_num=' + $('#editInventory #pdt-partnum').val() + '&label=' + $('#editInventory #pdt-label').val() + '&start_inv=' + $('#editInventory #pdt-start_inv').val() + '&inv_received=' + $('#editInventory #pdt-inv_received').val() + '&inv_shipped=' + $('#editInventory #pdt-inv_shipped').val() + '&inv_onhand=' + $('#editInventory #pdt-inv_onhand').val() + '&min_required=' + $('#editInventory #pdt-min_required').val();	
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log('done - ' + data);
			initial_table();
// 			location.reload();
		},
		error: function(data) {
			console.log(data);
		}
	});
}
	
// Show the items per each inventory
function showdetail(id,type) {
	var row = $('[name=\''+id+'\']');
	var cate_name = row.find('.row_category_name').text();
	$('#ctg_name').text(cate_name);
	show_id = id;
	show_type = type;
// 	show_name = name;
	$('#sel_type').val(type);
	
	$('#category_sec').hide();
	if(type > 4) {
		$('.items_section ul li:nth-child(2)').hide();
	}else{
		$('.items_section ul li:nth-child(2)').show();
	}
// 	$('.item_section_header span').text(name);
	$('#cur_catid').val(id);   //store the current clicked category id to the hidden input in the item modal
	$('.items_section').hide();
	var datastring = 'action=show_detail' + '&id=' + id + '&cat_type=' + type;
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		dataType: 'JSON',
		success: function(data) {
			if(data.status){
				var slabs_table = '<table class="table table-striped table-hover table-sm dynamic" id="slabs_table"><thead class="mdb-color red lighten-3 text-white" style="position: sticky"><tr>';
				var remnant_tables = '<table class="table table-striped table-hover table-sm dynamic" id="remnant_table"><thead class="mdb-color red lighten-3 text-white" style="position: sticky"><tr>';
				var thead_html = '<th class="text-center" scope="col">Item ID</th>';
				thead_html += '<th class="text-center" scope="col">Category</th>';
				if(type != 1 && type != 2)
					thead_html += '<th class="text-center" scope="col">Qty</th>';
				thead_html += '<th class="text-center" scope="col">Item Name</th>';
				if(type == 1 || type == 2)
					thead_html += '<th class="text-center" scope="col">Lot</th>';
				thead_html += '<th class="d-none d-md-table-cell">Location</th>';
				if(type == 4)
				thead_html += '<th class="d-none d-md-table-cell">Remnant</th>';
				if(type != 4 && type != 5){
					thead_html += '<th class="d-none d-md-table-cell">Height</th>';
					thead_html += '<th class="d-none d-md-table-cell">Width</th>';
				}
				if(type == 2){
					thead_html += '<th class="d-none d-md-table-cell">Height_L</th>';
					thead_html += '<th class="d-none d-md-table-cell">Width_L</th>';
				}
				if(type == 1 || type == 2)
					thead_html += '<th class="d-none d-md-table-cell">SqFt</th>';
				thead_html += '<th class="d-none d-md-table-cell">Cost</th>';
				thead_html += '<th class="d-none d-md-table-cell">Price</th>';
// 				thead_html += '<th class="d-none d-md-table-cell">Image</th>';
				if(type != 5)
					thead_html += '<th class="d-none d-md-table-cell">Tied to</th>';
				if(type != 1 && type != 2){
					thead_html += '<th class="d-none d-md-table-cell">Supplier</th>';
					thead_html += '<th class="d-none d-md-table-cell">Order Number</th>';
				}
// 				if(type != 2)
// 					thead_html += '<th class="d-none d-md-table-cell">Date Ordered</th>';
				slabs_table += thead_html + '<th class="d-none d-md-table-cell">Date Ordered</th>';
				slabs_table += '<th class="d-none d-md-table-cell">Date Received</th><th class="d-none d-md-table-cell">View</th><th class="d-none d-md-table-cell">Edit</th><th class="d-none d-md-table-cell">Duplicate</th><th class="d-none d-md-table-cell">Delete</th></tr></thead><tbody>';
				thead_html += '<th class="d-none d-md-table-cell">Date Received</th><th class="d-none d-md-table-cell">View</th><th class="d-none d-md-table-cell">Edit</th><th class="d-none d-md-table-cell">Duplicate</th><th class="d-none d-md-table-cell">Delete</th></tr></thead><tbody>';

				slabs_table += data.slabs_table + '</tbody></table>';
				remnant_tables += thead_html + data.remnant_table + '</tbody></table>';
				$('#slabs_tables').html(slabs_table);
				$('#remnant_tables').html(remnant_tables);
				$('.table.dynamic').DataTable({
					"destroy": true,
					"pageLength": 10,
					"aoColumnDefs" : [{
						'bSortable' : false,
						'aTargets' : [ -1,-2,-3,-4,-7,-8,-9,-11,-12 ]
					}]
				});
				$('.mdb-select').material_select('destroy');
				$('select').addClass('mdb-select');
				$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
				$('select[name=slabs_table_length]').addClass('mdb-select');
				$('select[name=remnant_table_length]').addClass('mdb-select');
				$('.mdb-select').material_select();
				
				$('.items_section').show();
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function categoryBack() {
	initial_table();
	$('#category_sec').show();
	$('.items_section').hide();
}

function add_inv() {
	var datastring = 'action=add_inv' + '&name=' + $('#add_inv #name').val() + '&part_num=' + $('#add_inv #partNum').val() + '&label=' + $('#add_inv #pdt_label').val() + '&start_inv=' + $('#add_inv #pdt-startinv').val() + '&inv_received=' + $('#add_inv #pdt-invreceive').val() + '&inv_shipped=' + $('#add_inv #pdt-invshipped').val() + '&inv_onhand=' + $('#add_inv #pdt-invonhand').val() + '&min_required=' + $('#add_inv #pdt-minrequired').val();

	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log('done - ' + data);
			initial_table();
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function delete_category(id) {
	$('#pdt_id').val(id);
	$('#del_cat_name').text(id);
	$('#mi-modal #checktype').val('category');
	$('#mi-modal').find('.more_alert').html('');
	$('#mi-modal').find('.delConfirmBtn').removeAttr('disabled');
	//get how many items with this cat type
		$.ajax({
			url: 'ajax_inv.php',
			data: 'action='+'getItemCountWithCategory'+'&category_id='+id,
			type: 'POST',
			dataType: 'JSON',
			success: function(data) {
				if(data.status === 'success'){
					if(data.count > 0){
						$('#mi-modal').find('.more_alert').html('There are '+data.count+' items associated with this category. Please delete them or move to a different category before proceeding.');
						$('#mi-modal').find('.delConfirmBtn').attr('disabled', 'disabled');
					}
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	$("#mi-modal").modal('show');
}

function delete_item(itemid) {
	$('#mi-modal #item_id').val(itemid);
	$("#mi-modal .modal-body").html('');
	$("#mi-modal .modal-body").html('<p>Are you sure want to delete this Item?</p>');
	$('#mi-modal #checktype').val('item');
	$("#mi-modal").modal('show');
}

// Open the ADD / EDIT Item Modal according the type value
function edit_item(type,trid) {
	var cat_type = $('#sel_type').val();
	var form = $("form#add_item");
	var formdata = new FormData();
	var form_array = form.serializeArray();
	$.each(form_array, function(index, value){
		var id_tag = '#'+value.name;
		$(id_tag).removeAttr('readonly');
	});
	$('#category_id').val(parseInt(cat_type));
	$('#item_qty').attr('readonly', true);
	if(cat_type == 1 || cat_type == 2) {
		$('#item_height-1').attr('readonly', true);
		$('#item_width-l').attr('readonly', true);
		$('#supplier').attr('disabled');
		$('#ordernum').attr('readonly', true);
		if(type=='add') $('#itemAdd #item_name').val(show_name);
	}
	if(cat_type == 3) {
		$('#item_lot').attr('readonly', true);
		$('#item_height-1').attr('readonly', true);
		$('#item_width-l').attr('readonly', true);
		$('#sqft').attr('readonly', true);
		if(type=='add') $('#itemAdd #item_name').val(show_id+ ' - ' +show_name);
	}
	if(cat_type == 4) {
		$('#item_lot').attr('readonly', true);
		$('#item_height').attr('readonly', true);
		$('#item_width').attr('readonly', true);
		$('#item_height-1').attr('readonly', true);
		$('#item_width-l').attr('readonly', true);
		$('#sqft').attr('readonly', true);
		if(type=='add') $('#itemAdd #item_name').val(show_id+ ' - ' +show_name);
	}
	if(cat_type == 5) {
		$('#item_lot').attr('readonly', true);
		$('#item_height').attr('readonly', true);
		$('#item_width').attr('readonly', true);
		$('#item_height-1').attr('readonly', true);
		$('#item_width-l').attr('readonly', true);
		$('#sqft').attr('readonly', true);
		$('#tiedto').attr('readonly', true);
		if(type=='add') $('#itemAdd #item_name').val(show_id+ ' - ' +show_name);
	}
	
	var cat_type_html = '<label class="col-3 mb-3" for="category">Category:</label><select class="col-9 mb-3 mdb-select" id="item_category_id" name="item_category_id">';
	var sup_html = '<label class="col-6 mb-3" for="supplier">Supplier:</label><select class="col-9 mb-3 mdb-select" id="supplier" name="supplier">';
	var datastring = 'action=get_cat';
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(result) {
			var ind = 1;
			$.each(JSON.parse(result).category, function(index, value){
				//Check the selected category id
				if($('#cur_catid').val() === value)
					cat_type_html += '<option value="'+value+'" selected>'+value+'</option>';
				else
					cat_type_html += '<option value="'+value+'">'+value+'</option>';
				ind++;
			});
			cat_type_html += '</select>';
			var ind_sup = 1;
			$.each(JSON.parse(result).supplier, function(index, value){
				sup_html += '<option value="'+value.id+'">'+value.company+'</option>';
				ind_sup++;
			});
			sup_html += '</select>';
			
			$('#itemcate_section').html(cat_type_html);
			$('#supplier_section').html(sup_html)
			
			if($('#slabs_tables').hasClass('active')){
				if(type == 'add'){
					$('#itemAdd .modal-title h2').text('Add Item(Slabs)');
					$('#itemAdd #confirm_btn').text('ADD');
					var add_item_name = show_id + ' - ' + $('#ctg_name').text();
					$('#add_item #item_name').val(add_item_name)
// 					$('#add_item #item_name').val('');
				}else if(type == 'edit' || type == 'duplicate'){
					if(type == 'edit'){
						$('#itemAdd .modal-title h2').text('Edit Item(Slabs)');
						$('#itemAdd #confirm_btn').text('UPDATE');
					}else{
						$('#itemAdd .modal-title h2').text('Duplicate Item(Slabs)');
						$('#itemAdd #confirm_btn').text('ADD');
					}
					$('#itemAdd #trid').val(trid);
					
					$('#add_item #item_name').val('');
					$('#add_item #item_name').val($('#tr'+trid+ ' #d_itemname').html());
					$('#add_item #item_category_id').val('');
					$('#add_item #item_category_id').val($('#tr'+trid+ ' #d_catid').html());
					$('#add_item #item_qty').val('');
					$('#add_item #item_qty').val($('#tr'+trid+ ' #d_qty').html());
					$('#add_item #item_lot').val('');
					$('#add_item #item_lot').val($('#tr'+trid+ ' #d_lot').html());
					$('#add_item #item_location').val('');
					$('#add_item #item_location').val($('#tr'+trid+ ' #d_locat').html());
					$('#add_item #item_height').val('');
					$('#add_item #item_height').val($('#tr'+trid+ ' #d_hei').html());
					$('#add_item #item_width').val('');
					$('#add_item #item_width').val($('#tr'+trid+ ' #d_wid').html());
					$('#add_item #item_height-1').val('');
					$('#add_item #item_height-1').val($('#tr'+trid+ ' #d_hei_l').html());
					$('#add_item #item_width-l').val('');
					$('#add_item #item_width-l').val($('#tr'+trid+ ' #d_wid_l').html());
					$('#add_item #sqft').val('');
					$('#add_item #sqft').val($('#tr'+trid+ ' #d_sqft').html());
					$('#add_item #cost').val('');
					$('#add_item #cost').val($('#tr'+trid+ ' #d_cost').html());
					$('#add_item #tiedto').val('');
					$('#add_item #tiedto').val($('#tr'+trid+ ' #d_tied').html());
					$('#add_item #ordernum').val('');
					$('#add_item #ordernum').val($('#tr'+trid+ ' #d_ordnum').html());
					$('#add_item #orderdate').val('');
					$('#add_item #orderdate').removeAttr('disabled','disabled');
					$('#add_item #orderdate').val(($('#tr'+trid+ ' #d_orddate').html()).replace(" ", "T"));
					$('#add_item #receivedate').val('');
					$('#add_item #receivedate').val(($('#tr'+trid+ ' #d_recedate').html()).replace(" ", "T"));
					
					$('#item_category_id').val(cat_type);
				}
			}else{
				if(type == 'add'){
					$('#itemAdd .modal-title h2').text('Add Item(Remnant Items)');
					$('#itemAdd #confirm_btn').text('ADD');
					var add_item_name = show_id + ' - ' + $('#ctg_name').text();
					$('#add_item #item_name').val(add_item_name)
				}else if(type == 'edit' || type == 'duplicate'){
					if(type == 'edit'){
						$('#itemAdd .modal-title h2').text('Edit Item(Remnant Items)');
						$('#itemAdd #confirm_btn').text('UPDATE');
					}else{
						$('#itemAdd .modal-title h2').text('Duplicate Item(Remnant Items)');
				  	$('#itemAdd #confirm_btn').text('ADD');
					}
					$('#itemAdd #trid').val(trid);
					 
					$('#add_item #item_name').val('');
					$('#add_item #item_name').val($('#tr'+trid+ ' #d_itemname').html());
					$('#add_item #item_qty').val('');
					$('#add_item #item_qty').val($('#tr'+trid+ ' #d_qty').html());
					$('#add_item #item_lot').val('');
					$('#add_item #item_lot').val($('#tr'+trid+ ' #d_lot').html());
					$('#add_item #item_location').val('');
					$('#add_item #item_location').val($('#tr'+trid+ ' #d_locat').html());
					$('#add_item #item_height').val('');
					$('#add_item #item_height').val($('#tr'+trid+ ' #d_hei').html());
					$('#add_item #item_width').val('');
					$('#add_item #item_width').val($('#tr'+trid+ ' #d_wid').html());
					$('#add_item #item_height-1').val('');
					$('#add_item #item_height-1').val($('#tr'+trid+ ' #d_hei_l').html());
					$('#add_item #item_width-l').val('');
					$('#add_item #item_width-l').val($('#tr'+trid+ ' #d_wid_l').html());
					$('#add_item #sqft').val('');
					$('#add_item #sqft').val($('#tr'+trid+ ' #d_sqft').html());
					$('#add_item #cost').val('');
					$('#add_item #cost').val($('#tr'+trid+ ' #d_cost').html());
					$('#add_item #tiedto').val('');
					$('#add_item #tiedto').val($('#tr'+trid+ ' #d_tied').html());
					$('#add_item #supplier').val('');
					$('#add_item #supplier').val($('#tr'+trid+ ' #d_sup').html());
					$('#add_item #ordernum').val('');
					$('#add_item #ordernum').val($('#tr'+trid+ ' #d_ordnum').html());
					$('#add_item #orderdate').val('');
					$('#add_item #orderdate').attr('disabled','disabled');
// 				  $('#add_item #orderdate').val(($('#tr'+trid+ ' #d_orddate').html()).replace(" ", "T"));
					$('#add_item #receivedate').val('');
				  $('#add_item #receivedate').val(($('#tr'+trid+ ' #d_recedate').html()).replace(" ", "T"));
				}
				 
			}
			if(cat_type == 1 || cat_type == 2) 
				$('#add_item #item_qty').val(1);
			var cur_cat_name = $('#cur_catid').val();
			$('.mdb-select').material_select('destroy');
			$ ( "[Id = item_category_id]").val (cur_cat_name).trigger( 'click');
			$('select').addClass('mdb-select');
			$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
			$('select[name=slabs_table_length]').addClass('mdb-select');
			$('select[name=remnant_table_length]').addClass('mdb-select');
			$('.mdb-select').material_select();
			
			$('#itemAdd').modal('show');
		},
		error: function(data) {
			console.log(data);
		}
	});
	
}

function add_item() {
	var item_update_type = $('#confirm_btn').text();
	var form = $("form#add_item");
	if(item_update_type == 'ADD'){
		if(form[0].checkValidity()) {
			var formdata = new FormData();
			var form_array = form.serializeArray();
			$.each(form_array, function(index, value){
				formdata.append(value.name, value.value);
			});
			formdata.append('image', $("#add_item #image")[0].files[0]);
			if($('#slabs_tables').hasClass('active'))
				formdata.append('item_type', 0);
			else
				formdata.append('item_type', 1);
			$.ajax({
				url: 'ajax_inv.php',
				data: formdata,
				type: 'POST',
				contentType: false,
				cache: false,
				processData:false,
				success: function(result) {
					$('#itemAdd').modal('hide');
					showdetail(show_id,show_type);
				},
				error: function(data) {
					console.log(data);
				}
			});
		}else{
			form[0].reportValidity();
		}
	}else{
		if(form[0].checkValidity()){
			var formdata = new FormData();
			var form_array = form.serializeArray();
			$.each(form_array, function(index, value){
				formdata.append(value.name, value.value);
			});
			formdata.append('image', $("#add_item #image")[0].files[0]);
			if($('#slabs_tables').hasClass('active'))
				formdata.append('item_type', 0);
			else
				formdata.append('item_type', 1);
			formdata.set('action','update_item');
			$.ajax({
				url: 'ajax_inv.php',
				data: formdata,
				type: 'POST',
				contentType: false,
				cache: false,
				processData:false,
				success: function(result) {
					console.log(result);
					$('#itemAdd').modal('hide');
					showdetail(show_id,show_type,show_name);
	// 				if(result.status === 'success'){
// 						location.reload();
	// 				}
				},
				error: function(data) {
					console.log(data);
				}
			});
		}else{
			form[0].reportValidity();
		}
	}
}

function show_adj() {
	$('body').find('#adjust-modal').focus();
	$("#adjust-modal").css({ background: "rgba(0, 0, 0, 0.43)" });
	$('#adjust-modal').show();
}

function hide_qty_md() {
	$("#adjust-modal").css({ background: "none" });
	$('#adjust-modal').hide();
}

function view_item(item_id) {	
	
	$.ajax({
		url: '../dymo/qrcode.php',
		data: 'item_id='+ item_id+'&category_name='+$('#ctg_name').text()+'&lot_num='+$('#tr'+item_id+ ' #d_lot').html()+'&width='+$('#tr'+item_id+ ' #d_wid').html()+'&height='+$('#tr'+item_id+ ' #d_hei').html()+'&width_l='+$('#tr'+item_id+ ' #d_wid_l').html()+'&height_l='+$('#tr'+item_id+ ' #d_hei_l').html()+'&sqft='+$('#tr'+item_id+ ' #d_sqft').html()+'&supplier='+$('#tr'+item_id+ ' #d_sup').html(),
		type: 'GET',
		success: function(result) {
			var url = 'https://amanziportal.com/dymo/qrcode.php?item_id='+item_id+'&category_name='+$('#ctg_name').text()+'&lot_num='+$('#tr'+item_id+ ' #d_lot').html()+'&width='+$('#tr'+item_id+ ' #d_wid').html()+'&height='+$('#tr'+item_id+ ' #d_hei').html()+'&width_l='+$('#tr'+item_id+ ' #d_wid_l').html()+'&height_l='+$('#tr'+item_id+ ' #d_hei_l').html()+'&sqft='+$('#tr'+item_id+ ' #d_sqft').html()+'&supplier='+$('#tr'+item_id+ ' #d_sup').html();
			$('#view_item-modal iframe').attr('src',url);
			$('#view_item-modal').modal('show');
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function hide_item_md() {
	$('#view_item-modal').modal('hide');
}

function print_item() {
	alert( $('iframeId').contents().get(0).location.href );
}
function viewitem() {
	$('#result').addClass('hidden');
	$('.qrscan_section').addClass('hidden');
	if($('#item_id').val() === '') {
		$('#view_item_section').addClass('hidden');
		$('.blank_high').html('<p>There is no result...</p>')
		return;
	}else{
		$('.blank_high').html('')
		$('#view_item_section').removeClass('hidden');
		var sup_html = '<label class="col-6 mb-3" for="supplier">Supplier:</label><select class="col-9 mb-3 mdb-select" id="supplier" name="supplier">';
		$.ajax({
			url: 'ajax_inv.php',
			data: 'action=show_item&item_id='+$('#item_id').val(),
			type: 'POST',
			success: function(result) {
				if(JSON.parse(result).status == 'success') {
					console.log(JSON.parse(result).data[0]);
					$('#item_type').val(JSON.parse(result).data[0]['remnant']);
					$('#itemid').val(JSON.parse(result).data[0]['item_id']);
					$('#item_category_id').val(JSON.parse(result).data[0]['category_id']);
					$.each(JSON.parse(result).data[0], function(index, value){
						var id_tag = '#'+index;
						if(value != null && (index == 'date_ordered' || index == 'date_received'))
							value = value.replace(" ", "T");
						$(id_tag).val(value);
					});
					$.each(JSON.parse(result).supplier, function(ind, val){
						if(val.id == JSON.parse(result).data[0]['id']){
							sup_html += '<option value="'+val.id+'" selected>'+val.company+'</option>';
						}else{
							sup_html += '<option value="'+val.id+'">'+val.company+'</option>';
						}
					});
					sup_html += '</select>';
					if(JSON.parse(result).data[0]['remnant'] != 1){
						$('.height_l_section').addClass('hidden');
						$('.width_l_section').addClass('hidden');
					}else{
						$('.height_l_section').removeClass('hidden');
						$('.width_l_section').removeClass('hidden');
					}
					$('#supplier_section').html(sup_html);
					$('.mdb-select').material_select('destroy');
					$('select').addClass('mdb-select');
					$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
					$('select[name=slabs_table_length]').addClass('mdb-select');
					$('select[name=remnant_table_length]').addClass('mdb-select');
					$('.mdb-select').material_select();
				}
			},
			error: function(data) {
				console.log(data);
			}
		});		
	}
}

function show_qty_adj() {
	$('#adjust-qty-modal').modal('show');	
}

function hide_qty_adj_md() {
	$('#adjust-qty-modal').modal('hide');	
}

function confirm_update_itemqty() {
	if($('#adjust-qty-modal #qty_update').val()){
		$.ajax({
			url: 'ajax_inv.php',
			data: 'action=update_item_qty&item_id='+$('#itemid').val()+'&item_qty='+$('#adjust-qty-modal #qty_update').val(),
			type: 'POST',
			success: function(result) {
				console.log(JSON.parse(result).status);
				if(JSON.parse(result).status == 'success'){
					toastr.success('Item Qty Updated!');
					$('#adjust-qty-modal').modal('hide');
					$('#qty').val($('#adjust-qty-modal #qty_update').val());
				}
			},
			error: function(data) {
				toastr.error('Failed! Please try again');
				console.log(data);
			}
		});
	}
}

function update_item() {
	var form = $("form#view_item_section");
	if(form[0].checkValidity()){
		var formdata = new FormData();
		var form_array = form.serializeArray();
		$.each(form_array, function(index, value){
			formdata.append(value.name, value.value);
		});
		formdata.append('image', $("#view_item_section #image")[0].files[0]);
		$.ajax({
			url: 'ajax_inv.php',
			data: formdata,
			type: 'POST',
			contentType: false,
			cache: false,
			processData:false,
			success: function(result) {
				console.log(result);
			},
			error: function(data) {
				console.log(data);
			}
		});
	}else{
		form[0].reportValidity();
	}
}

function print_item() {
	$.ajax({
		url: '../dymo/qrcode.php',
		data: 'item_id='+ $('#itemid').val()+'&category_name='+$('#item_category_id').val()+'&lot_num='+$('#lot').val()+'&width='+$('#width').val()+'&height='+$('#height').val()+'&width_l='+$('#width_l').val()+'&height_l='+$('#height_l').val()+'&sqft='+$('#sqft').val()+'&supplier='+$('#supplier').val(),
		type: 'GET',
		success: function(result) {
			var url = 'https://amanziportal.com/dymo/qrcode.php?item_id='+$('#itemid').val()+'&category_name='+$('#item_category_id').val()+'&lot_num='+$('#lot').val()+'&width='+$('#width').val()+'&height='+$('#height').val()+'&width_l='+$('#width_l').val()+'&height_l='+$('#height_l').val()+'&sqft='+$('#sqft').val()+'&supplier='+$('#supplier').val()
			$('#view_item-modal iframe').attr('src',url);
			$('#view_item-modal').modal('show');
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function runScript(e) {
	//See notes about 'which' and 'key'
	if (e.keyCode == 13) {
		viewitem();
	}
}

function viewitem_qr() {
	$('.blank_high').html('');
	$('#item_id').val('');
	$('#view_item_section').addClass('hidden');
	$('.qrscan_section').removeClass('hidden');
	$('#result').removeClass('hidden');
	
}