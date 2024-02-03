<?php
$NO_REDIRECT='1';
require_once("common.php");

if(isset($_POST["response"])) $response = $_POST["response"];
else if(isset($_GET["response"])) $response = $_GET["response"];
else $response = "";

$result = 'false'; //0~0~0~0";

if($response == "UNIQUE_CODE") 
{
	if(isset($_GET["id"]) && isset($_GET['val']) && isset($_GET['mode']))
	{
		$id = $_GET["id"];
		$val = trim($_GET["val"]);
		$mode = $_GET['mode'];
		
		if($mode == 'USERS')
		{  
			$pk_fld = 'iUserID';
			$code_fld = 'vUName';
			$tbl = 'users';
		}

		$flag = IsUniqueEntry($pk_fld, $id, $code_fld, $val, $tbl);
		$result = ($flag=='0')? '0': '1';
	}
}

else if($response == 'UPDATE_STATUS')
{
	if(isset($_GET["mode"]) && isset($_GET["status"]) && isset($_GET["id"]))
	{
		$mode = $_GET["mode"];
		$status = $_GET["status"];
		$id = $_GET["id"];

		$valid_modes = array('USERS','VEHICLE_TYPE');
		if(in_array($mode, $valid_modes))
		{
			if($mode == 'USERS')
			{
				$pk_fld = 'iUserID';
				$tbl = 'users';
				$msg = 'User';
			}elseif ($mode == 'VEHICLE_TYPE') {
				$pk_fld = 'iVTypeID';
				$tbl = 'gen_vehicle_type';
				$msg = 'Vehicle type';
			}

			$q = "update ".$tbl." set cStatus='$status' where ".$pk_fld."=".$id;
			$r = sql_query($q, 'AJX.68');

			if(sql_affected_rows())
			{
				$str = GetStatusImageString($mode, $status, $id);
				$result = "$str~$msg Status Has Been Changed";
			}	// */
		}
	}
}elseif ($response=='GET_TO_LOCATIONS') {
	$html='';
	$cmbfrom=(isset($_POST['cmbfrom']))?db_input2($_POST['cmbfrom']):'';
	$q="select iLocationID,vName from location where cStatus='A' and iLocationID not in($cmbfrom)   order by vName";
	$r=sql_query($q,"ERR.444");
	$html.='<option value="">--select--</option>';
	while (list($locid,$name)=sql_fetch_row($r)) {
		$html.='<option value="' . $locid . '">' . $name . '</option>';		
	}
	echo $html;
	exit;
}elseif ($response=='GET_TIME_DROPDOWN') {
	date_default_timezone_set('Asia/Kolkata');
	$selected_date=$_POST['sdate'];
	
	// Get the current date and time
	$current_date = date('Y-m-d');
	$current_time = strtotime(date('h:i A'));

	// Get the time one hour from now
$one_hour_later = strtotime('+2 hour', $current_time);
	
	// Example of selected date from user input (you should replace this with your actual selected date)
	//$selected_date = '2023-07-25'; // Replace this with your selected date
	
	// Convert the selected date to timestamp
	$selected_date_timestamp = strtotime($selected_date);
	
	// If the selected date is greater than today's date, allow all times
	$allow_all_times = ($selected_date_timestamp > strtotime($current_date));
	
	// Loop through the time array and create the select options
	$html='';
	foreach ($TIME_CAR_ARR as $time_value) {
		if ($allow_all_times || strtotime($time_value) > $one_hour_later) {
			$html.= '<option value="' . $time_value . '">' . $time_value . '</option>';
		} else {
			//$html.= '<option value="' . $time_value . '" disabled>' . $time_value . ' </option>';
		}
	}

	echo $html;
	exit;
	//echo '</select>';

	
}elseif ($response='APPLY_PRICE_FILTER') {
	$from_r=$_POST['from_r'];
	$to_r=$_POST['to_r'];
	DFA($_POST);
	exit;

}

echo $result;
exit;

?>
