// For both User Add and User Edit Pages
$pid = '';
$uName = '';
var successNote;

var succesStarter = '<div class="metro window-overlay"><div class="window shadow" style="min-width:200px; max-width:450px; top:200px; left:50%; margin-left:-225px;" ><div class="caption"><span class="icon icon-user-3"></span><div class="title">User Save Data</div><button class="btn-close" onClick="closeSuccess()"></button></div><div class="content">';

var successEnder = '</div><div id="closeFocus" class="button bg-yellow fg-white bd-red" style="width:75px; bottom:5px; margin-left:345px; margin-bottom:10px" tabindex="0" onclick="closeSuccess()">Close &#10008;</div></div>';

function add_marble(e) {
	$('.btn').hide();
	var form = $('form#add_marble');
	var fName = form.find('input[name=name]').val();
	if (fName == '') {
		alert('You must enter a name for the Marble or Granite.');
		$('.btn').show();
		return;
	}
	var price_1 = form.find('input[name=price_1]').val();
	var price_2 = form.find('input[name=price_2]').val();
	var price_3 = form.find('input[name=price_3]').val();
	var price_4 = form.find('input[name=price_4]').val();
	var price_5 = form.find('input[name=price_5]').val();
	var price_6 = form.find('input[name=price_6]').val();
	var price_7 = form.find('input[name=price_7]').val();
	var fNotes = form.find('input[name=notes]').val();
	if (price_1 < 1) {
		price_1=0;
	}
	if (price_2 < 1) {
		price_2=0;
	}
	if (price_3 < 1) {
		price_3=0;
	}
	if (price_4 < 1) {
		price_4=0;
	}
	if (price_5 < 1) {
		price_5=0;
	}
	if (price_6 < 1) {
		price_6=0;
	}
	if (price_7 < 1) {
		price_7=0;
	}

	var datastring = "action=add_marble&name=" + fName + "&price_1=" + price_1 + "&price_2=" + price_2 + "&price_3=" + price_3 + "&price_4=" + price_4 + "&price_5=" + price_5 + "&price_6=" + price_6 + "&price_7=" + price_7 + "&notes=" + fNotes;
	
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#materialAddMarble').modal('hide');
			alert('Material added to database.');
			location.reload(true);
		},
		error: function(data) {
			console.log('add_marble: ' + data);
		},
		complete: function() {
			$('.btn').show();
		}
	});
}

function delete_marble(marbId) {
	if (confirm('Are you sure you want to delete this from the database?')) {
		var datastring = "action=delete_marble&id=" + marbId;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				location.reload(true);
				alert('Material deleted.');
			},
			error: function(data) {
				console.log('delete_marble: ' + data);
			},
			complete: function() {
			}
		});
	} else {
    	return;
	}
}

function update_marble(e) {
	$('.btn').hide();
	var form = $('form#edit_marble');
	var mName = form.find('input[name=name]').val();
	if (mName == '') {
		alert('You must enter a name for the Marble or Granite.');
		$('.btn').show();
		return;
	}
	var marbleid = form.find('input[name=id]').val();
	var price_0 = form.find('input[name=price_0]').val();
	var price_1 = form.find('input[name=price_1]').val();
	var price_2 = form.find('input[name=price_2]').val();
	var price_3 = form.find('input[name=price_3]').val();
	var price_4 = form.find('input[name=price_4]').val();
	var price_5 = form.find('input[name=price_5]').val();
	var price_6 = form.find('input[name=price_6]').val();
	var price_7 = form.find('input[name=price_7]').val();
	var fNotes = form.find('input[name=notes]').val();
	if (!$("form#edit_marble").find('input[name=notes]').val()) {
		fNotes = '';
	} 
	if (price_0 < 1) {price_0=0;}
	if (price_1 < 1) {price_1=0;}
	if (price_2 < 1) {price_2=0;}
	if (price_3 < 1) {price_3=0;}
	if (price_4 < 1) {price_4=0;}
	if (price_5 < 1) {price_5=0;}
	if (price_6 < 1) {price_6=0;}
	if (price_7 < 1) {price_7=0;}
	var datastring = "action=update_marble&mid="+ marbleid +"&mname=" + mName + "&price_0=" + price_0 + "&price_1=" + price_1 + "&price_2=" + price_2 + "&price_3=" + price_3 + "&price_4=" + price_4 + "&price_5=" + price_5 + "&price_6=" + price_6 + "&price_7=" + price_7 + "&notes=" + fNotes;
	console.log(datastring);
	
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('#editMarble').modal('hide');
			location.reload(true);
		},
		error: function(data) {
			console.log('update_marble: ' + data);
		},
		complete: function() {
			$('.btn').show();
		}
	});
}

function add_quartz(e) {
	$('input').removeClass('is-invalid');
	$('.btn').hide();
	var form = $('form#add_quartz');
	var qName = form.find('input[name=name]').val();
	if (qName == '') {
		alert('You must enter a name for the Quartz.');
		form.find('input[name=name]').addClass('is-invalid');
		form.find('input[name=name]').focus();
		$('.btn').show();
		return;
	}
	var slab_cost = form.find('input[name=slab_cost]').val();
	if (slab_cost < 2) {
		alert('You must enter a slab price for the Quartz.');
		form.find('input[name=slab_cost]').addClass('is-invalid');
		form.find('input[name=slab_cost]').focus();
		$('.btn').show();
		return;
	}
	var slab_sqft = form.find('input[name=slab_sqft]').val();
	var price_3 = form.find('input[name=price_3]').val();
	var quartz_height = form.find('input[name=quartz_height]').val();
	var quartz_width = form.find('input[name=quartz_width]').val();
	var qNotes = $('#notes').val();
	var cat_id = $('#cat_id').val();
	if (qNotes < 1) {qNotes='';}
	if (cat_id < 1) {cat_id=0;}
	if (slab_cost < 1) {slab_cost=0;}
	if (slab_sqft < 1) {slab_sqft=0;}
	if (price_3 < 1) {price_3=0;}
	if (quartz_height < 1) {quartz_height=0;}
	if (quartz_width < 1) {quartz_width=0;}
	var datastring = "action=add_quartz&name=" + qName + "&slab_cost=" + slab_cost + "&slab_sqft=" + slab_sqft + "&price_3=" + price_3 + "&quartz_height=" + quartz_height + "&quartz_width=" + quartz_width + "&notes=" + qNotes + "&cat_id=" + cat_id;
	console.log(datastring);
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			$('#materialAddQuartz').modal('hide');
			alert('Material added to database.');
			location.reload(true);
		},
		error: function(data) {
			console.log('add_quartz: ' + data);
		},
		complete: function() {
			$('.btn').show();
		}

	});
}
function delete_quartz(marbId) {
	if (confirm('Are you sure you want to delete this from the database?')) {
		var datastring = "action=delete_quartz&id=" + marbId;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				alert('Material deleted.');
				location.reload(true);
			},
			error: function(data) {
				console.log('delete_quartz: ' + data);
			},
			complete: function() {
			}
		});
	} else {
    	return;
	}
}
function update_quartz(e) {
	$('.btn').hide();
	var form = $('form#edit_quartz');
	var qName = form.find('input[name=name]').val();
	if (qName == '') {
		alert('You must enter a name for the Quartz.');
		$('.btn').show();
		return;
	}
	var quartzId = form.find('input[name=id]').val();
	var slab_cost = form.find('input[name=slab_cost]').val();
	var slab_sqft = form.find('input[name=slab_sqft]').val();
	var price_3 = form.find('input[name=price_3]').val();
	var quartz_height = form.find('input[name=quartz_height]').val();
	var quartz_width = form.find('input[name=quartz_width]').val();
	var fNotes = form.find('input[name=notes]').val();
	var cat_id = form.find('select[name=cat_id]').val();
	if (!$("form#edit_quartz").find('input[name=notes]').val()) {
		fNotes = '';
	} 
	if (slab_cost < 1) {slab_cost=0;}
	if (slab_sqft < 1) {slab_sqft=0;}
	if (price_3 < 1) {price_3=0;}
	if (quartz_height < 1) {quartz_height=0;}
	if (quartz_width < 1) {quartz_width=0;}
	if (cat_id < 1) {cat_id=0;}
	var datastring = "action=update_quartz&mid="+ quartzId +"&mname=" + qName + "&slab_cost=" + slab_cost + "&slab_sqft=" + slab_sqft + "&price_3=" + price_3 + "&quartz_height=" + quartz_height + "&quartz_width=" + quartz_width + "&cat_id=" + cat_id + "&notes=" + fNotes;
	console.log(datastring);
	
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('#editMarble').modal('hide');
			//location.reload(true);
		},
		error: function(data) {
			console.log('update_quartz: ' + data);
		},
		complete: function() {
			$('.btn').show();
		}
	});
}

function matOrdered(iid,iName) {
	$('.mAssign').text(iName);
	$('input[name=iid]').val(iid);
	$('#materialOrder').modal('show');
}

function matOnHand(iid,iName) {
	$('.mAssign').text(iName);
	$('input[name=iid]').val(iid);
	$('#materialAssign').modal('show');
}

function noMaterial(iid) {
	if (confirm("Are you sure this install requires no material?")) {
		var form = 'action=no_material&material_status=4&iid=' + iid;
		assignMat(form);
	} else {
    	return;
	}
}

function material_delivered(pid) {
	if (confirm('Mark full project as deliverd to fabrication?')) {
		var datastring = 'action=material_delivered&pid=' + pid;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				mat_list_pull();
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
}

function material_delivered_prog(pid) {
	if (confirm('Mark full project as deliverd to fabrication?')) {
		var datastring = 'action=material_delivered_prog&pid=' + pid;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				console.log(data);
				mat_list_pull();
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
}

function material_selected(pid) {
	var datastring = 'action=material_selected&pid=' + pid;
	console.log(datastring);
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			mat_list_pull();
		},
		error: function(data) {
			console.log(data);
		}
	});
}

function assignMat(thisForm) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: thisForm,
        success: function(data) {
            $('div').modal('hide');
            $("#materialBtn").click();
        },
        error: function(data) {
			console.log('assignMat: ' + data);
        }
    });
}

function matReset(iid, pid, iname) {
	if (confirm("Are you sure you want to reset the status of this material?")) {
		var datastring = 'action=material_reset&iid=' + iid + '&pid=' + pid + '$iname=' + iname;
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
	} else {
		return;
	}
}

function mat_list_pull() {
	var datastring = "action=get_materials_needed";
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			var res = data.split(":::");
			$('#toOrder').html(res[0]);
			$('#mOrdered').html(res[1]);
			$('#mOnHand').html(res[2]);
			$('#toDeliver').html(res[3]);
			$('#sAccsMat').html(res[4]);
			$('#sAccsJob').html(res[5]);
		},
		error: function(data) {
			console.log(data);
		}
	});
	setTimeout(mat_list_pull, 5000);
}

function set_pullstatus($a, $b) {
  if (confirm("Are you sure you want to set the status of this material?")) {
    var datastring = 'action=update_pullstatus&date=' + $a + '&ids=' + $b;
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
  } else {
		return;
	}
}


$(document).ready(function() {

    $("form").on("submit", function(event) {
        event.preventDefault();
        var matAss = $(this).serialize();
        assignMat(matAss);
    });

    $("#materialBtn").click(function() {
		console.log("start");
        var datastring = "action=get_materials_needed";
		console.log("datastring: " + datastring);
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: datastring,
            success: function(data) {
                $('#matResults').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
})