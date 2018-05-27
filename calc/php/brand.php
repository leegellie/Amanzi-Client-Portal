<?
require_once('db_connect.php');
require_once('classes.php');
$name = $_POST['name'];
//echo "<table style='border: solid 1px black; width:100%'>";
//echo "<tr><th>brand</th><th>price1</th><th>price2</th><th>price3</th><th>disc1</th><th>disc2</th><th>disc3</th><th>discA</th><th>name</th><th>p1</th><th>p2</th><th>p3</th><th>d1</th><th>d2</th><th>d3</th><th>dA</th></tr>";
$sql = "
	SELECT  category.brand, 
			category.price_1, 
			category.price_2, 
			category.price_3, 
			category.discount_1, 
			category.discount_2, 
			category.discount_3, 
			category.discount_all, 
			category.class AS mClass, 
			quartz2.name, 
			quartz2.price_1 AS p1, 
			quartz2.price_2 AS p2, 
			quartz2.price_3 AS p3, 
			quartz2.discount_1 AS d1, 
			quartz2.discount_2 AS d2, 
			quartz2.discount_3 AS d3, 
			quartz2.discount_all AS da,
			quartz2.notes, 
			quartz2.image 
	FROM 	quartz2
	JOIN 	category 
	ON 		quartz2.cat_id = category.id 
	WHERE 	category.brand = ?
	ORDER BY category.class, quartz2.name ASC";
$listQuery = $conn->prepare($sql);
//$listQuery->setFetchMode(PDO::FETCH_OBJ);
echo '<input class="form-control form-control-lg col-12 col-md-6 m-auto" id="myInput" type="text" placeholder="Search...">';
echo '<table id="matSearch" class="col-12 col-md-6 m-auto"><tbody>';
if ($listQuery->execute(array($name))) {
	while ($r = $listQuery->fetch(PDO::FETCH_ASSOC)){
		echo '<tr class="matRow"><td class="matClass text-dark">';
		echo $r[mClass];
		echo '</td><td class="matSelect">';
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
		echo '" dis1="';
		echo $r[discount_1];
		echo '" dis2="';
		echo $r[discount_2];
		echo '" dis3="';
		echo $r[discount_3];
		echo '" disa="';
		echo $r[discount_all];
		echo '" gp1="';
		echo $r[p1];
		echo '" gp2="';
		echo $r[p2];
		echo '" gp3="';
		echo $r[p3];
		echo '" gd1="';
		echo $r[d1];
		echo '" gd2="';
		echo $r[d2];
		echo '" gd3="';
		echo $r[d3];
		echo '" gda="';
		echo $r[da];
		echo '" notes="';
		echo $r[notes];
		echo '" onClick="compileType(this)">Select</button></td></tr>';
	}
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