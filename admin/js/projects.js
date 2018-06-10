matObj = [];
$uid = '';
$pid = '';
$iid = '';
$repId = '';
$uName = '';
$pName = '';
$iName = '';
$qNum = '';
$oNum = '';
$uAccess = '';
$uMultiplier = '';
$level1 = '';
$level2 = '';
$level3 = '';
$level4 = '';
$level5 = '';
$level6 = '';
$level7 = '';
$level8 = '';
$level9 = '';
$level1c = '';
$level2c = '';
$level3c = '';
$level4c = '';
$level5c = '';
$level6c = '';
$level7c = '';
$level8c = '';
$level9c = '';
$curPrice = 0;
$curCost = 0;
$instForm = '';
$defaultEdge = 0;
$addChange = 0;

function statusChange(user,pjt,status) {
	var datastring = 'action=change_status&staffid=' + user + '&pid=' + pjt + '&status=' + status;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			viewThisProject($pid, $uid);
		},
		error: function(data) {
			console.log(data);
		},
		complete: function(data) {
			console.log(JSON.stringify(data));
			Command: toastr["success"]("Status Changed to" + data + ".", "Projects")
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": 300,
				"hideDuration": 1000,
				"timeOut": 5000,
				"extendedTimeOut": 1000,
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}

		}
	});
}

function statusUpdate($statId) {
	$statName = $('#changeStatus option:selected').text();
	$percent = $statId + '%';
	var lastDigit = $statId%10;
	if (lastDigit == 9) {
		$('#progressStatus .progress-bar').addClass('bg-danger');
	} else {
		$('#progressStatus .progress-bar').removeClass('bg-danger');
	}
	$('#pjtDetails #progressStatus .progress-bar').width($percent);
	$('#pjtDetails #progressStatus .progress-bar').text($statName);

	var statusdata = 'action=update_job_status&pid=' + $pid + '&status=' + $statId;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: statusdata,
		success: function(data) {
			setTimeout(function(){ statusSet(); }, 300);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}


function recalculate($cpSqFt) {
	var datastring = 'action=recalculate&uid=' + $uid + '&cpSqFt=' + $cpSqFt;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function update_inst_dicounts(pid) {
	var datastring = "action=update_inst_dicounts&pid=" + pid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function adjustDiscoutsM(cName,mDisc,qDisc) {
	$('#custDiscount').text(cName);
	$('#mDisc').val(mDisc);
	$('#qDisc').val(qDisc);
	$('#user_discounts').modal('show');
}

function update_discounts($access_level) {
	$('input').removeClass('is-invalid');
	if ($access_level > 1) {
		if ($('#mDisc').val() > 15) {
			alert("Only Sales Managers have access to set marble & graninte discounts above 15%");
			$('#mDisc').addClass('is-invalid');
			$('#mDisc').focus();
			return;
		}
		if ($('#qDisc').val() > 10) {
			alert("Only Sales Managers have access to set quartz discount above 10%");
			$('#qDisc').addClass('is-invalid');
			$('#qDisc').focus();
			return;
		}
	} else {
		if ($('#mDisc').val() > 35) {
			alert("35% is the maximum discount allowed on quartz");
			$('#mDisc').addClass('is-invalid');
			$('#mDisc').focus();
			return;
		}
		if ($('#qDisc').val() > 20) {
			alert("20% is the maximum discount allowed on quartz!");
			$('#qDisc').addClass('is-invalid');
			$('#qDisc').focus();
			return;
		}
	}
	var datastring = 'action=update_discounts&uid=' + $uid + '&discount=' + $('#mDisc').val() + '&discount_quartz=' + $('#qDisc').val();
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('#custDiscount').text('');
			$('#mDisc').val(0);
			$('#qDisc').val(0);
			$('#user_discounts').modal('hide');
			viewThisProject($pid, $uid);
		},
		error: function(data) {
			alert(data);
		}
	});
}

function quartzcalc($mat, $price) {
	var $form;
	if ($("#updateInstall").is(":visible") == true) {
		$form = '#updateInstall';
	} else {
		$form = '#add_new_step2';
	}
	var datastring = '';
	var cpSqFt;
	var $SqFt = $($form).find('input[name=SqFt]').val();
	var $slabs = $($form).find('input[name=slabs]').val();
	var $cpSqFt_override = $($form).find('input[name=cpSqFt_override]').val();
	console.log($cpSqFt_override);
	if ($("#updateInstall").is(":visible") == true) {
		datastring = 'action=quartz_sqft_calc_update&pid=' + $pid + '&color=' + $mat + '&iid=' + $iid;
	} else {
		datastring = 'action=quartz_sqft_calc&pid=' + $pid + '&color=' + $mat;
	}
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			var $discounta = 100 - parseFloat($('#qpct').text());
			var res = data.split("::");
			var slabCalc = 0;
			var sqftCalc = 0;
			if (res[1] != '') {
				slabCalc = res[1];
			}
			if (res[0] != '') {
				sqftCalc = res[0];
			}
			var newSlabs = parseFloat(slabCalc) + parseFloat($slabs);
			var totSlabs = newSlabs * $price;
			var newSqFt = Math.ceil(parseFloat(sqftCalc) + parseFloat($SqFt));
			if ($cpSqFt_override > 0) {
				cpSqFt = Math.ceil($cpSqFt_override);
			} else {
				cpSqFt = ((totSlabs / newSqFt) + 21.5) * 1.45;
				if ($discounta != 100) {
					var $discountb = '0.' + $discounta;
					var $discountc = $discountb * 1;
					cpSqFt = Math.ceil(cpSqFt * $discountc);
				} else {
					cpSqFt = Math.ceil(cpSqFt);
				}
			}
			priceTotal = cpSqFt * $SqFt;
			if (newSlabs < 1) {
				priceTotal = 0;
				cpSqFt = 0;
				alert('You will need to add at least one slab to this material to see a price.');
			}
			$($form).find('input[name=price_calc]').val(priceTotal);
			$($form).find('input[name=cpSqFt]').val(cpSqFt);
			datastring = 'action=mat_price_recalc&pid=' + $pid + '&color=' + $mat + '&cpSqFt=' + cpSqFt;
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: datastring,
				success: function(data) {
					console.log('Update data: '+data);
				}
			});
		},
		error: function(data) {
			alert(data);
		}
	});
}

function marbcalc($mat, $price) {
	var $form;
	if ($("#updateInstall").is(":visible") === true) {
		$form = $('#updateInstall');
	} else {
		$form = $('#add_new_step2');
	}
	var $SqFt = $($form).find('input[name=SqFt]').val();
	var $discounta = 100 - parseInt($('#pct').text());
	var cpSqFt = Math.ceil($price);
	var $cpSqFt_override = $($form).find('input[name=cpSqFt_override]').val();
	console.log('CpSqFt: ' + Math.ceil(cpSqFt));

	if ($cpSqFt_override > 0) {
		cpSqFt = Math.ceil($cpSqFt_override);
	} else {
		if ($discounta != 100) {
			var $discountb = '0.' + $discounta;
			var $discountc = $discountb * 1;
			cpSqFt = Math.ceil(cpSqFt * $discountc);
		}
	}
	priceTotal = cpSqFt * $SqFt;
	console.log('Total: ' + Math.ceil(priceTotal));
	$($form).find('input[name=price_calc]').val(priceTotal);
	$($form).find('input[name=cpSqFt]').val(cpSqFt);
}


function check_address() {
	$('input[name=job_lat]').val(null);
	$('input[name=job_long]').val(null);
	var $add1 = $('input[name=address_1]').val();
	var $add2 = $('input[name=address_2]').val();
	var $city = $('input[name=city]').val();
	var $zip = $('input[name=zip]').val();
	var datastring = 'action=get_address_geo&address_1=' + $add1 + '&address_2=' + $add2 + '&city=' + $city + '&zip=' + $zip;
	console.log(datastring);

	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			var res = data.split("::");

			if (data == 'Failed') {
				$('.addVF').addClass('hidden');
				$('.addLU').addClass('hidden');
				$('.addFA').removeClass('hidden');
				$addChange = 2;
			} else {
				$('input[name=job_lat]').val(res[0]);
				$('input[name=job_long]').val(res[1]);
				$('.addLU').addClass('hidden');
				$('.addFA').addClass('hidden');
				$('.addVF').removeClass('hidden');
				$addChange = 0;
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function calcOutside() {
	var a = $('#size_a').val();
	var b = $('#size_b').val();
	var c = $('#size_c').val();
	var d = $('#size_d').val();
	var e = $('#size_e').val();
	var f = $('#size_f').val();
	if (a < 1 || f < 1 || e < 1) {
		alert("You must have at least 'a' - 'f' &amp; 'e' entered.");
		return;
	}
	if (d < 1) {
		d = a;
	}
	c = e - a;
	b = f - d;

	$('#size_b').val(b);
	$('#size_c').val(c);
	$('#size_d').val(d);

}

function calcInside() {
	var a = $('#size_a').val();
	var b = $('#size_b').val();
	var c = $('#size_c').val();
	var d = $('#size_d').val();
	var e = $('#size_e').val();
	var f = $('#size_f').val();
	if (a < 1 || b < 1 || c < 1) {
		alert("You must have at least 'a' - 'b' &amp; 'c' entered.");
		return;
	}
	if (d < 1) {
		d = a;
	}
	f = parseInt(b) + parseInt(d);
	e = parseInt(a) + parseInt(c);

	$('#size_d').val(d);
	$('#size_e').val(e);
	$('#size_f').val(f);

}



//<i class="fas fa-equal"></i>

function openQRCamera(node) {
  var reader = new FileReader();
  reader.onload = function() {
	node.value = "";
	qrcode.callback = function(res) {
	  if(res instanceof Error) {
		alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
	  } else {
		node.parentNode.previousElementSibling.value = res;
	  }
	};
	qrcode.decode(reader.result);
  };
  reader.readAsDataURL(node.files[0]);
}


function recalculateInstall(iid) {
	var datastring = 'action=recalculate_install&iid=' + iid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function() {
			viewThisProject($pid,$uid);
			viewThisInstall($iid, $pid, $uid);
		},
		error: function(data) {
			alert(data);
		}
	});
}

function delete_install(iid,pid,instName) {
	if (window.confirm("Are you sure you want to delete this Install from the Database?")) {
		var datastring = 'action=delete_install&id=' + iid + '&pid=' + pid + '&install_name=' + instName;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				viewThisProject($pid,$uid);
			},
			error: function(data) {
				alert(data);
			}
		});
	} else {
		return;
	}
}

function deletePiece(sid) {
	if (window.confirm("Are you sure you want to delete this piece from the Database?")) {
		var datastring = 'action=delete_piece&id=' + sid + '&iid=' + $iid;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function() {
				recalculateInstall($iid);
			},
			error: function(data) {
				alert(data);
			}
		});
	} else {
		return;
	}
}

function editSink(sink_id, sink_iid, sink_part, sink_model, sink_mount, sink_provided, sink_holes, sink_soap, cutout_width, cutout_depth, sink_cost, sink_price, cutout_price) {
	$('.mdb-select').material_select('destroy');
	var sho = '#sho_' + sink_id;
	var sho_data = $(sho).text();
	var sink_name_div = '#sink_' + sink_id;
	var sink_name = $(sink_name_div).text();
	var datastring = "action=get_pieces&iid=" + sink_iid + '&sink_part=' + sink_part;
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		cache: false,
		type: 'POST',
		success: function(data) {
			$('#e-sink_part').append('<option value="0">Unassigned</option>');
			$('#e-sink_part').append(data);
		},
		error: function(data) {
			alert(data);
		},
		complete: function() {
			$('.mdb-select').material_select('destroy');
			$('#e-sink_part').val(sink_part);
			$('.mdb-select').material_select();
		}
	});
	$('#e-sink_id').val(sink_id);
	$('#e-sink_iid').val(sink_iid);
	$('#e-sink_price').val(sink_price);
	$('#e-sink_cost').val(sink_cost);
	$('#e-cutout_width').val(cutout_width);
	$('#e-cutout_depth').val(cutout_depth);
	$('#e-cutout_price').val(cutout_price);
	$('#e-sink_model').val(sink_name);
	$('#e-sink_holes_other').val(sho_data);
	$('#e-sink_holes').val(sink_holes);

	$('#e-sink_provided').val(sink_provided);
	$('#e-sink_provided').val(sink_provided);
	$('#e-sink_mount').val(sink_mount);
	if (sink_soap == 1) {
		$('#e-sink_soap').prop('checked',true);
	}
	$('.mdb-select').material_select();
	$('#edit_sink').modal('show');
}

function deleteSink(isid) {
	if (window.confirm("Are you sure you want to delete this sink from the Database?")) {
		var datastring = 'action=delete_sink&isid=' + isid + '&iid=' + $iid;
		console.log(datastring);
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function() {
				recalculateInstall($iid);
			},
			error: function(data) {
				alert(data);
			}
		});
	} else {
		return;
	}
}
// Default Edge not working yet.
function pieceAdder() {
	$('.mdb-select').material_select('destroy');
	$('#piece_id').val(0);
	$('#iid').val('');
	$('#pid').val('');
	$('#SqFt').val('');
	$('#pcPriceExtra').val('');
	$('#pcSqFt').val('');
	$('#piece_name').val('');
	$('#shape').val(1);
	$('#size_x').val('');
	$('#size_x').val('');
	$('#size_y').val('');
	$('#size_a').val('');
	$('#size_b').val('');
	$('#size_c').val('');
	$('#size_d').val('');
	$('#size_e').val('');
	$('#size_f').val('');
	$('#piece_edge').val(0);
	$('#edge_length').val(0);
	$('#bs_height').val(0);
	$('#bs_length').val(0);
	$('#rs_height').val(0);
	$('#rs_length').val(0);
	if ($('.rect_shape').hasClass('d-none') == true) {
		$('.rect_shape').removeClass('d-none');
		$('.rect_shape').addClass('d-inline-block');
		$('.l_shape').removeClass('d-inline-block');
		$('.l_shape').addClass('d-none');
		$('.bevel_shape').removeClass('d-inline-block');
		$('.bevel_shape').addClass('d-none');
	}
	$('#add_piece').modal('show');
	$dEdge = $('#dEdge').text() * 1;
	$('#piece_title').text('Add Piece');
	$('#piece_edge').val($dEdge);
	$('.mdb-select').material_select();
}


// Default Edge not working yet.
function sinkAdder() {
	$('.mdb-select').material_select('destroy');
	$('#sink_part').html('');
	var datastring = "action=get_pieces&iid=" + $iid;
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		cache: false,
		type: 'POST',

		success: function(data) {
			$('.mdb-select').material_select('destroy');
			$('#sink_part').append('<option value="0">Unassigned</option>');
			$('#sink_part').append(data);
			$('.mdb-select').material_select();
			$('#add_sink').modal('show');
		},
		error: function(data) {
			alert(data);
		}
	});
	$('.mdb-select').material_select();
}

function add_sink(form) {
	$('#addSinkBtn').hide();
	var $form = '#' + form;
	var $part = $('#sink_part').val();
	var $provided = $('#sink_provided').val();
	var $faucet = $('#sink_faucet').val();
	var $model = $($form).find('#sink_model').val();
	var $sink_name = $model;
	var $faucet_name = $faucet;
	var $mount = $('#sink_mount').val();
	var $holes = $('#sink_holes').val();
	var $other = $('#sink_holes_other').val();
	var $soap = 0;
	if($( '#sink_soap' ).prop( "checked" ) == true) {
		$soap = 1;
	}
	var $width = $('#cutout_width').val();
	var $depth = $('#cutout_depth').val();
	var $sPrice = 0;
	var $fPrice = 0;
	var $cPrice = 0;

	var $sSelected = '#add_sink option:contains(' + $model + ')';

	var $fSelected = '#add_sink option:contains(' + $faucet + ')';

	var $sCost = $($sSelected).attr('cost');
	var $fCost = $($fSelected).attr('cost');

	if ($provided == 0) {
		$sPrice = $($sSelected).attr('price');
		if ($sPrice == 0) {
			if (window.confirm('You have not entered a valid sink. Or the sink entered is not in the database. Are you sure you want to continue? Any charges for this sink will have to be added to the installs "Extra Costs"')) {
			} else {
				$('#addSinkBtn').show();
				return;
			}
		}
		$fPrice = $($fSelected).attr('price');
		if ($fPrice == 0) {
			if (window.confirm('You have not entered a faucet. Or the faucet entered is not in the database. Are you sure you want to continue? Any charges for this faucet will have to be added to the installs "Extra Costs"')) {
			} else {
				$('#addSinkBtn').show();
				return;
			}
		}
	} else {
		$sCost = 0;
		$fCost = 0;
		$sPrice = 0;
		$fPrice = 0;
	}
	if (($('#type_cost').text() * 1) == 1) {
		$cPrice = 50;
	} else if (($('#type_cost').text() * 1) == 2) {
		$cPrice = 100;
	}
	if ($('#sink_model').val() == "") {
		alert("You must provide a Sink Model.");
		$('#addSinkBtn').show();
		return;
	}
	$model = $($sSelected).attr('accs_id');
	$faucet = $($fSelected).attr('accs_id');
	if ($model < 1 || $model == null) {
		$model = 0;
	} 
	var datastring = 'action=add_sink' +
					 '&sink_iid=' + $iid +
					 '&sink_part=' + $part +
					 '&sink_provided=' + $provided +
					 '&sink_model=' + $model +
					 '&sink_mount=' + $mount +
					 '&sink_holes=' + $holes +
					 '&sink_holes_other=' + $other +
					 '&sink_soap=' + $soap +
					 '&cutout_width=' + $width +
					 '&cutout_depth=' + $depth +
					 '&sink_price=' + $sPrice +
					 '&cutout_price=' + $cPrice +
					 '&sink_cost=' + $sCost +
					 '&sink_name=' + $sink_name;
	console.log(datastring);
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log(data);
			$('#sink_provided').val(0);
			$('#sink_faucet').val('');
			$('#sink_model').val('');
			$('#sink_mount').val(0);
			$('#sink_holes').val(0);
			$('#sink_holes_other').val('');
			$('#sink_soap').val(0);
			$('#cutout_width').val(0);
			$('#cutout_depth').val(0);
			$('#sink_price').val('');
			$('#faucet_price').val(0);
			$('#cutout_price').val(0);
			$('#addSinkBtn').show();
			$('#add_sink').modal('hide');
			if ($faucet != '') {
				var datastring = 'action=add_faucet' +
								 '&sink_iid=' + $iid +
								 '&sink_provided=' + $provided +
								 '&sink_faucet=' + $faucet +
								 '&sink_part=' + $part +
								 '&faucet_price=' + $fPrice +
								 '&faucet_cost=' + $fCost +
								 '&faucet_name=' + $faucet_name;
				$.ajax({
					url: 'ajax.php',
					data: datastring,
					type: 'POST',
					success: function() {
						$('#addSinkBtn').show();
						$('#add_sink').modal('hide');
						recalculateInstall($iid);
					},
					error: function(data) {
						$('#addSinkBtn').show();
						console.log(data);
					}, 
					complete: function() {
						$('#add_sink').modal('hide');
						recalculateInstall($iid);
					}
				});
			}
		},
		error: function(data) {
			$('#addSinkBtn').show();
			console.log(data);
		}, 
		complete: function(data) {
			console.log(data);
			$('#add_sink').modal('hide');
			recalculateInstall($iid);
		}
	});
}


function update_sink(form) {
	$('#updateSinkBtn').hide();
	var $form = '#' + form;
	var $sink_id = $('#e-sink_id').val();
	var $part = $('#e-sink_part').val();
	var $provided = $('#e-sink_provided').val();
	var $model = $('#e-sink_model').val();
	var $sink_name = $model;
	var $mount = $('#e-sink_mount').val();
	var $holes = $('#e-sink_holes').val();
	var $other = $('#e-sink_holes_other').val();
	var $soap = 0;
	if($( '#e-sink_soap' ).prop( "checked" ) == true) {
		$soap = 1;
	}
	var $width = $('#e-cutout_width').val();
	var $depth = $('#e-cutout_depth').val();
	var $sPrice = 0;
	var $cPrice = $('#e-cutout_price').val();

	var $sSelected = '#edit_sink option:contains(' + $model + ')';

	var $sCost = $($sSelected).attr('cost');

	if ($provided == 0) {
		$sPrice = $($sSelected).attr('price');
		if ($sPrice == 0) {
			if (window.confirm('You have not entered a valid sink. Or the sink entered is not in the database. Are you sure you want to continue? Any charges for this sink will have to be added to the installs "Extra Costs"')) {
			} else {
				$('#updateSinkBtn').show();
				return;
			}
		}
	} else {
		$sCost = 0;
		$sPrice = 0;
	}
	if ($('#e-sink_model').val() == "") {
		alert("You must provide a Sink Model.");
		$('#updateSinkBtn').show();
		return;
	}
	$model = $($sSelected).attr('accs_id');
	if ($model < 1 || $model == null) {
		$model = 0;
	} 
	console.log($model);
	var datastring = 'action=update_sink' +
					 '&sink_id=' + $sink_id +
					 '&sink_iid=' + $iid +
					 '&sink_part=' + $part +
					 '&sink_provided=' + $provided +
					 '&sink_model=' + $model +
					 '&sink_mount=' + $mount +
					 '&sink_holes=' + $holes +
					 '&sink_holes_other=' + $other +
					 '&sink_soap=' + $soap +
					 '&cutout_width=' + $width +
					 '&cutout_depth=' + $depth +
					 '&sink_price=' + $sPrice +
					 '&cutout_price=' + $cPrice +
					 '&sink_cost=' + $sCost +
					 '&sink_name=' + $sink_name;
	console.log(datastring);
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log(data);
			$('#edit_sink').modal('hide');
		},
		error: function(data) {
			alert(data);
			$('#updateSinkBtn').show();
		}, 
		complete: function() {
			$('#edit_sink').modal('hide');
			$('#updateSinkBtn').show();
			recalculateInstall($iid);
		}
	});
}



function addPiece(form) {
	$('input').removeClass('is-invalid');
	var pForm = "form#" + form;
	var SqFt = 0;
	var a, b, c, d, e, f;
	var hBacksplash = $(pForm).find('#bs_height').val();
	var wBacksplash = $(pForm).find('#bs_length').val();
	var hRiser = $(pForm).find('#rs_height').val();
	var wRiser = $(pForm).find('#rs_length').val();

	if ($(pForm).find('#piece_name').val() == "") {
		$(pForm).find('#piece_name').addClass('is-invalid');
		$(pForm).find('#piece_name').focus();
		alert('Piece must be given a name.');
		return;
	}
	if ($(pForm).find('#shape').val() == 4) {
		SqFt = $(pForm).find('#SqFt').val();
		$(pForm).find('#size_x').val(0);
		$(pForm).find('#size_y').val(0);
		$(pForm).find('#size_a').val(0);
		$(pForm).find('#size_b').val(0);
		$(pForm).find('#size_c').val(0);
		$(pForm).find('#size_d').val(0);
		$(pForm).find('#size_e').val(0);
		$(pForm).find('#size_f').val(0);
	} else if ($(pForm).find('#shape').val() == 2) {
		a = Math.ceil($(pForm).find('#size_a').val());
		if (a<=0) {
			$(pForm).find('#size_a').addClass('is-invalid');
			$(pForm).find('#size_a').focus();
			return;
		}
		b = Math.ceil($(pForm).find('#size_b').val());
		if (b<=0) {
			$(pForm).find('#size_b').addClass('is-invalid');
			$(pForm).find('#size_b').focus();
			return;
		}
		c = Math.ceil($(pForm).find('#size_c').val());
		if (c<=0) {
			$(pForm).find('#size_c').addClass('is-invalid');
			$(pForm).find('#size_c').focus();
			return;
		}
		d = Math.ceil($(pForm).find('#size_d').val());
		if (d<=0) {
			$(pForm).find('#size_d').addClass('is-invalid');
			$(pForm).find('#size_d').focus();
			return;
		}
		e = Math.ceil($(pForm).find('#size_e').val());
		if (e<=0) {
			$(pForm).find('#size_e').addClass('is-invalid');
			$(pForm).find('#size_e').focus();
			return;
		}
		f = Math.ceil($(pForm).find('#size_f').val());
		if (f<=0) {
			$(pForm).find('#size_f').addClass('is-invalid');
			$(pForm).find('#size_f').focus();
			return;
		}
		if (a+c != e) {
			alert("a = " + a + ". c = " + c + ". e = " + e + ". 'a' & 'c' do not match 'e'");
			$(pForm).find('#size_a').addClass('is-invalid');
			$(pForm).find('#size_c').addClass('is-invalid');
			$(pForm).find('#size_e').addClass('is-invalid');
			return;
		}
		if (b+d != f) {
			alert("'b' & 'd' do not match 'f'");
			$(pForm).find('#size_b').addClass('is-invalid');
			$(pForm).find('#size_d').addClass('is-invalid');
			$(pForm).find('#size_f').addClass('is-invalid');
			return;
		}
		var p1 = Math.ceil(a*b);
		var p2 = Math.ceil(d*e);
		SqFt = Math.ceil((p1+p2)/144);
	} else {
		a = $(pForm).find('#size_x').val();
		if (a<=0) {
			$(pForm).find('#size_x').addClass('is-invalid');
			$(pForm).find('#size_x').focus();
			return;
		}
		$(pForm).find('#size_a').val($(pForm).find('#size_x').val());
		b = $(pForm).find('#size_y').val();
		if (b<=0) {
			$(pForm).find('#size_y').addClass('is-invalid');
			$(pForm).find('#size_y').focus();
			return;
		}
		$(pForm).find('#size_b').val($(pForm).find('#size_y').val());
		SqFt = Math.ceil((a*b)/144);
		$(pForm).find('#size_c').val(0);
		$(pForm).find('#size_d').val(0);
		$(pForm).find('#size_e').val(0);
		$(pForm).find('#size_f').val(0);
	}
	if ($(pForm).find('#piece_edge option:selected').attr('price') > 0) {
		if ($(pForm).find('#edge_length').val() <= 0 ) {
			$(pForm).find('#edge_length').addClass('is-invalid');
			$(pForm).find('#edge_length').focus();
			alert('You must enter the length of finished edge in inches.');
			return;
		}

	}
	var backsplash = 0;
//		if (hBacksplash == 0 || wBacksplash == 0) {
//			if (hBacksplash != 0 || wBacksplash != 0) {
//				alert("You can not have a Backsplash height without a length, or visa versa.");
//				$(pForm).find('#bs_height').addClass('is-invalid');
//				$(pForm).find('#bs_length').addClass('is-invalid');
//				if (hBacksplash == 0) {
//					$(pForm).find('#bs_height').focus();
//				} else {
//					$(pForm).find('#bs_length').focus();
//				}
//				return;
//			}
//		}
	backsplash = Math.ceil((hBacksplash*wBacksplash)/144);
	console.log(backsplash);
	SqFt = parseInt(SqFt) + backsplash;
	console.log(SqFt);
	var riser = 0;
//		if (hRiser == 0 || wRiser == 0) {
//			if (hRiser != 0 || wRiser != 0) {
//				alert("You can not have a Riser height without a length, or visa versa.");
//				$(pForm).find('#rs_height').addClass('is-invalid');
//				$(pForm).find('#rs_length').addClass('is-invalid');
//				if (hRiser == 0) {
//					$(pForm).find('#rs_height').focus();
//				} else {
//					$(pForm).find('#rs_length').focus();
//				}
//				return;
//			}
//		}
	riser = Math.ceil((hRiser*wRiser)/144);
	console.log(riser);
	SqFt = parseInt(SqFt) + riser;
	$(pForm).find('#SqFt').val(SqFt);
	$(pForm).find('#iid').val(Math.ceil($iid));
	$(pForm).find('#pid').val(Math.ceil($pid));
	$(pForm).find('#pcPriceExtra').val(Math.ceil($('#pullPriceExtra').text()));
	$(pForm).find('#pcSqFt').val(Math.ceil($('#pullCpSqFt').text()));
//		form = "$('form#add_piece')";
//		var formdata = false;
//		if (window.FormData) {
//			formdata = new FormData(form[0]);
//		}

	var size_x= $(pForm).find('#size_x').val();
	var size_y= $(pForm).find('#size_y').val();
	var size_a= $(pForm).find('#size_a').val();
	var size_b= $(pForm).find('#size_b').val();
	var size_c= $(pForm).find('#size_c').val();
	var size_d= $(pForm).find('#size_d').val();
	var size_e= $(pForm).find('#size_e').val();
	var size_f= $(pForm).find('#size_f').val();
	var SqFt= $(pForm).find('#SqFt').val();
	var iid= $(pForm).find('#iid').val();
	var pid= $(pForm).find('#pid').val();
	var piece_name= $(pForm).find('#piece_name').val();
	var shape= $(pForm).find('#shape').val();
	var piece_edge= $(pForm).find('#piece_edge').val();
	var edge_length= $(pForm).find('#edge_length').val();
	var bs_height= $(pForm).find('#bs_height').val();
	var bs_length= $(pForm).find('#bs_length').val();
	var rs_height= $(pForm).find('#rs_height').val();
	var rs_length= $(pForm).find('#rs_length').val();
	var piece_active= $(pForm).find('#piece_active').val();
	var price_extra= $(pForm).find('#pcPriceExtra').val();
	var pcSqFt= $(pForm).find('#pcSqFt').val();
	var pcId= $(pForm).find('#piece_id').val();

	var datastring;

	if (pcId > 0) {
		datastring = "action=add_piece&piece_id=" + pcId + "&size_x=" + size_x + "&size_y=" + size_y +"&size_a=" + size_a +"&size_b=" + size_b +"&size_c=" + size_c +"&size_d=" + size_d +"&size_e=" + size_e +"&size_f=" + size_f +"&SqFt=" + SqFt +"&iid=" + iid +"&pid=" + pid +"&piece_name=" + piece_name +"&shape=" + shape +"&piece_edge=" + piece_edge +"&edge_length=" + edge_length +"&bs_height=" + bs_height +"&bs_length=" + bs_length +"&rs_height=" + rs_height +"&rs_length=" + rs_length +"&price_extra=" + price_extra +"&pcSqFt=" + pcSqFt +"&piece_active=1";	
	} else {
		datastring = "action=add_piece&size_x=" + size_x + "&size_y=" + size_y +"&size_a=" + size_a +"&size_b=" + size_b +"&size_c=" + size_c +"&size_d=" + size_d +"&size_e=" + size_e +"&size_f=" + size_f +"&SqFt=" + SqFt +"&iid=" + iid +"&pid=" + pid +"&piece_name=" + piece_name +"&shape=" + shape +"&piece_edge=" + piece_edge +"&edge_length=" + edge_length +"&bs_height=" + bs_height +"&bs_length=" + bs_length +"&rs_height=" + rs_height +"&rs_length=" + rs_length +"&price_extra=" + price_extra +"&pcSqFt=" + pcSqFt +"&piece_active=1";
	}
	console.log(datastring);
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log(data);
			$('#add_piece').modal('hide');
			if ($('.rect_shape').hasClass('d-none') == true) {
				$('.rect_shape').removeClass('d-none');
				$('.rect_shape').addClass('d-inline-block');
				$('.l_shape').removeClass('d-inline-block');
				$('.l_shape').addClass('d-none');
				$('.bevel_shape').removeClass('d-inline-block');
				$('.bevel_shape').addClass('d-none');
				$('.sqft_shape').removeClass('d-inline-block');
				$('.sqft_shape').addClass('d-none');
				$('#piece_id').val(0);
			}
			recalculateInstall($iid);
		},
		error: function(data) {
			console.log(data);
			$('#piece_id').val(0);
		}
	});
}




















function edit_piece(ipid) {
	var datastring = 'action=get_piece_for_edit&piece_id=' + ipid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			compile_piece_edit(data);
		},
		error: function(data) {
			alert(data);
		}
	});
}

function compile_piece_edit(data) {
	$('.mdb-select').material_select('destroy');
	$('#piece_title').text('Edit Piece');
	var res = data.split(",");
	var obj = {};
	for (var i = 0; i < res.length; i++) {
		var split = res[i].split('::');
		obj[split[0]] = split[1];
	}
	$('#piece_id').val(obj.piece_id);
	$('form#add_piece input[name=iid]').val(obj.iid);
	$('form#add_piece input[name=pid]').val(obj.pid);
	$('form#add_piece input[name=pcPriceExtra]').val(obj.pcPriceExtra);
	$('form#add_piece input[name=pcSqFt]').val(obj.pcSqFt);
	$('form#add_piece input[name=piece_name]').val(obj.piece_name);
	$('form#add_piece select[name=shape]').val(obj.shape);
	if ( obj.shape == 1 || obj.shape == 3 ) {
		$('form#add_piece input[name=size_x]').val(obj.size_a);
		$('form#add_piece input[name=size_y]').val(obj.size_b);
		$('form#add_piece input[name=SqFt]').val(obj.SqFt);
	} else if ( obj.shape == 4 ) {
		var bsh = obj.bs_height;
		var bsl = obj.bs_length;
		var rsh = obj.rs_height;
		var rsl = obj.rs_length;
		var bs = Math.ceil(bsh * bsl / 144);
		var rs = Math.ceil(rsh * rsl / 144);
		var nSqFt = obj.SqFt - bs - rs;
		$('form#add_piece input[name=SqFt]').val(nSqFt);
	} else {
		$('form#add_piece input[name=size_a]').val(obj.size_a);
		$('form#add_piece input[name=size_b]').val(obj.size_b);
		$('form#add_piece input[name=size_c]').val(obj.size_c);
		$('form#add_piece input[name=size_d]').val(obj.size_d);
		$('form#add_piece input[name=size_e]').val(obj.size_e);
		$('form#add_piece input[name=size_f]').val(obj.size_f);
		$('form#add_piece input[name=SqFt]').val(obj.SqFt);
	}
	$('form#add_piece select[name=piece_edge]').val(obj.piece_edge);
	$('form#add_piece input[name=edge_length]').val(obj.edge_length);
	$('form#add_piece input[name=bs_height]').val(obj.bs_height);
	$('form#add_piece input[name=bs_length]').val(obj.bs_length);
	$('form#add_piece input[name=rs_height]').val(obj.rs_height);
	$('form#add_piece input[name=rs_length]').val(obj.rs_length);
	if ( obj.shape == 1 ) {
		if ($('.rect_shape').hasClass('d-none') == true) {
			$('.rect_shape').removeClass('d-none');
			$('.rect_shape').addClass('d-inline-block');
			$('.l_shape').removeClass('d-inline-block');
			$('.l_shape').addClass('d-none');
			$('.bevel_shape').removeClass('d-inline-block');
			$('.bevel_shape').addClass('d-none');
			$('.sqft_shape').removeClass('d-inline-block');
			$('.sqft_shape').addClass('d-none');
		}
	} else if ( obj.shape == 2 ) {
		if ($('.l_shape').hasClass('d-none') == true) {
			$('.l_shape').removeClass('d-none');
			$('.l_shape').addClass('d-inline-block');
			$('.rect_shape').removeClass('d-inline-block');
			$('.rect_shape').addClass('d-none');
			$('.bevel_shape').removeClass('d-inline-block');
			$('.bevel_shape').addClass('d-none');
			$('.sqft_shape').removeClass('d-inline-block');
			$('.sqft_shape').addClass('d-none');
		}
	} else if ( obj.shape == 3 ) {
		if ($('.bevel_shape').hasClass('d-none') == true) {
			$('.bevel_shape').addClass('d-inline-block');
			$('.bevel_shape').removeClass('d-none');
			$('.rect_shape').removeClass('d-inline-block');
			$('.rect_shape').addClass('d-none');
			$('.l_shape').removeClass('d-inline-block');
			$('.l_shape').addClass('d-none');
			$('.sqft_shape').removeClass('d-inline-block');
			$('.sqft_shape').addClass('d-none');
		}
	 } else if ( obj.shape == 4 ) {
		if ($('.sqft_shape').hasClass('d-none') == true) {
			$('.sqft_shape').addClass('d-inline-block');
			$('.sqft_shape').removeClass('d-none');
			$('.rect_shape').removeClass('d-inline-block');
			$('.rect_shape').addClass('d-none');
			$('.l_shape').removeClass('d-inline-block');
			$('.l_shape').addClass('d-none');
			$('.bevel_shape').removeClass('d-inline-block');
			$('.bevel_shape').addClass('d-none');
		}
	}
	$('.mdb-select').material_select();
	$('#add_piece').modal('show');

}

function entered_anya(pid) {
	var datastring = "action=entered_anya&pid=" + pid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function() {
			pjtBack();
		},
		error: function(data) {
			alert(data);
		}
	});
}


function entry_reject(pid) {
	var datastring = "action=entry_reject&pid=" + pid;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			alert(data);
			pjtBack();
		},
		error: function(data) {
			alert(data);
		}
	});
}

function loadEntries(){
	var datastring = "action=entry_list"
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#tableResults').html('');
			$('#tableResults').append(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: ";
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	setTimeout(loadEntries, 5000);
}

function loadTemplates(){
	var datastring = "action=templates_list"
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#tableResults').html('');
			$('#tableResults').append(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: ";
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	//setTimeout(loadTemplates, 5000);
}


function loadInstalls(){
	var datastring = "action=installs_list"
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#tableResults').html('');
			$('#tableResults').append(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: ";
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
	//setTimeout(loadInstalls, 5000);
}

//For project_timeline.php
function loadTimelines(){
  var datastring = "action=timelines_list";
  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: datastring,
    success: function(data) {
		$('#tableResults').html('');
		$('#tableResults').append(data);
		$('[data-toggle=popover]').popover();
    },
    error: function(xhr, status, error) {
      // alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: ";
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();  
    }
  });
}


function matModalOpen(element) {
	var formUse = $(element).closest('form').attr('id');
	$instForm = '#' + formUse;
	if ($('.matSelectCards').html() == '') {
		alert("You must first select a material.");
	} else {
		$('.matHolder').removeClass('hidden');
		//$('#materialSelect').modal('show');
	}
}

function matCardSel($mat, $price, $cost) {
	$curPrice = $price;
	$curCost = $cost;
	$($instForm).find('input[name=color]').val($mat);
	var $material = $('#updateInstall').find('select[name=material]').val();
	var $SqFt = $($instForm).find('input[name=SqFt]').val();
	var $slabs = $($instForm).find('input[name=slabs]').val();
	var $tPrice = $price;
	var cpSqFt = 0;
	var priceTotal = 0;
	if ($cost < 1) {
		$cost = 0;
	}
	if ($material == 'marbgran') {
		marbcalc($mat, $tPrice);
		var costing = parseFloat($SqFt) * parseFloat($cost);
		console.log(costing);
		$($instForm).find('input[name=materials_cost]').val(costing);
	} else if ($material == 'quartz') {
		quartzcalc($mat, $tPrice);
		var costing = parseFloat($slabs) * parseFloat($cost);
		console.log(costing);
		$($instForm).find('input[name=materials_cost]').val(costing);
	}
	if ($($instForm).find('input[name=materials_cost]').val() < 1) {
		$($instForm).find('input[name=materials_cost]').val(0);
	}

	$('.matHolder').addClass('hidden');
	//$('#materialSelect').modal('hide');
}

var successNote;

var succesStarter = '<div class="metro window-overlay"><div class="window shadow" style="min-width:200px; max-width:450px; top:200px; left:50%; margin-left:-225px;" ><div class="caption"><span class="icon icon-user-3"></span><div class="title">User Save Data</div><button class="btn-close" onClick="closeSuccess()"></button></div><div class="content">';

var successEnder = '</div><div id="closeFocus" class="button bg-yellow fg-white bd-red" style="width:75px; bottom:5px; margin-left:345px; margin-bottom:10px" tabindex="0" onclick="closeSuccess()">Close &#10008;</div></div>';




function pjtBack() {
	$("#pjtInstalls").empty();
	$("#pjtDetails").empty();
	$('#instDetails').empty();
	$("#user-block").show();
	$("#user-block").show();
	$('#materials-block').show();
}

function loadingAdd(button){
	alert('Loading...');
	var e = '$("#' + button + '")';
	e.append('<i id="loading" class="fa fa-spinner fa-spin"></i>');
}

function loadingRemove(){
	var e = '$("#' + button + '")';
	$("#loading").remove();
}




function sendQuoteData() {
	if (window.confirm("Please ensure you have a layout attached to the project... or Omar will find you, he will get you and... I think you know where this is going.")) {
	} else {
		return;
	}
//	if (!($('#address_verify').text() == "")) {
//		if (window.confirm('You do not have a valid address for this project. You should not send this to entry without full details for Templating or Installation. If you still wish to continue press "OK", otherwise, go back and fill in the address.')) {
//		} else {
//			return;
//		}
//	}

	if ( $('#sendAnya').hasClass('disabled') ){
		console.log('Already Sent!');
	} else {
		$('#sendAnya').addClass('disabled');
		if ($pName == '') {
			$pName = $('#projectName').text();
		}
		if ($qNum == '') {
			$qNum =  $('#s-quote_num').text();
		}
		if ($oNum == '') {
			$oNum =  $('#s-order_num').text();
		}

		datastring = 'action=email_anya&pid=' + $pid + '&uid=' + $uid + '&jobName=' + $pName + '&quoNum=' + $qNum + '&ordNum=' + $oNum;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				$('#email-success').modal('show');
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: "+xhr.responseText;
				$('#editSuccess').html(succesStarter+successNote+successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	}
}

function makeComment(e,cmt_user) {
	var datastring = 'action=comments_user_name&id=' + cmt_user;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('#commentor').text(data);
		},
		error: function(data) {
			alert(data);
		}
	});

	var cmt_type = $(e).attr('cmt_type').toString();

	if (cmt_type == 'pjt') {
		$('#cmt_ref_id').val($pid);
		$('#cmt_name').text($pName);
	} else if (cmt_type == 'usr') {
		$('#cmt_ref_id').val($uid);
		$('#cmt_name').text($uName);
	} else if (cmt_type == 'ins') {
		$('#cmt_ref_id').val($iid);
		$('#cmt_name').text($iName);
	}

	$('#cmt_type').val(cmt_type);
	$('#cmt_user').val(cmt_user);

	$('#addComment').modal('show');

}

function addUpload() {
	var newSection = '<input class="col-lg-3" onChange="addUpload();" name="imgUploads[]" type="file">';
	var uploadSection = $('#uploadContain');
	uploadSection.append(newSection);
}

function addInstUpload() {
	var newSection = '<input class="col-lg-3" onChange="addInstUpload();" name="imgUploads[]" type="file">';
	var uploadSection = $('#uploadInstall');
	uploadSection.append(newSection);
}

function autoFillBilling() {
	if (document.getElementById('sameAdd').checked == true){
		$("input#billing_name").val($("#fname").val()+' '+$("#lname").val());
		$("input#billing_company").val($("#company").val()); 
		$("input#billing_address1").val($("#address1").val()); 
		$("input#billing_address2").val($("#address2").val()); 
		$("input#billing_city").val($("#city").val()); 
		$("select#billing_state").val($("#state").val()); 
		$("input#billing_zip").val($("#zip").val()); 
	} else {
		$("input#billing_name").val(''); 
		$("input#billing_company").val(''); 
		$("input#billing_address1").val(''); 
		$("input#billing_address2").val(''); 
		$("input#billing_city").val(''); 
		$("select#billing_state").val(''); 
		$("input#billing_zip").val('');
	}
};

function closeSuccess(){
	$('#editSuccess').html('');
};

$('#closeFocus').bind('keydown', function(event) {
	if ( event.which > 0 ) {
		closeSuccess();
	}
});

function pullEditInst(instToEdit) {
	$('.matHolder').addClass('hidden');
	$('#editInstall').modal('show');
	var datastring = 'action=get_inst_for_update&id=' + instToEdit;

	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			compileInstEdit(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}

function compileInstEdit(data) {
	$('.mdb-select').material_select('destroy');

	$('#updateInstall')[0].reset();
	if ($('#p-job_discount').val() == '') {
		$('#p-job_discount').val(0);
	}
	if ($('#p-q_discount').val() == '') {
		$('#p-q_discount').val(0);
	}
	var res = data.split(",");
	var obj = {};
	for (var i = 0; i < res.length; i++) {
		var split = res[i].split('::');
		obj[split[0]] = split[1];
	}
	$('#inst_name').text(obj.install_name);

	$('#i-iid').val(obj.id);
	$('#i-pid').val(obj.pid);
	$('#i-install_name').val(obj.install_name);
	if (obj.type == 'Remodel') {
		$('#i-typeb').prop("checked", true);
	}
	$('#i-remodel').val(obj.remodel);
	if (obj.tear_out == 'No') {
		$('#i-tear_outb').prop("checked", true);
	}
	if (obj.tear_out == 'Yes') {
		$('#i-tear_outa').prop("checked", true);
	}
	$('#i-tearout_sqft').val(obj.tearout_sqft);
	$('#i-install_room').val(obj.install_room);

	$('#i-material').val(obj.material);
	$('#i-color-box').val(obj.color);
	$('#i-slabs').val(obj.slabs);

	$('#i-lot').val(obj.lot);
	if (obj.selected == "Yes") {
		$("#i-selecteda").prop("checked", true);
	} else if (obj.selected == "No") {
		$("#i-selectedb").prop("checked", true);
	}
	$('#i-edge').val(obj.edge);
	$('#i-bs_detail').val(obj.bs_detail);
	$('#i-rs_detail').val(obj.rs_detail);
	$('#i-sk_detail').val(obj.sk_detail);
	$('#i-range_type').val(obj.range_type);
	$('#i-cutout').val(obj.cutout);
	$('#i-range_model').val(obj.range_model);
	$('#i-holes').val(obj.holes);
	$('#i-holes_other').val(obj.holes_other);
	$('#i-install_notes').val(obj.install_notes);
	$('#i-SqFt').val(obj.SqFt);
	$('#i-cpSqFt_override').val(obj.cpSqFt_override);
	$('#i-price_calc').val(parseFloat(obj.price_calc));
	$('#i-accs_prices').val(parseFloat(obj.accs_prices));
	$('#i-price_extra').val(parseFloat(obj.price_extra));
	pullMaterials(obj.material);
	$('.mdb-select').material_select();
}

function compilePjtEdit(data) {
	$('.mdb-select').material_select('destroy');
	var res = data.split(",");
	var obj = {};
	for (var i = 0; i < res.length; i++) {
		var split = res[i].split('::');
		obj[split[0]] = split[1];
	}
	$('#pjt_name').text(obj.job_name);
	$('#p-acct_rep').val(obj.acct_rep);
	$('#p-pid').val(obj.id);
	$('#p-uid').val(obj.uid);
	uid = obj.uid;
	$('#p-job_name').val(obj.job_name);
	$('#p-job_tax').val(obj.job_tax);
	$('#p-job_discount').val(obj.job_discount);
	$('#p-discount_quartz').val(obj.discount_quartz);
	$('#p-quote_num').val(obj.quote_num);
	$('#p-order_num').val(obj.order_num);
	if (obj.template_date != '2200-01-01') {
		$('#p-template_date').val(obj.template_date);
	}

	if (obj.install_date != '2200-01-01') {
		$('#p-install_date').val(obj.install_date);
	}
	if ( obj.job_status < 20 && obj.job_status != 17  &&  obj.order_num.indexOf('o') < 1  &&  obj.order_num.indexOf('r') < 1  && obj.order_num.indexOf('O') < 1  &&  obj.order_num.indexOf('R') < 1 ) {
		$('#p-install_date').prop('readonly', 'readonly');
		console.log('killed');
	} else {
		if (obj.job_sqft > 1 || ( obj.order_num.indexOf('o') > 0  ||  obj.order_num.indexOf('r') > 0  ||  obj.order_num.indexOf('O') > 0  ||  obj.order_num.indexOf('R') > 0 ) ) {
			$("#p-install_date").prop('readonly', false);
			console.log('true');
		} else {
			$("#p-install_date").prop('readonly', 'readonly');
			console.log('false');
		}
	}
	$('#p-po_cost').val('$ ' + obj.po_cost);
	$('#p-po_num').val(obj.po_num);
	$('#p-builder').val(obj.builder);
	$('#p-address_1').val(obj.address1);
	$('#p-address_2').val(obj.address2);
	$('#p-city').val(obj.city);
	$('#p-state').val(obj.state);
	$('#p-zip').val(obj.zip);
	$('#p-contact_name').val(obj.contact_name);
	$('#p-contact_number').val(obj.contact_number);
	$('#p-contact_email').val(obj.contact_email);
	$('#p-alternate_name').val(obj.alternate_name);
	$('#p-alternate_number').val(obj.alternate_number);
	$('#p-alternate_email').val(obj.alternate_email);
	$('#p-job_notes').val(obj.job_notes);
	$('#p-job_status').val(obj.job_status);
	$('#p-geo_lat').val(obj.job_lat);
	$('#p-geo_long').val(obj.job_long);
	$('#p-job_sqft').val(obj.job_sqft);
	//$('#p-isActive').val(obj.isActive);
	if (obj.isActive == 1) {
		$('#p-isActive').prop("checked", true);
	} else {
		$('#p-isActive').prop("checked", false);
	}
	if (obj.urgent == 1) {
		$('#p-urgent').prop("checked", true);
	} else {
		$('#p-urgent').prop("checked", false);
	}
	if (obj.tax_free == 1) {
		$('#p-tax_free').prop("checked", true);
	} else {
		$('#p-tax_free').prop("checked", false);
	}
	if (obj.am == 1) {
		$('#p-am').prop("checked", true);
	} else {
		$('#p-am').prop("checked", false);
	}
	if (obj.first_stop == 1) {
		$('#p-first_stop').prop("checked", true);
	} else {
		$('#p-first_stop').prop("checked", false);
	}
	if (obj.pm == 1) {
		$('#p-pm').prop("checked", true);
	} else {
		$('#p-pm').prop("checked", false);
	}
	if (obj.temp_am == 1) {
		$('#p-temp_am').prop("checked", true);
	} else {
		$('#p-temp_am').prop("checked", false);
	}
	if (obj.temp_first_stop == 1) {
		$('#p-temp_first_stop').prop("checked", true);
	} else {
		$('#p-temp_first_stop').prop("checked", false);
	}
	if (obj.temp_pm == 1) {
		$('#p-temp_pm').prop("checked", true);
	} else {
		$('#p-temp_pm').prop("checked", false);
	}
	$('.mdb-select').material_select();
	//	setTimeout(function(){ setAcctRep(obj.acct_rep); }, 500);
}

function setAcctRep(repID) {
	$('#p-acct_rep').val(repID);
}

function pullEditPjt(pjtToEdit) {
	$('#editPjt').modal('show');
	var datastring = 'action=get_pjt_for_update&id=' + pjtToEdit;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			compilePjtEdit(data);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}

//Upload the multi file
function upload_multi(){
	var fileSelect_temp = $('#multi_upload_input_temp')[0];
	var fileSelect_fab = $('#multi_upload_input_fab')[0];
	var files_temp = fileSelect_temp.files;
	var files_fab = fileSelect_fab.files;
	var myFormData = new FormData();

	for (var i = 0;i < files_temp.length; i++){
		var file = files_temp[i];
		myFormData.append('multiFile_temp[]', file, file.name);  
	}
	for (var i = 0;i < files_fab.length; i++){
		var file = files_fab[i];
		myFormData.append('multiFile_fab[]', file, file.name);  
	}
	myFormData.append('uid', $uid);
	myFormData.append('id', $pid);
	console.log(myFormData);

	$.ajax({
		url: 'ajax.php',
		type: 'POST',
		processData: false, // important
		contentType: false, // important
		dataType : 'json',
		data: myFormData,
		success: function() {
			viewThisProject($pid,$uid);
		},
		complete: function() {
			Command: toastr["success"]("Files successfully uploaded.", "Projects")
			toastr.options = {
			  "closeButton": true,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": 300,
			  "hideDuration": 1000,
			  "timeOut": 5000,
			  "extendedTimeOut": 1000,
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}

		}
	});
}

function updateInstall() {
	if ($('#i-SqFt').val() == "") {
		$('#i-SqFt').val(0)
	}
	if ($('#i-slabs').val() == "") {
		$('#i-slabs').val(0)
	}
	if ($('#i-cpSqFt_override').val() == "") {
		$('#i-cpSqFt_override').val(0)
	}
	if ($('#i-price_extra').val() == "") {
		$('#i-price_extra').val(0)
	}

	$('#i-instUID').val($uid);
	var form = $("form#updateInstall");
	var formdata = false;

	if (window.FormData) {
		formdata = new FormData(form[0]);
	}
	var datastring = formdata ? formdata : form.serialize();
	var formAction = form.attr('action');
	$.ajax({
		url: 'ajax.php',
		data: datastring,
		cache: false,
		contentType: false,
		processData: false,
		type: 'POST',
		success: function(data) {
			if (isNaN(data)) {
				alert(data);
			} else {
				$('#editInstall').modal('hide');
				Command: toastr["success"]("Install data saved!", "Projects")
				toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": false,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": 300,
				  "hideDuration": 1000,
				  "timeOut": 5000,
				  "extendedTimeOut": 1000,
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}
			}
			return false;
		},
		complete: function() {
			recalculateInstall(iid);
			viewThisProject($pid,$uid);
			viewThisInstall($iid, $pid, $uid);
			$addChange = 0;
			$('.addFA').addClass('hidden');
			$('.addLU').addClass('hidden');
			$('.addVF').removeClass('hidden');
		}
	});
}

function approveLoss(mngr_approved,mngr_approved_price,mngr_approved_id) {
	var approval_name = '';
	var cmt_user = mngr_approved_id;

	var datastring = 'action=loss_approval&id=' + $pid + '&mngr_approved=' + mngr_approved + '&mngr_approved_price=' + mngr_approved_price + '&mngr_approved_id=' + mngr_approved_id;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log($pid);
			viewThisProject($pid,$uid);
		},
		error: function(data) {
			console.log(data);
		}
	});

	var cmt_comment = '$' + mngr_approved_price + ' approved.'
	var datastring = 'action=submit_comment&cmt_ref_id=' + $pid + '&cmt_comment=' + cmt_comment + '&cmt_user=' + cmt_user + '&cmt_type=pjt&cmt_priority=log';
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
		},
		error: function(data) {
			console.log(data);
		}
	});

}



$(document).ready(function() {

// Load links from External Source
	var pLocation = document.location.search.split('&');
	if (pLocation[1] > '') {
		if (pLocation[1].split('=')[0] = 'uid') {
			$uid = pLocation[1].split('=')[1];
			$uName = pLocation[2].split('=')[1].replace(/%20/g, " ");
			$("#user_info").val($uName);
			$("input[name=uid]").val($uid);
			$("#co_display_name").val($uName);
		}
		if (pLocation[1].split('=')[0] = 'pid') {
			$pid = pLocation[1].split('=')[1];
			$uid = pLocation[2].split('=')[1];
			viewThisProject($pid,$uid);
		}
	};

////////// Project Add / Edit

// Removes tax if Tax-Free selected or Unchecks Tax-Free if tax amount entered. 
	$('#p-tax_free').change(function() {
		if ($('#p-tax_free').prop('checked') == true) {
			$('#p-job_tax').val(0)
		}
	})
	$('#p-job_tax').on('input',function() {
		if (this.value > 0) {
			$('#p-tax_free').prop('checked', false);
		}
	})
	$('#tax_free').change(function() {
		if ($('#tax_free').prop('checked') == true) {
			$('#job_tax').val(0)
		}
	})
	$('#job_tax').on('input',function() {
		if (this.value > 0) {
			$('#tax_free').prop('checked', false);
		}
	})



////////// Install Add / Edit

// Removes tax if Tax-Free selected or Unchecks Tax-Free if tax amount entered. 
	$("#instUpdate").click(function(e) {
		var $form = "#updateInstall";
		var $material = $('#i-material').val();
		var $matName = $('#i-color-box').val();
		var $slabs = $('#i-slabs').val();
		var $SqFt = $('#i-SqFt').val();
		var $matString = "#updateInstall .titleMat:contains('" +  $matName + "')";
		var $price = $($matString).parent().parent().attr('price');
		var $cost = $($matString).parent().parent().attr('cost');
		matObj = [];
		$("datalist#i-color option").each(function() {
			matObj.push({
				id: $(this).attr("material"),
				cost: $(this).attr("cost"),
				price: $(this).attr("price"),
				matName: $(this).val()
			});
		});
		var $price = findPrice($matName);
		var $cost = findCost($matName);
		$curPrice = $price;
		$curCost = $cost;
		console.log('2: ' + $price + ' ' + $cost + ' ' + $curCost + ' ' + $curPrice);

		if (typeof $price == 'undefined'){
			$price = 0;
		}
		if (typeof $cost == 'undefined'){
			$cost = 0;
		}

//LEEEEEE
//		if (!(Math.floor($price) == $price && $.isNumeric($price)))  {
//			alert("You have entered a color that is not in the database. If it is a Remnant, you must enter the proper name for a marble or granite. If it is quartz, you will have to have the remnant added to the quartz database by Corry, Kate, Lee, Omar, Kayleigh, Anna or Zack.");
//			return;
//		}

		if (!(Math.floor($price) == $price && $.isNumeric($price)))  {
			if (window.confirm("You have entered a color that is not in the database. You will have to manually enter the price in 'Extra Costs' field. Are you sure you want to do this?")) {
				$price = 0;
			} else {
				return;
			}
		}
		if ($material == 'marbgran') {
			marbcalc($matName, $price);
			var costing = parseFloat($SqFt) * parseFloat($cost);
			$($form).find('input[name=materials_cost]').val(costing);
			console.log('Costing: ' + costing);
		} else if ($material == 'quartz') {
			quartzcalc($matName, $cost);
			console.log('3: ' + $slabs + ' ' + $price + ' ' + $cost + ' ' + $curCost + ' ' + $curPrice);
			var costing = parseFloat($slabs) * parseFloat($cost);
			$($form).find('input[name=materials_cost]').val(costing);
			console.log('Costing: ' + costing);
		} else {
			alert('You must specifiy Marble/Granite or Quartz');
			return;
		}
	    if ($("#updateInstall input[name=selected]").length > 0) {
	        if ($("#updateInstall input[id='i-selectedb']:checked").length > 0) {
	            updateInstall();
	        } else {
	            if ($('#i-lot').val() != '') {
	                updateInstall()
	            } else {
	                alert("If Customer Selected you must enter a lot.");
	            }
	        }
	    } else {
	        alert("You must state if the material is customer selected.");
	    }
	    $("body").scrollTop(0, 0);
	});


	$( "select[name=material]" ).change(function() {
		pullMaterials(this.value);
	});

	$("select[id=shape]").change(function() {
		if ($("#shape").val() == 1) {
			if ($('.rect_shape').hasClass('d-none') == true) {
				$('.rect_shape').removeClass('d-none');
				$('.rect_shape').addClass('d-inline-block');
				$('.l_shape').removeClass('d-inline-block');
				$('.l_shape').addClass('d-none');
				$('.bevel_shape').removeClass('d-inline-block');
				$('.bevel_shape').addClass('d-none');
				$('.sqft_shape').removeClass('d-inline-block');
				$('.sqft_shape').addClass('d-none');
			}
		} else if ($("#shape").val() == 2) {
			if ($('.l_shape').hasClass('d-none') == true) {
				$('.l_shape').removeClass('d-none');
				$('.l_shape').addClass('d-inline-block');
				$('.rect_shape').removeClass('d-inline-block');
				$('.rect_shape').addClass('d-none');
				$('.bevel_shape').removeClass('d-inline-block');
				$('.bevel_shape').addClass('d-none');
				$('.sqft_shape').removeClass('d-inline-block');
				$('.sqft_shape').addClass('d-none');
			}
		} else if ($("#shape").val() == 3) {
			if ($('.bevel_shape').hasClass('d-none') == true) {
				$('.bevel_shape').addClass('d-inline-block');
				$('.bevel_shape').removeClass('d-none');
				$('.rect_shape').removeClass('d-inline-block');
				$('.rect_shape').addClass('d-none');
				$('.l_shape').removeClass('d-inline-block');
				$('.l_shape').addClass('d-none');
				$('.sqft_shape').removeClass('d-inline-block');
				$('.sqft_shape').addClass('d-none');
			}
		} else if ($("#shape").val() == 4) {
			if ($('.sqft_shape').hasClass('d-none') == true) {
				$('.sqft_shape').addClass('d-inline-block');
				$('.sqft_shape').removeClass('d-none');
				$('.bevel_shape').removeClass('d-inline-block');
				$('.bevel_shape').addClass('d-none');
				$('.rect_shape').removeClass('d-inline-block');
				$('.rect_shape').addClass('d-none');
				$('.l_shape').removeClass('d-inline-block');
				$('.l_shape').addClass('d-none');
			}
		}
	});

	function findPrice($mColor) {
		for (var i = 0, len = matObj.length; i < len; i++) {
			if ($.trim(matObj[i].matName) === $.trim($mColor)) return matObj[i].price; // Return as soon as the object is found
		}
		return null; // The object was not found
	}
	function findCost($mColor) {
		for (var i = 0, len = matObj.length; i < len; i++) {
			if ($.trim(matObj[i].matName) === $.trim($mColor)) return matObj[i].cost; // Return as soon as the object is found
		}
		return null; // The object was not found
	}
	$("input[name=color]").on('input', function() {
		$curPrice = 0;
		$curCost = 0;
		var $form = $(this).closest('form');
		var $material = $($form).find('input[name=material]').val();
		var $SqFt = parseFloat($($form).find('input[name="SqFt"]').val());
		var $slabs = parseFloat($($form).find('input[name="slabs"]').val());
		var $mColor = this.value;
		matObj = [];
		$("datalist#i-color option").each(function() {
			matObj.push({
				id: $(this).attr("material"),
				cost: $(this).attr("cost"),
				price: $(this).attr("price"),
				matName: $(this).val()
			});
		});
		var $tPrice = findPrice($mColor);
		var $cost = findCost($mColor);
		$curPrice = $tPrice;
		$curCost = $cost;
		
		if ($cost < 1) {
			$cost = 0;
		}
		var cpSqFt = 0;
		var priceTotal = 0;
		if ($material == 'marbgran') {
			marbcalc($mat, $tPrice);
			var costing = parseFloat($SqFt) * parseFloat($cost);
			$($instForm).find('input[name=materials_cost]').val(costing);
		} else if ($material == 'quartz') {
			quartzcalc($mat, $tPrice);
			var costing = parseFloat($slabs) * parseFloat($cost);
			$($instForm).find('input[name=materials_cost]').val(costing);
		}
	});


///////// Piece Add / Edit

// Calculate Outside or Inside Edged of Add Piece
	$('.calcOutside').hover(function() {
		$('.cOutside').addClass("is-invalid");
		$('.cVariable').css("background-color",'#CCC');
	}, function(){
		$('.cOutside').removeClass("is-invalid");
		$('.cVariable').css("background-color",'#FFF');
	})
	$('.calcInside').hover(function() {
		$('.cInside').addClass("is-invalid");
		$('.cVariable').css("background-color",'#CCC');
	}, function(){
		$('.cInside').removeClass("is-invalid");
		$('.cVariable').css("background-color",'#FFF');
	})
	$('.addChg').change( function() {
		$('.addVF').addClass('hidden');
		$('.addFA').addClass('hidden');
		$('.addLU').removeClass('hidden');
		$addChange = 1;
	})



///////// Sink Add / Edit

// Gets Sink Details for selected sink
	$('#sink_model').on('input', function() {
		var $sModel = $('#sink_model').val();
		var $sSelected = 'option:contains(' + $sModel + ')';
		var $sWidth = $($sSelected).attr('width');
		var $sDepth = $($sSelected).attr('depth');
		console.log($sDepth);
		if ( $sWidth > 1 ) {
			$('#cutout_width').val($sWidth);
			$('#cutout_depth').val($sDepth);
		} else {
			$('#cutout_width').val(0);
			$('#cutout_depth').val(0);
		}

	})


////////// Comments

// Add comments
	$("#submitComments").click(function(e) {

		var form = $("form#commentForm");
    	var formdata = false;
    	if (window.FormData){
   			formdata = new FormData(form[0]);
    	}
		var datastring = formdata ? formdata : form.serialize();

   		$.ajax({
        	url         : 'ajax.php',
        	data        : datastring,
        	cache       : false,
       	 	contentType : false,
        	processData : false,
        	type        : 'POST',
        	success     : function(data){
				if (isNaN(data)) {
					alert(data);
				} else {
					$('#addComment').modal('hide');
					$('#commentForm')[0].reset();
					getComments('pjt');
					//alert(form.serialize() + " ----- Project ID -----> " + data);
					Command: toastr["success"]("Comment made!", "Projects")
					toastr.options = {
						"closeButton": true,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 5000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
				}

				return false;
        	}
    	});
	});
	getLocation();

	$('#p-install_date').focus(function(e){
		e.preventDefault();
		e.stopPropagation();
		if( $al > 1 ){
			if ($('#p-install_date').prop('readonly') == true) {
				$('#p-contact_name').focus();
				alert("You can not yet enter an install date. Project must be templated and have SqFt calculated.");
			}
		}
	});
	$('#install_date').focus(function(e){
		e.preventDefault();
		e.stopPropagation();
		if( $al > 1 ){
			if ($('#install_date').prop('readonly') == true) {
				$('#contact_name').focus();
				alert("You can not yet enter an install date. Project must be templated and have SqFt calculated.");
			}
		}
	});
	$('input[name=temp_am]').change(function(){
		if( $('input[name=temp_am]').is(':checked')) {
			$('input[name=temp_pm]').prop('checked',false);
		}
	})
	$('input[name=temp_pm]').change(function(){
		if( $('input[name=temp_pm]').is(':checked')) {
			$('input[name=temp_am]').prop('checked',false);
		}
	})
	$('input[name=am]').change(function(){
		if( $('input[name=am]').is(':checked')) {
			$('input[name=pm]').prop('checked',false);
		}
	})
	$('input[name=pm]').change(function(){
		if( $('input[name=pm]').is(':checked')) {
			$('input[name=am]').prop('checked',false);
		}
	})
  
  
});