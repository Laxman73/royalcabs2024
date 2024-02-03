<?php
include_once "includes/common_front.php";
// DFA($_POST);
// exit;

$DISP_CAT_ID = 1; // Car
$DIPOSAL_ID = 3;
$Loc_ds=0;
$dataArray = array();
$execute_query=true;

$cmbfrom=(isset($_POST['cmbfrom']))?db_input($_POST['cmbfrom']):'';
$cmbto=(isset($_POST['cmbto']))?db_input($_POST['cmbto']):'';
$txtdate=(isset($_POST['txtdate']))?db_input($_POST['txtdate']):'';
$cmbtime=(isset($_POST['cmbtime']))?db_input($_POST['cmbtime']):'';
$cmbpasses=(isset($_POST['cmbpasses']))?db_input($_POST['cmbpasses']):'';
$cartype=(isset($_POST['cartype']))?db_input($_POST['cartype']):'';
$sort=(isset($_POST['sort']))?db_input($_POST['sort']):'';
$txtkeyword=(isset($_POST['txtkeyword']))?db_input($_POST['txtkeyword']):'';
$from_r=(isset($_POST['from_r']))?db_input($_POST['from_r']):'';
$to_r=(isset($_POST['to_r']))?db_input($_POST['to_r']):'';
$cond='';
$orderby='ORDER BY v.iVehicleID DESC';
if (!empty($txtkeyword)) {
  $txtkeyword = strtolower($txtkeyword);
  $cond .= " and (LOWER(v.vName) LIKE '%" . $txtkeyword . "%')";
  $execute_query = true;
}

if(!empty($sort)){
	if($sort==1){
		$orderby='order by tar.fBaseFare DESC';

	}else if ($sort==2) {
		$orderby='order by tar.fBaseFare ASC';
	}
}

if (!empty($cartype)) {
	$cond .= " and gvt.iVTypeID='$cartype' ";
	$execute_query = true;
}

if (!empty($from_r) && !empty($to_r)) {
	$cond .= " and tar.fBaseFare between $from_r and $to_r ";
	$execute_query = true;
}



if (!empty($cmbfrom) && !empty($cmbto)){
//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
//$cartArr['data']['location']['cmbto']=$cmbto;
$Loc_ds=GetTotalDistance($cmbfrom,$cmbto,28);
}

//$Loc_ds=100;

$_q="SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare,tar.fBaseDistanceInKM as priceperkm, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs 
		FROM vehicle AS v 
		LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
		LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
		LEFT JOIN tariff AS tar ON (tar.iVehicleID=v.iVehicleID AND tar.iVCatID=$DISP_CAT_ID) 
		WHERE 1 $cond 
		GROUP BY v.iVehicleID 
		HAVING VCatIDs LIKE '%~$DISP_CAT_ID~%' 
		 $orderby ";

		

		
$r=sql_query($_q,"ERR.204");
$dataArray = sql_num_rows($r) > 0 ? sql_get_data($r) : $dataArray;
$html='';


						foreach ($dataArray as $i => $row) {
							$cats = explode("~", $row->VCatIDs);
							$cats = array_values(array_filter($cats));
							$price=$row->fBaseFare;
							$file_pic = $row->vPic;
								$src = NOIMAGE;
								if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
										$src = VEHICLE_IMG_PATH . $file_pic;
							if ($execute_query) {
								$price=GetFinalPrice($Loc_ds,$row->iVehicleID);
								if(URL_REWRITTING=='ON') $URL_CARLDISPLAY = 'summary.php';
								else $URL_CARLDISPLAY = SITE_ADDRESS.'car_display.php?id='.$row->iVehicleID;


								$html .= '<div class="card mt-40">';
								 if (in_array($DIPOSAL_ID, $cats)) {
								  $html.='<div class="card-tag"><i class="Car-Key"></i><span class="tag-text">Available for disposal</span></div>'; 
								}
								$html.='<div class="d-flex">
									<img src="'.$src.'" class="mt-10">
									<div class="container">';
										$html.='<br>';
										 if ($row->cRecommended == 'Y') { $html.='<span class="card-tag1">Recommended</span>'; } 
										 if (false) { $html.='<span class="card-tag2">Special offer</span>'; } 
										$html.='<br><br>';
										$html.='<span class="card-head">'.($row->vName).'</span>';
										$html.='<div class="row">';
											$html.='<div class="column-res">';
												$html.='<i class="seat"></i><span>'. ($row->vSeats).'seaters</span>';
											$html.='</div>';
											$html.='<div class="column-res">';
												$html.='<i class="car-small"></i><span>'.($row->TypeName).'</span>';
											$html.='</div>';
										$html.='</div>';
										$html.='<div class="row">';
											// $html.='<div class="column-res">';
											// $fuel_pump=(!empty($FUEL_ARR[$row->iVFuelID])) ? $FUEL_ARR[$row->iVFuelID] : '- Na -';
											// 	$html.='<i class="fuel-pump"></i><span>'.$fuel_pump.'priceperkm</span>';
											// $html.='</div>';
											// $html.='<div class="column-res">';
											// 	 if ($row->cAirBags == 'Y') { $html.='<i class="airbag"></i><span>Air bags</span>'; } 
											// $html.='</div>';
										$html.='</div>';
										$html.='<br>';
									$html.='</div>';
									$html.='<div class="rate-div">';
										if (false) { $html.='<s class="strike-text1">RS.&nbsp;6000</s>';} else $html.='&nbsp;'; 
										$html.='<br>';

										$html.='<span class="card-head1">Rs '.$price.'</span>';
										$html.='<br>';
										$html.='<span class="card-p">Price for night differs</span>';
										//<a href="<?php echo $URL_CARLDISPLAY . '?cmbfrom=' . $cmbfrom . '&cmbto=' . $cmbto . '&txtdate=' . $txtdate . '&cmbtime=' . $cmbtime . '&cmbpasses=' . $cmbpasses.'&vehicle_id='.$row->iVehicleID; ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a>
										$html.='<a href="'. $URL_CARLDISPLAY.'?cmbfrom='.$cmbfrom.'&cmbto='.$cmbto.'&txtdate=' . $txtdate . '&cmbtime=' . $cmbtime . '&cmbpasses=' . $cmbpasses.'&vehicle_id='.$row->iVehicleID.'"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a>
									</div>
								</div>
							</div>';
						}
					}
						// echo $_q;
// exit;

echo $html;
exit;
?>