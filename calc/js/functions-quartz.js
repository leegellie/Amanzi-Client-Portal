
indMult = 4;
compPct = 1.2;
mPrice = 0;
pType = 'retail';
sqFt = 0;
units = 0;
cm1 = '';
cm2 = '';
cm3 = '';
d1 = '';
d2 = '';
d3 = '';




jQuery(document).ready(function($){

	$('#brandSelector').change(function(){
		var brandToGet = $("#brandSelector option:selected").val();
		if (brandToGet != '') {
			$.post('php/brand.php', {name: brandToGet}, function(data) {
				$('#results').html(data);
			});
		};
	});

	$('.industry').click(function() {
		var $this = $(this);
		pType = this.id;
		indMult = $(this).attr('mat-val');
		$('.industry').removeClass('active');
		$this.addClass('active');
		if (pType == 'commercial') {
			$('#unitCount').show();
			unitsCalc()
		} else {
			$('#unitCount').hide();
			if (pType == 'retail') {
				indMult = 4;
				compPct = 1.2;
			} else if (pType == 'builder') {
				indMult = 3;
				compPct = 1.2;
			} else {
				indMult = 3;
				compPct = 1;
			}
		}
		calcTotal();
	});
	$('#indSelect').change(function(){
		var optName = '#' + $(this).find('option:selected').attr("name");
		$(optName).click();		
	});
	$('#sqFt').bind("keyup change", function(e) {
		sqFt = $('#sqFt').val();
		calcTotal();
	});
	$('#matPrice').bind("keyup change", function(e) {
		mPrice = $('#matPrice').val();
		calcTotal();
	});
	$('#units').bind("keyup change", function(e) {
		unitsCalc();
		calcTotal();
	});
	$('#clearAll').click(function(){
		indMult = 4;
		compPct = 1.2;
		mPrice = 0;
		pType = 'retail';
		sqFt = '0';
		location.reload();
//		$('.industry').removeClass('active');
//		$('#retail').addClass('active');
//		$('input').val('');		
//		$('#sqFtPrice').text('0');		
//		$('#finalPrice').text('0');
//		$('#totPrice').hide();
//		$('#indSelect').val('4');
//		$('#unitCount').hide();
	})
	$('#backBut').click(function(){
		window.location.href='/';
	});

});

function compileType($v){
	event.preventDefault();
	$('.cmO').show();
	var mName = $($v).attr('mName');
	var mp1 = $($v).attr('mat1');
	var mp2 = $($v).attr('mat2');
	var mp3 = $($v).attr('mat3');
	var md1 = $($v).attr('dis1');
	var md2 = $($v).attr('dis2');
	var md3 = $($v).attr('dis3');
	var mda = $($v).attr('disa');
	var gp1 = $($v).attr('gp1');
	var gp2 = $($v).attr('gp2');
	var gp3 = $($v).attr('gp3');
	var gd1 = $($v).attr('gd1');
	var gd2 = $($v).attr('gd2');
	var gd3 = $($v).attr('gd3');
	var gda = $($v).attr('gda');
	$('.label').text(mName);
	if (mp1 == 'NA' || gp1 == 'NA') {
		$('.cm1').hide();
	} else {
		if (mp1 > 0) {
			cm1 = mp1;
		} else {
			cm1 = gp1;
		}
		$('.cm1').val(cm1);
	}
	if (mp2 == 'NA' || gp2 == 'NA') {
		$('.cm2').hide();
	} else {
		if (mp2 > 0) {
			cm2 = mp2;
		} else {
			cm2 = gp2;
		}
		$('.cm2').val(cm2);
	}
	if (mp3 == 'NA' || gp3 == 'NA') {
		$('.cm3').hide();
	} else {
		if (mp3 > 0) {
			cm3 = mp3;
		} else {
			cm3 = gp3;
		}
		$('.cm3').val(cm3);
	}
	if (md1 > 0) {
		d1 = md1;
	} else if (mda > 0) {
		d1 = mda;
	} else if (gd1 > 0) {
		d1 = gd1;
	} else {
		d1 = gda;
	}
	if (md2 > 0) {
		d2 = md2;
	} else if (mda > 0) {
		d2 = mda;
	} else if (gd2 > 0) {
		d2 = gd2;
	} else {
		d2 = gda;
	}
	if (md3 > 0) {
		d3 = md3;
	} else if (mda > 0) {
		d3 = mda;
	} else if (gd3 > 0) {
		d3 = gd3;
	} else {
		d3 = gda;
	}
	$('.calculator').show();
	$('.stageOne').hide();
	calcTotal();
};

function unitsCalc() {
	var numUnits = $('#units').val();
	units = numUnits;
	if (numUnits > 100) {
		compPct = 1;
		indMult = 3;
	} else if (numUnits < 51) {
		compPct = 1.5;
		indMult = 4;
	} else {
		compPct = 1;
		indMult = 4;
	}
}

function calcTotal() {
	var totInt;
	mPrice = $('#matCode option:selected').val();
	var step1 = mPrice * indMult;
	var activeDiv = $('.active').attr('id');
	if  (pType != 'commercial') {
		units = 0;
		totInt = step1 * compPct;
	} else {
		var toPct = step1 * compPct;
		unitsCalc();
		totInt = step1 * compPct;
	}
	sqFt = $('#sqFt').val();
	if (sqFt < 30) {
		totValue = Math.ceil(totInt*1.3);
		$('#sqFtWarning').show();
	} else {
		totValue = Math.ceil(totInt);
		$('#sqFtWarning').hide();
	}
	console.log(totValue);
	$('#sqFtPrice').text(totValue);
	var totPrice = totValue * sqFt;
	if (sqFt > 0) {
		$('#totPrice').show();
		$('#finalPrice').text(totPrice);
	} else {
		$('#totPrice').hide();
		$('#finalPrice').text(totPrice);
	}
};
