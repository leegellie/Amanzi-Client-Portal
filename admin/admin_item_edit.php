<?
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/invest.class.php');
require_once ('head_php.php');

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{ 
	$device = "mobile";
}
else{
	$device = "desktop";
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventory Item Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?
include('includes.php');
?>
<script src="js/inv_manager.js"></script>
<script src="qrscan/webqr.js"></script>
<script src="qrscan/llqrcode.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<style>
	.item_section_header {
		text-align: right;
		width: 100%;
	}	
	.items_section {
		margin-top: 40px;
	}
	.items_section.hide {
		display: none;
	}
	#view_item_section {
		max-width: 800px;
		margin-left: auto;
		margin-right: auto;
		margin-top: 50px;
	}
	#confirm_btn, #print_btn {
		float: right;
	}
	.blank_high {
		text-align: center;
	}
/* Custom css for	QR code scan */
	img {
		border:0;
	}
	#main {
		margin: 15px auto;
		background:white;
		overflow: auto;
		width: 100%;
	}
	#header {
		background:white;
		margin-bottom:15px;
	}
	#mainbody {
		background: white;
		width:100%;
		display:none;
	}
	#footer {
		background:white;
	}
	#v {
		width:320px;
		height:240px;
	}
	#qr-canvas {
		display:none;
	}
	#qrfile {
		width:320px;
		height:240px;
	}
	#mp1 {
		text-align:center;
		font-size:35px;
	}
	#imghelp {
		position:relative;
		left:0px;
		top:-160px;
		z-index:100;
		font:18px arial,sans-serif;
		background:#f0f0f0;
		margin-left:35px;
		margin-right:35px;
		padding-top:10px;
		padding-bottom:10px;
		border-radius:20px;
	}
	.selector {
		margin:0;
		padding:0;
		cursor:pointer;
		margin-bottom:-5px;
	}
	#outdiv	{
		width:320px;
		height:240px;
		border: solid;
		border-width: 3px 3px 3px 3px;
	}
/* 	#result{
			border: solid;
		border-width: 1px 1px 1px 1px;
		padding:20px;
		width:70%;
	} */
	#result {
		width: 100%;
		border: 1px solid #ced4da;
		border-radius: .25rem;
	}

	ul {
		margin-bottom:0;
		margin-right:40px;
	}
	li {
		display:inline;
		padding-right: 0.5em;
		padding-left: 0.5em;
		font-weight: bold;
		border-right: 1px solid #333333;
	}
	li a {
		text-decoration: none;
		color: black;
	}

	#footer a {
		color: black;
	}
	.tsel {
		padding:0;
		margin-left: auto;
    margin-right: auto;
    margin-top: 50px;
	}
	#webcamimg {
		float: left;
	}
	#qrimg {
		float: right;
	}
	@media (max-width: 1000px) {
		.mb-3 {
			margin-bottom: 0.2rem!important;
		}
	}
</style>
</head>
<body class="inventory" style="background-color: rgb(239, 234, 227);" >
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div id="loadOver"></div>
<div class="container">
	<div class="grid fluid">
		<h1></h1>
	</div>
</div>
<div class="container pageLook">
	<div class="grid fluid text-center">
		<h1>Select/Scan Material</h1>
	</div>
	<div class="row">
		<div class="col-12">
			<div id="marbgran-data" class="col-12 px-0">
				<div id="user-block" class="content">
					
					<div class="input-group-append">
							<div id="result" class="hidden"></div>
							<input type="text" id="item_id" class="form-control qrcode-text" placeholder="Item ID" onkeypress="return runScript(event)">
<!-- 							<label class="bg-success input-group-text"><i class="fas fa-qrcode"></i><input type="file" id="view_item_qr" accept="image/*" capture=environment onclick="return showQRIntro();" onchange="openQRCamera(this);" tabindex=-1></label> -->
							<span class="bg-success input-group-text" id="view_itemqr" onclick="viewitem_qr()">
									<i class="fas fa-qrcode"></i>
							</span>
							<span class="bg-primary input-group-text" id="view_item" onclick="viewitem('type')">
									<i class="fas fa-search"></i>
							</span>
					</div>
				</div>
			</div>
			<hr class="blue-gradient" style="height:3px">
<!-- 	start		 -->
			<div class="qrscan_section hidden">
				<table class="tsel" border="0">
					<tr>
					<td><span class="bg-success input-group-text" id="webcamimg" onclick="setwebcam()">
										<i class="fas fa-video"></i>
								</span></td>
					<td><span class="bg-primary input-group-text" id="qrimg" onclick="setimg()">
										<i class="fas fa-camera"></i>
								</span></td>
	<!-- 				<td><img class="selector" id="webcamimg" src="vid.png" onclick="setwebcam()" align="left" /></td>
					<td><img class="selector" id="qrimg" src="cam.png" onclick="setimg()" align="right"/></td></tr> -->
					<tr><td colspan="2" align="center">
					<div id="outdiv">
					</div></td></tr>
				</table>
				<div id="result"></div>
				<canvas id="qr-canvas" width="800" height="600"></canvas>
			</div>
<!-- 	end		 -->
			<form id="view_item_section" method="POST" class="hidden" enctype="multipart/form-data">
				<div class="container">  
					<input type="hidden" name="action" value="item_update"> 
					<input type="hidden" name="item_category_id" id="item_category_id" value=""> 
					<input type="hidden" name="item_type" id="item_type" value=""> 
					<input type="hidden" name="itemid" id="itemid" value=""/>
					<div class="row">
						<label class="col-md-3 mb-3" for="name">Item Name:</label>  
						<input class="col-md-9 mb-3 form-control" type="text" id="item_name" name="item_name" required>  
				  </div>  
				  <div class="row" id="itemcate_section">  
				  </div>  
					<div class="row">  
						<div class="col-md-4"> 
							<label class="col mb-3" for="qty">Qty:</label>  
							<div class="mb-3 flex">
								<input class="col form-control" id="qty" name="item_qty" type="number" value="0" readonly>  
								<div class="col btn btn-primary adj-btn" onclick="show_qty_adj();">Adjust</div>
							</div>
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="col-3 mb-3" for="lot">Lot:</label>  
							<input class="mb-3 form-control" id="lot" name="item_lot" type="text">  
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="col-6 mb-3" for="location">Location:</label>  
							<input class="mb-3 form-control" id="location" name="item_location" type="text" required>  
						</div>   
<!-- 					 </div>

					 <div class="row">   -->
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="height">Height:</label>  
							<input class="mb-3 form-control" id="height" name="item_height" type="text" value="0.00">  
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="width">Width:</label>  
							<input class="mb-3 form-control" id="width" name="item_width" type="text" value="0.00">  
						</div>  
						<div class=" col-4 height_l_section">  
							<label class="mb-6" for="height-l">Height L:</label>  
							<input class="mb-3 form-control" id="height_l" name="item_height-l" type="text" value="0.00">  
						</div>   
<!-- 					 </div>  

					 <div class="row">  -->
						<div class=" col-6 col-md-4 width_l_section">  
							<label class="mb-3" for="width-l">Width L:</label>  
							<input class="mb-3 form-control" id="width_l" name="item_width-l" type="text" value="0.00">  
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="sqft">SqFt:</label>  
							<input class="mb-3 form-control" id="sqft" name="sqft" type="number" value="0" step="any">  
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="cost">Cost:</label>  
							<input class="mb-3 form-control" id="cost" name="cost" type="text" value="0.00" required <?php if($_SESSION['access_level'] != 1 && $_SESSION['access_level'] != 6) echo 'readonly'; ?> >  
						</div>
<!-- 					 </div>  

					 <div class="row">  -->
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="cost">Price:</label>
							<input class="mb-3 form-control" id="price" name="price" type="text" value="0.00" required <?php if($_SESSION['access_level'] != 1 && $_SESSION['access_level'] != 6) echo 'readonly'; ?>>  
						</div>  
						<div class=" col-6 col-md-4">  
							<label class="mb-3" for="tiedto">Tied to:</label>  
							<input class="mb-3 form-control" id="tied_to" name="tiedto" type="number" <?php if($_SESSION['access_level'] != 1 && $_SESSION['access_level'] != 6 && $_SESSION['access_level'] != 2) echo 'readonly'; ?>>  
						</div>
						<hr>
						<div class="col-md-4">  
							<div class="row" id="supplier_section">  
							</div> 
<!-- 								<label class="col-6 mb-3" for="supplier">Supplier:</label>  
							<input class="mb-3 form-control" id="supplier" name="supplier" type="text">   -->
						</div>
<!-- 					</div>
					<div class="row"> -->
						<div class="col-md-4"> 
							<div class="row">
								<label class="col-8 col-md-9 mb-3 d-inline" for="ordernum">Order Number:</label>  
								<input class="col-4 col-md-12 mb-3 d-inline form-control" id="order_number" name="ordernum" type="number" value="0">  
							</div>
						</div>    
						<div class="col-6 col-md-4">
							<label class="col-md-9 mb-3" for="orderdate">Date Ordered:</label>  
							<input type="datetime-local" id="date_ordered" name="orderdate" class="mb-3 form-control" required>
<!-- 								<input type="text" class="form-control mmm"> -->
						</div>
						<div class="col-6 col-md-4">  
							<label class="col-md-9 mb-3" for="receivedate">Date Received:</label>  
							<input type="datetime-local" id="date_received" name="receivedate" class="mb-3 form-control" required>
						</div>  
					</div>  
					<div class="row">
						<div class=" col-12">  
							<label class="mb-3" for="image">Image:</label>  
							<input class="mb-3" id="image" name="image" type="file">  
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-primary ml-3" id="confirm_btn" onclick="update_item()"><i class="fas fa-edit mr-0 ml-0"></i>Update</button>
				<button type="button" class="btn btn-success ml-3" id="print_btn" onclick="print_item()"><i class="fas fa-print mr-0 ml-0"></i>Print</button>
			</form>
	</div>
</div>
<? 
include ('footer.php');
?>	
<!-- ADJUST MODAL FOR UPDATE QTY -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="adjust-qty-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="hide_qty_adj_md()"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Update the QTY</h5>
      </div>
			<div class="modal-body">
				<div class="row">
					<label class="col-3 mb-3" for="ordernum">Qty:</label>  
					<input class="col-8 mb-3" id="qty_update" name="qty" type="number" value="0" data-overlay="false">  
				</div>
				<div class="row">
					<label class="col-3 mb-3" for="orderdate">Reason:</label>  
					<textarea id="qty_reason" name="reason" class="col-8 mb-3" required></textarea>
				</div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default update_qty_btn" onclick="confirm_update_itemqty()">Yes</button>
        <button type="button" class="btn btn-primary" onclick="hide_qty_adj_md()">No</button>
      </div>
    </div>
  </div>
</div>
	
<!-- VIEW ITEM MODAL -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view_item-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="hide_item_md()"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Preview the Item</h5>
      </div>
			<div class="modal-body">
				<iframe name="frame1" id="qrcode_iframe" src="" width="100%" height="200px"></iframe>
<!-- 				<div id="dymo-editor">
					<div id="barcodeYup"></div>
				</div> -->
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="hide_item_md()"><i class="fas fa-close mr-0 ml-0"></i>Close</button>
				
<!--         <button type="button" class="btn btn-primary" onclick="hide_item_md()">No</button> -->
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	load();
});

</script>
</body>
</html>
					
