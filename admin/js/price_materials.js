	function matModal(mat) {
		materialPrice(mat);
		$('#materialSelect').modal('show');
	}

	function filterMat(e) {
		var regex = new RegExp('\\b\\w*' + e + '\\w*\\b');
		$('.size').hide().filter(function () {
			return regex.test($(this).data('size'))
		}).show();
	}

	function get_price_levels() {
		var datastring = "action=get_price_levels";
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				var $lvls = data.split(':');
				$.each($lvls, function(index) {
					var $matLvl = this.split('|');
					if ($matLvl[0] == 1) {
						$level1 = $matLvl[1];
					}
					if ($matLvl[0] == 2) {
						$level2 = $matLvl[1];
					}
					if ($matLvl[0] == 3) {
						$level3 = $matLvl[1];
					}
					if ($matLvl[0] == 4) {
						$level4 = $matLvl[1];
					}
					if ($matLvl[0] == 5) {
						$level5 = $matLvl[1];
					}
					if ($matLvl[0] == 6) {
						$level6 = $matLvl[1];
					}
					if ($matLvl[0] == 7) {
						$level7 = $matLvl[1];
					}
					if ($matLvl[0] == 8) {
						$level8 = $matLvl[1];
					}
				});
			},
			error: function(data) {
				alert(data);
			}
		});
	}

	function get_price_mult() {
		var datastring = "action=get_price_multiplier&uid=" + $uid;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				$uMultiplier = data;
				$level1c = $level1 * $uMultiplier;
				$level2c = $level2 * $uMultiplier;
				$level3c = $level3 * $uMultiplier;
				$level4c = $level4 * $uMultiplier;
				$level5c = $level5 * $uMultiplier;
				$level6c = $level6 * $uMultiplier;
				$level7c = $level7 * $uMultiplier;
				$level8c = $level8 * $uMultiplier;
				$level9c = $level9 * $uMultiplier;
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: " + xhr.responseText;
				$('#editSuccess').html(succesStarter + successNote + successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	}

	function materialPrice(mat) {
		if (mat) {
		}
		var datastring = "action=get_material&material=" + mat;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				priceOrganizer(data,mat);
			},
			error: function(data) {
				alert(data);
			}
		});
	}


	function pullMaterials(mat) {
		var datastring = "action=get_material&material=" + mat;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				matOrganizer(data,mat);
			},
			error: function(xhr, status, error) {
				// alert("Error submitting form: " + xhr.responseText);
				successNote = "Error submitting form: " + xhr.responseText;
				$('#editSuccess').html(succesStarter + successNote + successEnder);
				document.getElementById('closeFocus').focus();
			}
		});
	}

	function priceOrganizer($mat,dataType) {
		var $materials = $mat.split(':');
		$('#matModalCards').html('');
		$.each($materials, function(index) {
			var $matItem = this.split('|');
			// Make CoboBox List
			var $level = 0;
			var $price = Math.round($matItem[3]);
			var $level = Math.round($matItem[4]);
			var $cost = Math.round($matItem[5]);

			// Make PopUp Cards
			var $matCard = '<div class="matParent col-12 col-md-6 col-lg-4 mb-2" price="' + $price + '" level="' + $level + '" cost="' + $cost + '" id="item-' + $matItem[0] + '"><div class="matItem" style="background-image: url(../price/';
			$matCard += $matItem[2];
			$matCard += '); background-size: cover"><div class="titleMat w-100 text-center">';
			$matCard += $matItem[1] + '<br>From: ' + $price;
			$matCard += '</div></div></div>';

			$('#matModalCards').append($matCard);
	
	
		})
	}


	function matOrganizer($mat,dataType) {
		var $materials = $mat.split(':');
		$('.colorChoose').html('');
		$('.matSelectCards').html('');
		$.each($materials, function(index) {
			var $matItem = this.split('|');
			// Make CoboBox List
			var $level;
			var $price = Math.round($matItem[3]);
			var $level = Math.round($matItem[4]);
			var $cost = Math.round($matItem[5]);

			var $matOption = '<option price="' + $price + '" material="' + $matItem[0] + '" value="' + $matItem[1] + '" cost="' + $cost + '"></option>';
			$('.colorChoose').append($matOption);
			// Make PopUp Cards
	
			var $matCard = '<div class="matParent col-12 col-md-6 col-lg-4 mb-2" data="' + $matItem[2] + '" price="' + $price + '" level="' + $level + '" cost="' + $cost + '" id="item-' + $matItem[0] + '" onClick="matCardSel(';
			$matCard += "'";
			$matCard += $matItem[1];
			$matCard += "',";
			$matCard += $price;
			$matCard += ",";
			$matCard += $cost;
			$matCard += ')"> <div class="matItem" ';
			//if ($matItem[2] > 0) {
				$matCard += 'style="background-image: url(/price/';
				$matCard += $matItem[2];
				$matCard += '); background-size: cover"';
			//}
			$matCard += '><div class="titleMat w-100 text-center">';
			$matCard += $matItem[1];
			$matCard += '</div></div></div>';
	
			$('.matSelectCards').append($matCard);
	
	
		})
	}

	function compileMats() {
		$(".matItem").each(function(){
			var p1 = $(this).attr("p1");
			var p2 = $(this).attr("p2");
			var p3 = $(this).attr("p3");
			var p4 = $(this).attr("p4");
			var p5 = $(this).attr("p5");
			var p6 = $(this).attr("p6");
			var p7 = $(this).attr("p7");
			var c1 = $(this).attr("c1");
			var c2 = $(this).attr("c2");
			var c3 = $(this).attr("c3");
			var c4 = $(this).attr("c4");
			var c5 = $(this).attr("c5");
			var c6 = $(this).attr("c6");
			var c7 = $(this).attr("c7");
			var mArray = [p1,p2,p3,p4,p5,p6,p7];
			mArray = $.grep(mArray, function(value) {
				return value != 0;
			})
			var mVal = Math.min.apply(Math,mArray);
			$(this).find(".mPrice").attr("mCode",mVal)
			if (uType == "retail") {
				mVal = mVal * 1.2 * 4;
			}
			if (uType == "cabinet") {
				mVal = mVal * 3;
			}
			if (uType == "builder") {
				mVal = mVal * 1.2 * 3;
			}
			if (uType == "commercial") {
				mVal = mVal * 1.5 * 4;
			}
			mVal = Math.round(mVal);
			$(this).find(".mPrice").text(mVal);
		});
	}

	function priceIt($price) {
		$(".matItem").each(function(){
			$(this).parent().show();
			var toLimit = +($(this).find(".mPrice").attr("mCode"));
			if ($price == 0) {
				$(this).parent().show();
			} else if ($price == 1) {
				if (toLimit > 6) {
					$(this).parent().hide();
				}
			} else if ($price == 2) {
				if (toLimit > 8 || toLimit <= 6) {
					$(this).parent().hide();
				}
			} else if ($price == 3) {
				if (toLimit > 12 || toLimit <= 8) {
					$(this).parent().hide();
				}
			} else if ($price == 4) {
				if (toLimit > 15 || toLimit <= 12) {
					$(this).parent().hide();
				}
			} else if ($price == 5) {
				if (toLimit > 18 || toLimit <= 15) {
					$(this).parent().hide();
				}
			} else if ($price == 6) {
				if (toLimit > 22 || toLimit <= 18) {
					$(this).parent().hide();
				}
			} else if ($price == 7) {
				if (toLimit <= 22) {
					$(this).parent().hide();
				}
			}
		});
	}



    $(document).ready(function() {

		$("#matSearchFilter").keyup(function(){
			var matFilter = $(this).val();
			filterMat(matFilter);
		});
		$("#matSearchFilter").change(function(){
			var matLevel = $(this).parent().attr('price')
			$('.matItem').hide();
			$(".size[data-size*='small']");
		});
		$(".searchMat").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$(".levelFilter").val(0);
			$('.matParent').each(function(index, element) {
				$(element).toggle($(element).find('.titleMat').text().toLowerCase().indexOf(value) > -1)
			})
		});
	
	
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#matSearch tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	
		$(".levelFilter").change(function() {
			$('input.searchMat').val('');
			var filtOpt = $(this).val();
			if (filtOpt > 0) {
				$('.matParent').each(function(index, element) {
					if ($(element).attr('level') == filtOpt) {
						$(element).show();
					} else {
						$(element).hide();
					}
				});
			}
		});

	get_price_levels();

    });
