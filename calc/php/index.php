<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?PHP
$brand = '';
require_once('db_connect.php');


echo '<select id="brandSelect" name="Brand"><option>Select</option>';

foreach($conn->query("SELECT DISTINCT brand FROM category ORDER BY brand ASC") as $row) {
	echo '<option value="' . $row['brand'] . '">' . $row['brand'] .'</option>';
	$GLOBALS['brand'] = $row['brand'];
	
}

echo '</select>';
echo '<div id="typeHolder">';

echo '<select id="typeSelect" name="Type"><option>Select</option>';
foreach($conn->query("SELECT id FROM category WHERE brand='$brand'") as $row) {
	echo '<option value="' . $row['id'] . '">' . $row['id'] .'</option>';
}
echo '</select>';

?>
<script>
//function removeType(){
//	if (document.getElementById('typeHolder').length()) {
//		document.getElementById('typeHolder').innerHTML = "";
//	}
//}
//removeType();
</script>
<?
echo '</div>';

echo "<table style='border: solid 1px black; width:100%'>";
echo "<tr><th>Brand</th><th>Line</th><th>Class</th><th>Name</th><th>Price</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    } 
}




try {
    $stmt = $conn->prepare("SELECT category.brand, category.class, category.group, quartz.name, quartz.price_3 FROM quartz JOIN category ON quartz.cat_id = category.id");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

?>

</body>
</html>