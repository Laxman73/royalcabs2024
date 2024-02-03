<?php
include_once "includes/common_front.php";

$catID=$_POST['vehicle_type'];

$CAR_ARR = GetXArrFromYID("select v.iVehicleID,v.vName from vehicle v inner join vehicle_cat_assoc vc on v.iVehicleID=vc.iVehicleID and vc.iVCatID=$catID and v.cStatus='A'", '3');
header('Content-Type: application/json');
echo json_encode($CAR_ARR);
exit;



?>