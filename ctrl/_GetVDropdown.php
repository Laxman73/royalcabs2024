<?php
$NO_REDIRECT=1;
include "../includes/common.php";

$cmbcatID=db_input2($_POST['catID']);
$cmbType=db_input2($_POST['cmbType']);
$VEHICLE_ARR1=GetXArrFromYID("select distinct(iVehicleID) from vehicle_cat_assoc where iVCatID='$cmbcatID' ");
if(!empty($VEHICLE_ARR1)){
$q="select iVehicleID,vName from vehicle where iVTypeID='$cmbType' and iVehicleID in ('".implode("','", $VEHICLE_ARR1)."') ";
$r=sql_query($q);
if(sql_num_rows($r)){
	while(list($id,$name)=sql_fetch_row($r)){
		$VEHICLE_ARR[]=array('id'=>$id,'name'=>$name);

	}
}
header('Content-Type: application/json');
echo json_encode($VEHICLE_ARR);
exit;
}else{
$q="select iVehicleID,vName from vehicle where iVTypeID='$cmbType'  ";
$r=sql_query($q);
if(sql_num_rows($r)){
	while(list($id,$name)=sql_fetch_row($r)){
		$VEHICLE_ARR[]=array('id'=>$id,'name'=>$name);

	}
}
header('Content-Type: application/json');
echo json_encode($VEHICLE_ARR);
exit;
}




?>