<?

require_once('db_connect.php');

class selectBrand {
	public $brand, $option;
	
	public function __construct() {
		$this->option = '<option value=' . $this->brand . '>' . $this->brand . '</option>';
	}
}

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


?>