<?PHP
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
require_once (__DIR__ . '/../include/class/materials.class.php');
/*
USER AJAX REQUESTS 
*/
$action = trim(htmlspecialchars($_POST['action']));

if ($action=="inst_pay") {
  unset($_POST['action']);
	$first_date = strtotime($_POST['selweek']);
  $firstDate = date('Y-m-d',$first_date);
  $lastDate = date('Y-m-d',strtotime('+6 days', strtotime($firstDate)));
	$get_inst_log = new project_action;
  
  $tmp = array();
	$results = $get_inst_log -> get_inst_log($firstDate,$lastDate);
	
	//GROUP THE Data BY Installer
	foreach($results as $result) {
		$tmp[$result['inst_log_inst_id']][] = $result;
	}
	$_chosenweekData = array();
	foreach($tmp as $type => $labels) {
		$_chosenweekData[] = array(
			'inst_log_inst_id' => $type,
			'detail' => $labels
		);
	}
  
  $ind = 0;
  $html =  '';
  foreach($_chosenweekData as $res)
  {
      $totalsqft = array_sum(array_column($res['detail'], 'inst_log_sqft')); 
      $totalpay = array_sum(array_column($res['detail'], 'inst_log_total')); 
    
      if($ind % 3 == 0) {
        $html .=  '<div class="row">';
      }
      $html .= '  <div class="col-4 TableContainer">';
      $html .= '    <table class="TableHolder">';
      $html .= '      <tr>';
      $html .= '        <th style="white-space: nowrap;">'. $res['inst_log_inst_id'] .' - '. $res['detail'][0]['fname']. ' ' .$res['detail'][0]['lname'] .'</th>';
      $html .= '        <th>'. $totalsqft .'sf</th>';
      $html .= '        <th></th>';
      $html .= '        <th>$'. $totalpay .'</th>';
      $html .= '      </tr>';
      
      foreach($res['detail'] as $row){
        $html .= '    <tr>';
        $html .= '      <th onclick="viewThisProject('. $row['id'] .','. $row['uid'] .')">'. $row['order_num'] .'</th>' ;
        $html .= '      <td>'. $row['inst_log_sqft'] .'</td>' ;
        if($row['inst_log_payroll'] == 1){
          $html .= '      <td style="position:unset;"><input type="checkbox" id="my_checkbox'.$row['inst_log_id'].'" value="" onclick="updatePay('.$row['inst_log_id'].')" checked="checked"/></td>' ;
        }else{
          $html .= '      <td style="position:unset;"><input type="checkbox" id="my_checkbox'.$row['inst_log_id'].'" value="" onclick="updatePay('.$row['inst_log_id'].')" /></td>' ;
        }
        $html .= '      <td> $'. $row['inst_log_total'] .'</td>' ;
        $html .= '    </tr>' ;
      }
      $html .= '    </table>';
      $html .= '  </div>';
      if(($ind+1) % 3 == 0) {
        $html .= '  </div>';
      }
      $ind++;
  }
  echo $html;
}

if ($action=="update_payroll") {
  $inst_id = $_POST['instid'];
  $status = $_POST['status'];
  $inst_pay = new project_action;
  $inst_pay -> update_payroll($inst_id,$status);
  return "success";
}


if ($action=="") {
	echo "I got nothin'\n";
	print_r($_POST);
}



?>