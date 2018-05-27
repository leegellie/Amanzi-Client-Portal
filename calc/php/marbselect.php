<?
require_once('db_connect.php');
require_once('classes.php');
//echo "<table style='border: solid 1px black; width:100%'>";
//echo "<tr><th>brand</th><th>price1</th><th>price2</th><th>price3</th><th>disc1</th><th>disc2</th><th>disc3</th><th>discA</th><th>name</th><th>p1</th><th>p2</th><th>p3</th><th>d1</th><th>d2</th><th>d3</th><th>dA</th></tr>";
$sql = "
	SELECT  marbgran.id, 
			marbgran.name, 
			marbgran.price_1, 
			marbgran.price_2, 
			marbgran.price_3, 
			marbgran.price_4, 
			marbgran.price_5, 
			marbgran.price_6, 
			marbgran.price_7, 
			marbgran.comm_1, 
			marbgran.comm_2, 
			marbgran.comm_3, 
			marbgran.comm_4, 
			marbgran.comm_5, 
			marbgran.comm_6, 
			marbgran.comm_6, 
			marbgran.comm_7, 
			marbgran.image
	FROM 	marbgran 
	WHERE 	1 
	ORDER BY marbgran.name ASC";
$listQuery = $conn->prepare($sql);
//$listQuery->setFetchMode(PDO::FETCH_OBJ);
echo '<input class="form-control form-control-lg col-12 col-md-6 m-auto" id="myInput" type="text" placeholder="Search...">';
echo '<table id="matSearch" class="col-12 col-md-6 m-auto"><tbody>';
$listQuery->execute();
	while ($r = $listQuery->fetch(PDO::FETCH_ASSOC)){
		echo '<tr class="matRow"><td class="matSelect">';
		echo $r[name];
		echo '</td><td class="matButton"><button class="btn btn-lg matChoice" style="background-image: url(';
		echo $r[image];
		echo ');" mName="';
		echo $r[name];
		echo '" mat1="';
		echo $r[price_1];
		echo '" mat2="';
		echo $r[price_2];
		echo '" mat3="';
		echo $r[price_3];
		echo '" mat4="';
		echo $r[price_4];
		echo '" mat5="';
		echo $r[price_5];
		echo '" mat6="';
		echo $r[price_6];
		echo '" mat7="';
		echo $r[price_7];
		echo '" comm1="';
		echo $r[comm_1];
		echo '" comm2="';
		echo $r[comm_2];
		echo '" comm3="';
		echo $r[comm_3];
		echo '" comm4="';
		echo $r[comm_4];
		echo '" comm5="';
		echo $r[comm_5];
		echo '" comm6="';
		echo $r[comm_6];
		echo '" comm7="';
		echo $r[comm_7];
		echo '" notes="';
		echo $r[notes];
		echo '" onClick="compileName(this)">Select</button></td></tr>';
	}


echo '</tbody></table>';

echo '
<script>
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#matSearch tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
</script>
';


//foreach(new TableRows(new RecursiveArrayIterator($listQuery->fetchAll())) as $k=>$v) {
//	echo $v;
//}
//echo "</table>";


?>