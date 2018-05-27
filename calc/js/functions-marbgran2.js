
indMult = 4;
compPct = 1.2;
mPrice = 0;
cPrice = 0;
pType = 'retail';
sqFt = 0;
units = 0;
mName = '';
mp1 = 0;
mp2 = 0;
mp3 = 0;
mp4 = 0;
mp5 = 0;
mp6 = 0;
mp7 = 0;
cp1 = 0;
cp2 = 0;
cp3 = 0;
cp4 = 0;
cp5 = 0;
cp6 = 0;
cp7 = 0;
notes = '';




jQuery(document).ready(function($){

	$.post('php/marbselect.php', {name: 'brandToGet'}, function(data) {
		$('#results').html(data);
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

function compileName($v){
	event.preventDefault();
	$('.compO').addClass('hidden');
	mName = $($v).attr('mName');
	mp1 = $($v).attr('mat1');
	mp2 = $($v).attr('mat2');
	mp3 = $($v).attr('mat3');
	mp4 = $($v).attr('mat4');
	mp5 = $($v).attr('mat5');
	mp6 = $($v).attr('mat6');
	mp7 = $($v).attr('mat7');
	cp1 = $($v).attr('comm1');
	cp2 = $($v).attr('comm2');
	cp3 = $($v).attr('comm3');
	cp4 = $($v).attr('comm4');
	cp5 = $($v).attr('comm5');
	cp6 = $($v).attr('comm6');
	cp7 = $($v).attr('comm7');
	notes = $($v).attr('notes');
	$('.label').text(mName);


	var compiled = '';

	if (mp7 > 0 || cp7 > 0) {
		mPrice = mp7;
		cPrice = cp7;
		compiled = '<option class="compO comp7" value="' + mp7 + '" cValue="' + cp7 + '">Stone Basyx</option>' + compiled;
	}
	if (mp6 > 0 || cp6 > 0) {
		mPrice = mp6;
		cPrice = cp6;
		compiled = '<option class="compO comp6" value="' + mp6 + '" cValue="' + cp6 + '">OHM</option>' + compiled;
	}
	if (mp5 > 0 || cp5 > 0) {
		mPrice = mp5;
		cPrice = cp5;
		compiled = '<option class="compO comp5" value="' + mp5 + '" cValue="' + cp5 + '">MSI</option>' + compiled;
	}
	if (mp4 > 0 || cp4 > 0) {
		mPrice = mp4;
		cPrice = cp4;
		compiled = '<option class="compO comp4" value="' + mp4 + '" cValue="' + cp4 + '">Marva</option>' + compiled;
	}
	if (mp3 > 0 || cp3 > 0) {
		mPrice = mp3;
		cPrice = cp3;
		compiled = '<option class="compO comp3" value="' + mp3 + '" cValue="' + cp3 + '">Cosmos</option>' + compiled;
	}
	if (mp2 > 0 || cp2 > 0) {
		mPrice = mp2;
		cPrice = cp2;
		compiled = '<option class="compO comp2" value="' + mp2 + '" cValue="' + cp2 + '">Bramati</option>' + compiled;
	}
	if (mp1 > 0 || cp1 > 0) {
		mPrice = mp1;
		cPrice = cp1;
		compiled = '<option class="compO comp1" value="' + mp1 + '" cValue="' + cp1 + '">AllStone</option>' + compiled;
	}


	//compiled = '<select class="inputControl2 form-control form-control-lg" id="matComp">' + compiled;
	//compiled = compiled + '</select>';
	console.log(compiled);
	$('#matComp').append(compiled);

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
$("#matComp").change(function(){
	calcTotal()
});
function calcTotal() {
	var totInt;
	mPrice = $('#matComp option:selected').val();
	cPrice = $('#matComp option:selected').attr('cValue');
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
